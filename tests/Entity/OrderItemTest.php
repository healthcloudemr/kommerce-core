<?php
namespace inklabs\kommerce\Entity;

use Symfony\Component\Validator\Validation;

class OrderItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $catalogPromotion = new CatalogPromotion;
        $catalogPromotion->setName('20% OFF Everything');
        $catalogPromotion->setType(Promotion::TYPE_PERCENT);
        $catalogPromotion->setValue(20);

        $productQuantityDiscount = new ProductQuantityDiscount;
        $productQuantityDiscount->setType(Promotion::TYPE_EXACT);
        $productQuantityDiscount->setQuantity(2);
        $productQuantityDiscount->setValue(100);

        $optionProductQuantityDiscount = new ProductQuantityDiscount;
        $optionProductQuantityDiscount->setType(Promotion::TYPE_FIXED);
        $optionProductQuantityDiscount->setQuantity(2);
        $optionProductQuantityDiscount->setValue(100);

        $product = new Product;
        $product->setSku('sku');
        $product->setname('test name');
        $product->setUnitPrice(500);
        $product->setQuantity(10);
        $product->addProductQuantityDiscount($productQuantityDiscount);

        $optionProduct = new Product;
        $optionProduct->setUnitPrice(400);
        $optionProduct->addProductQuantityDiscount($optionProductQuantityDiscount);

        $price = new Price;
        $price->origUnitPrice = 1;
        $price->unitPrice = 1;
        $price->origQuantityPrice = 1;
        $price->quantityPrice = 1;
        $price->addCatalogPromotion($catalogPromotion);
        $price->addProductQuantityDiscount($productQuantityDiscount);
        $price->addProductQuantityDiscount($optionProductQuantityDiscount);

        $orderItem = new OrderItem($product, 2, $price);
        $orderItem->addOptionProduct($optionProduct);

        $order = new Order([$orderItem], new CartTotal);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $this->assertEmpty($validator->validate($orderItem));
        $this->assertSame(2, $orderItem->getQuantity());
        $this->assertSame('sku', $orderItem->getProductSku());
        $this->assertSame('test name', $orderItem->getProductName());
        $this->assertSame(
            '20% OFF Everything, Buy 2 or more for $1.00 each, Buy 2 or more for $1.00 off',
            $orderItem->getDiscountNames()
        );
        $this->assertSame(null, $orderItem->getId());
        $this->assertTrue($orderItem->getOrder() instanceof Order);
        $this->assertTrue($orderItem->getPrice() instanceof Price);
        $this->assertTrue($orderItem->getProduct() instanceof Product);
        $this->assertTrue($orderItem->getOptionProducts()[0] instanceof Product);
        $this->assertTrue($orderItem->getCatalogPromotions()[0] instanceof CatalogPromotion);
        $this->assertTrue($orderItem->getProductQuantityDiscounts()[0] instanceof ProductQuantityDiscount);
        $this->assertTrue($orderItem->getView() instanceof View\Orderitem);
    }
}
