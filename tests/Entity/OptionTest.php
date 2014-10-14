<?php
namespace inklabs\kommerce;

use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\VirtualProduct;

class OptionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->option = new Option;
        $this->option->setName('Size');
        $this->option->setType('radio');
        $this->option->setDescription('Shirt Size');
        $this->option->setCreated(new \DateTime('now', new \DateTimeZone('UTC')));
    }

    public function testGetName()
    {
        $this->assertEquals('Size', $this->option->getName());
    }

    public function testWithProducts()
    {
        $product_small = new Product;
        $product_small->setSku('TS-NAVY-SM');
        $product_small->setName('Navy T-shirt (small)');
        $product_small->setPrice(900);

        $product_medium = new Product;
        $product_medium->setSku('TS-NAVY-MD');
        $product_medium->setName('Navy T-shirt (medium)');
        $product_medium->setPrice(1200);

        $product_large = new Product;
        $product_large->setSku('TS-NAVY-LG');
        $product_large->setName('Navy T-shirt (large)');
        $product_large->setPrice(1600);

        $this->option->addProduct($product_small);
        $this->option->addProduct($product_medium);
        $this->option->addProduct($product_large);

        $this->assertEquals(3, count($this->option->getProducts()));
    }

    public function testWithVirtualProducts()
    {
        $current_date = new \DateTime('now', new \DateTimeZone('UTC'));

        $virtual_product_small = new VirtualProduct;
        $virtual_product_small->setSku('SM');
        $virtual_product_small->setName('Small');

        $virtual_product_medium = new VirtualProduct;
        $virtual_product_medium->setSku('MD');
        $virtual_product_medium->setName('Medium');

        $virtual_product_large = new VirtualProduct;
        $virtual_product_large->setSku('LG');
        $virtual_product_large->setName('Large');

        $this->option->addProduct($virtual_product_small);
        $this->option->addProduct($virtual_product_medium);
        $this->option->addProduct($virtual_product_large);

        $this->assertEquals(3, count($this->option->getProducts()));
    }
}
