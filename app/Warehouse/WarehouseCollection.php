<?php

namespace FlowerShop\Warehouse;

class WarehouseCollection
{
    private array $warehouseList;

    public function addWarehouse(Warehouse $warehouse): void
    {
        $this->warehouseList[] = $warehouse;
    }

    public function getWarehouseList(): array
    {
        return $this->warehouseList;
    }
}
