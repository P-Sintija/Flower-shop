<?php

namespace FlowerShop\Warehouse;

use FlowerShop\Sellables\Sellable;
use FlowerShop\Sellables\SellableCollection;

class WarehouseThree implements Warehouse
{

    private string $name;
    private array $itemsInStock;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getWarehouseName(): string
    {
        return $this->name;
    }

    public function addToStock(Sellable $item, int $amount): void
    {
        $this->itemsInStock[] = [$item, $amount];
    }

    public function getStockProducts(): SellableCollection
    {
        $collection = new SellableCollection();
        for ($i = 0; $i < count($this->itemsInStock); $i++) {
            $collection->addItem($this->itemsInStock[$i][0]);
        }
        return $collection;
    }

    public function getProductAmount(Sellable $item): int
    {
        $amount = 0;
        foreach ($this->itemsInStock as $product) {
            if ($product[0]->getItemsName() === $item->getItemsName()) {
                $amount = $product[1];
            }
        }
        return $amount;
    }

}

