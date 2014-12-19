<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Lib as Lib;
use Doctrine as Doctrine;

class CartPriceRule extends Lib\EntityManager
{
    public function __construct(Doctrine\ORM\EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    public function findAll()
    {
        return $this->entityManager->getRepository('kommerce:CartPriceRule')->findAll();
    }
}