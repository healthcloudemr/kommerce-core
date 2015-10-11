<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\EntityRepository\RepositoryFactoryInterface;
use inklabs\kommerce\Lib\CartCalculatorInterface;
use inklabs\kommerce\EntityRepository\RepositoryFactory;

class ServiceFactory
{
    /** @var CartCalculatorInterface */
    protected $cartCalculator;

    /** @var RepositoryFactory */
    protected $repositoryFactory;

    public function __construct(
        RepositoryFactoryInterface $repositoryFactory,
        CartCalculatorInterface $cartCalculator
    ) {
        $this->cartCalculator = $cartCalculator;
        $this->repositoryFactory = $repositoryFactory;
    }

    /**
     * @param RepositoryFactory $repositoryFactory
     * @param CartCalculatorInterface $cartCalculator
     * @return ServiceFactory
     */
    public static function getInstance(
        RepositoryFactory $repositoryFactory,
        CartCalculatorInterface $cartCalculator
    ) {
        static $serviceFactory = null;

        if ($serviceFactory === null) {
            $serviceFactory = new static($repositoryFactory, $cartCalculator);
        }

        return $serviceFactory;
    }

    /**
     * @return AttributeService
     */
    public function getAttribute()
    {
        return new AttributeService($this->repositoryFactory->getAttributeRepository());
    }

    /**
     * @return AttributeValueService
     */
    public function getAttributeValue()
    {
        return new AttributeValueService($this->repositoryFactory->getAttributeValueRepository());
    }

    /**
     * @return CartService
     */
    public function getCart()
    {
        return new CartService(
            $this->repositoryFactory->getCartRepository(),
            $this->repositoryFactory->getProductRepository(),
            $this->repositoryFactory->getOptionProductRepository(),
            $this->repositoryFactory->getOptionValueRepository(),
            $this->repositoryFactory->getTextOptionRepository(),
            $this->repositoryFactory->getCouponRepository(),
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getUserRepository(),
            $this->cartCalculator
        );
    }

    /**
     * @return CartPriceRuleService
     */
    public function getCartPriceRule()
    {
        return new CartPriceRuleService($this->repositoryFactory->getCartPriceRuleRepository());
    }

    /**
     * @return CatalogPromotionService
     */
    public function getCatalogPromotion()
    {
        return new CatalogPromotionService($this->repositoryFactory->getCatalogPromotionRepository());
    }

    /**
     * @return CouponService
     */
    public function getCoupon()
    {
        return new CouponService($this->repositoryFactory->getCouponRepository());
    }

    /**
     * @return ImageService
     */
    public function getImage()
    {
        return new ImageService(
            $this->repositoryFactory->getImageRepository(),
            $this->repositoryFactory->getProductRepository()
        );
    }

    /**
     * @return Import\ImportOrderService
     */
    public function getImportOrder()
    {
        return new Import\ImportOrderService(
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getUserRepository()
        );
    }

    /**
     * @return Import\ImportOrderItemService
     */
    public function getImportOrderItem()
    {
        return new Import\ImportOrderItemService(
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getOrderItemRepository(),
            $this->repositoryFactory->getProductRepository()
        );
    }

    /**
     * @return Import\ImportPaymentService
     */
    public function getImportPayment()
    {
        return new Import\ImportPaymentService(
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getPaymentRepository()
        );
    }

    /**
     * @return Import\ImportUserService
     */
    public function getImportUser()
    {
        return new Import\ImportUserService($this->repositoryFactory->getUserRepository());
    }

    /**
     * @return OptionService
     */
    public function getOption()
    {
        return new OptionService($this->repositoryFactory->getOptionRepository());
    }

    /**
     * @return OrderService
     */
    public function getOrder()
    {
        return new OrderService(
            $this->repositoryFactory->getOrderRepository(),
            $this->repositoryFactory->getProductRepository()
        );
    }

    /**
     * @return ProductService
     */
    public function getProduct()
    {
        return new ProductService(
            $this->repositoryFactory->getProductRepository(),
            $this->repositoryFactory->getTagRepository(),
            $this->repositoryFactory->getImageRepository()
        );
    }

    /**
     * @return TagService
     */
    public function getTagService()
    {
        return new TagService($this->repositoryFactory->getTagRepository());
    }

    /**
     * @return TaxRateService
     */
    public function getTaxRate()
    {
        return new TaxRateService($this->repositoryFactory->getTaxRateRepository());
    }

    /**
     * @return UserService
     */
    public function getUser()
    {
        return new UserService(
            $this->repositoryFactory->getUserRepository(),
            $this->repositoryFactory->getUserLoginRepository()
        );
    }
}