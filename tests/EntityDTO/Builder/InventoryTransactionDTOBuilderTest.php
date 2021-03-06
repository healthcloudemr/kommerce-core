<?php
namespace inklabs\kommerce\EntityDTO;

use inklabs\kommerce\tests\Helper\TestCase\EntityDTOBuilderTestCase;

class InventoryTransactionDTOBuilderTest extends EntityDTOBuilderTestCase
{
    public function testBuild()
    {
        $inventoryTransaction = $this->dummyData->getInventoryTransaction();

        $inventoryTransactionDTO = $this->getDTOBuilderFactory()
            ->getInventoryTransactionDTOBuilder($inventoryTransaction)
            ->withAllData()
            ->build();

        $this->assertTrue($inventoryTransactionDTO instanceof InventoryTransactionDTO);
        $this->assertTrue($inventoryTransactionDTO->product instanceof ProductDTO);
        $this->assertTrue($inventoryTransactionDTO->type instanceof InventoryTransactionTypeDTO);
        $this->assertTrue($inventoryTransactionDTO->inventoryLocation instanceof InventoryLocationDTO);
    }
}
