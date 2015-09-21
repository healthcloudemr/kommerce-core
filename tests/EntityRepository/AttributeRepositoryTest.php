<?php
namespace inklabs\kommerce\EntityRepository;

use inklabs\kommerce\Entity;
use inklabs\kommerce\tests\Helper;

class AttributeRepositoryTest extends Helper\DoctrineTestCase
{
    protected $metaDataClassNames = [
        'kommerce:Attribute',
        'kommerce:AttributeValue',
        'kommerce:ProductAttribute',
        'kommerce:Product',
    ];

    /** @var AttributeRepositoryInterface */
    protected $attributeRepository;

    public function setUp()
    {
        $this->attributeRepository = $this->repository()->getAttributeRepository();
    }

    private function setupAttribute()
    {
        $attribute = $this->getDummyAttribute();

        $this->entityManager->persist($attribute);
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function testCRUD()
    {
        $attribute = $this->getDummyAttribute();

        $this->attributeRepository->create($attribute);
        $this->assertSame(1, $attribute->getId());

        $attribute->setName('New Name');
        $this->assertSame(null, $attribute->getUpdated());

        $this->attributeRepository->save($attribute);
        $this->assertTrue($attribute->getUpdated() instanceof \DateTime);

        $this->attributeRepository->remove($attribute);
        $this->assertSame(null, $attribute->getId());
    }

    public function testFind()
    {
        $this->setupAttribute();

        $this->setCountLogger();

        $attribute = $this->attributeRepository->find(1);

        $attribute->getAttributeValues()->toArray();
        $attribute->getProductAttributes()->toArray();

        $this->assertTrue($attribute instanceof Entity\Attribute);
        $this->assertSame(3, $this->countSQLLogger->getTotalQueries());
    }
}