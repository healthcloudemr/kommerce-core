<?php
namespace inklabs\kommerce\Lib\Query;

use inklabs\kommerce\Lib\Command\PricingAwareInterface;
use inklabs\kommerce\Lib\Command\TagServiceAwareInterface;
use inklabs\kommerce\Lib\Pricing;
use inklabs\kommerce\Service\ServiceFactory;
use ReflectionClass;

class QueryBus implements QueryBusInterface
{
    /** @var ServiceFactory */
    private $serviceFactory;

    /** @var QueryHandlerInterface */
    private $handler;

    /** @var Pricing */
    private $pricing;

    public function __construct(
        ServiceFactory $serviceFactory,
        Pricing $pricing
    ) {
        $this->serviceFactory = $serviceFactory;
        $this->pricing = $pricing;
    }

    /**
     * @param ServiceFactory $serviceFactory
     * @param Pricing $pricing
     * @return QueryBus
     */
    public static function getInstance(ServiceFactory $serviceFactory, Pricing $pricing)
    {
        static $queryBus = null;

        if ($queryBus === null) {
            $queryBus = new static($serviceFactory, $pricing);
        }

        return $queryBus;
    }

    public function execute(QueryInterface $command)
    {
        $this->handler = $this->getHandler($command);
        return $this->handler->handle($command);
    }

    /**
     * @param QueryInterface $command
     * @return QueryHandlerInterface
     */
    private function getHandler(QueryInterface $command)
    {
        $handlerClassName = $this->getHandlerClassName($command);

        $constructorParameters = [];
        if (is_subclass_of($handlerClassName, TagServiceAwareInterface::class, true)) {
            $constructorParameters[] = $this->serviceFactory->getTagService();
        }

        if (is_subclass_of($handlerClassName, PricingAwareInterface::class, true)) {
            $constructorParameters[] = $this->pricing;
        }

        $reflection = new ReflectionClass($handlerClassName);
        if (! empty($constructorParameters)) {
            $handler = $reflection->newInstanceArgs($constructorParameters);
        } else {
            $handler = $reflection->newInstance();
        }

        return $handler;
    }

    /**
     * @param QueryInterface $command
     * @return string
     */
    private function getHandlerClassName(QueryInterface $command)
    {
        $className = get_class($command);
        $pieces = explode('\\', $className);

        $baseName = array_pop($pieces);
        $handlerBaseName = substr($baseName, 0, -7) . 'Handler';

        $pieces[] = 'Handler';
        $pieces[] = $handlerBaseName;

        return implode('\\', $pieces);
    }
}