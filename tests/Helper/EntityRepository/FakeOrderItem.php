<?php
namespace inklabs\kommerce\tests\Helper\EntityRepository;

use inklabs\kommerce\EntityRepository\OrderItemInterface;
use inklabs\kommerce\Lib\ReferenceNumber;
use inklabs\kommerce\Entity;

class FakeOrderItem extends AbstractFake implements OrderItemInterface
{
    public function __construct()
    {
        $this->setReturnValue(new Entity\Order);
    }

    public function find($id)
    {
        return $this->getReturnValue();
    }

    public function create(Entity\OrderItem & $orderItem)
    {
        $this->throwCrudExceptionIfSet();
    }

    public function save(Entity\OrderItem & $orderItem)
    {
        $this->throwCrudExceptionIfSet();
    }

    public function persist(Entity\OrderItem & $orderItem)
    {
        $this->throwCrudExceptionIfSet();
    }
}
