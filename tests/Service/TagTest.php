<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\Lib;
use inklabs\kommerce\tests\Helper\EntityRepository\FakeTag;
use inklabs\kommerce\View;
use inklabs\kommerce\tests\Helper;

class TagTest extends Helper\DoctrineTestCase
{
    /** @var FakeTag */
    protected $tagRepository;

    /** @var Tag */
    protected $tagService;

    public function setUp()
    {
        $this->tagRepository = new FakeTag;
        $this->tagService = new Tag($this->tagRepository, new Lib\Pricing);
    }

    public function testFind()
    {
        $tag = $this->tagService->find(1);
        $this->assertTrue($tag instanceof View\Tag);
    }

    public function testFindReturnsNull()
    {
        $this->tagRepository->setReturnValue(null);

        $tag = $this->tagService->find(1);
        $this->assertSame(null, $tag);
    }

    public function testFindOneByCode()
    {
        $tag = $this->tagService->findOneByCode('TT1');
        $this->assertTrue($tag instanceof View\Tag);
    }

    public function testFindOneByCodeReturnsNull()
    {
        $this->tagRepository->setReturnValue(null);

        $tag = $this->tagService->findOneByCode('TT');
        $this->assertSame(null, $tag);
    }

    public function testGetTagAndThrowExceptionIfMissing()
    {
        $tag = $this->tagService->getTagAndThrowExceptionIfMissing(1);
        $this->assertTrue($tag instanceof Entity\Tag);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Tag
     */
    public function testGetTagAndThrowExceptionIfMissingThrows()
    {
        $this->tagRepository->setReturnValue(null);

        $this->tagService->getTagAndThrowExceptionIfMissing(1);
    }

    public function testFindSimple()
    {
        $tag = $this->tagService->findSimple(1);
        $this->assertTrue($tag instanceof View\Tag);
    }

    public function testFindSimpleReturnsNull()
    {
        $this->tagRepository->setReturnValue(null);

        $tag = $this->tagService->findSimple(1);
        $this->assertSame(null, $tag);
    }

    public function testEdit()
    {
        $tag = $this->getDummyTag();
        $this->assertNotSame('Test Tag 2', $tag->getName());

        $tag->setName('Test Tag 2');
        $newTag = $this->tagService->edit($tag);
        $this->assertTrue($newTag instanceof Entity\Tag);
        $this->assertSame('Test Tag 2', $newTag->getName());
    }

    public function testCreate()
    {
        $tag = $this->getDummyTag();
        $newTag = $this->tagService->create($tag);
        $this->assertTrue($newTag instanceof Entity\Tag);
    }

    public function testGetAllTags()
    {
        $tags = $this->tagService->getAllTags();
        $this->assertTrue($tags[0] instanceof View\Tag);
    }

    public function testGetTagsByIds()
    {
        $tags = $this->tagService->getTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof View\Tag);
    }

    public function testAllGetTagsByIds()
    {
        $tags = $this->tagService->getAllTagsByIds([1]);
        $this->assertTrue($tags[0] instanceof View\Tag);
    }
}
