<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\OptionInterface;
use inklabs\kommerce\Entity;

class FakeOption extends AbstractFake implements OptionInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Option);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function getAllOptions($queryString = null, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function getAllOptionsByIds(array $optionIds, Entity\Pagination & $pagination = null)
    {
        return $this->getReturnValueAsArray();
    }

    public function create(Entity\Option & $entity)
    {
    }

    public function save(Entity\Option & $option)
    {
    }

    public function persist(Entity\Option & $option)
    {
    }
}
