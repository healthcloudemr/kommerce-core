<?php
namespace inklabs\kommerce\Lib;

use inklabs\kommerce\Service;
use inklabs\kommerce\Lib;

class FactoryService
{
    /** @var Lib\CartCalculatorInterface */
    private $cartCalculator;

    /** @var Lib\PricingInterface */
    private $pricing;

    /** @var FactoryRepository */
    private $factoryRepository;

    public function __construct(
        FactoryRepository $factoryRepository,
        Lib\CartCalculatorInterface $cartCalculator
    ) {
        $this->cartCalculator = $cartCalculator;
        $this->pricing = $cartCalculator->getPricing();
        $this->factoryRepository = $factoryRepository;
    }

    /**
     * @param FactoryRepository $factoryRepository
     * @param CartCalculatorInterface $cartCalculator
     * @return FactoryService
     */
    public static function getInstance(
        FactoryRepository $factoryRepository,
        Lib\CartCalculatorInterface $cartCalculator
    ) {
        static $factoryService = null;

        if ($factoryService === null) {
            $factoryService = new static($factoryRepository, $cartCalculator);
        }

        return $factoryService;
    }

    /**
     * @return Service\Attribute
     */
    public function getAttribute()
    {
        return new Service\Attribute($this->factoryRepository->getAttribute());
    }

    /**
     * @return Service\AttributeValue
     */
    public function getAttributeValue()
    {
        return new Service\AttributeValue($this->factoryRepository->getAttributeValue());
    }

    /**
     * @return Service\Cart
     */
    public function getCart()
    {
        return new Service\Cart(
            $this->factoryRepository->getCart(),
            $this->factoryRepository->getProduct(),
            $this->factoryRepository->getOptionProduct(),
            $this->factoryRepository->getOptionValue(),
            $this->factoryRepository->getTextOption(),
            $this->factoryRepository->getCoupon(),
            $this->factoryRepository->getOrder(),
            $this->factoryRepository->getUser(),
            $this->cartCalculator
        );
    }

    /**
     * @return Service\CartPriceRule
     */
    public function getCartPriceRule()
    {
        return new Service\CartPriceRule($this->factoryRepository->getCartPriceRule());
    }

    /**
     * @return Service\CatalogPromotion
     */
    public function getCatalogPromotion()
    {
        return new Service\CatalogPromotion($this->factoryRepository->getCatalogPromotion());
    }

    /**
     * @return Service\Coupon
     */
    public function getCoupon()
    {
        return new Service\Coupon($this->factoryRepository->getCoupon());
    }

    /**
     * @return Service\Image
     */
    public function getImage()
    {
        return new Service\Image(
            $this->factoryRepository->getImage(),
            $this->factoryRepository->getProduct()
        );
    }

    /**
     * @return Service\Import\Order
     */
    public function getImportOrder()
    {
        return new Service\Import\Order(
            $this->factoryRepository->getOrder(),
            $this->factoryRepository->getUser()
        );
    }

    /**
     * @return Service\Import\OrderItem
     */
    public function getImportOrderItem()
    {
        return new Service\Import\OrderItem(
            $this->factoryRepository->getOrder(),
            $this->factoryRepository->getOrderItem(),
            $this->factoryRepository->getProduct()
        );
    }

    /**
     * @return Service\Import\User
     */
    public function getImportUser()
    {
        return new Service\Import\User($this->factoryRepository->getUser());
    }

    /**
     * @return Service\Order
     */
    public function getOrder()
    {
        return new Service\Order($this->factoryRepository->getOrder());
    }

    /**
     * @return Service\Product
     */
    public function getProduct()
    {
        return new Service\Product(
            $this->factoryRepository->getProduct(),
            $this->factoryRepository->getTag(),
            $this->factoryRepository->getImage(),
            $this->pricing
        );
    }

    /**
     * @return Service\Tag
     */
    public function getTag()
    {
        return new Service\Tag(
            $this->factoryRepository->getTag(),
            $this->pricing
        );
    }

    /**
     * @return Service\TaxRate
     */
    public function getTaxRate()
    {
        return new Service\TaxRate($this->factoryRepository->getTaxRate());
    }

    /**
     * @return Service\User
     */
    public function getUser()
    {
        return new Service\User($this->factoryRepository->getUser(), $this->factoryRepository->getUserLogin());
    }
}
