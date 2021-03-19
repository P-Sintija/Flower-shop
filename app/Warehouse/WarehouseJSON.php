<?php

namespace FlowerShop\Warehouse;

use FlowerShop\Sellables\Candle;
use FlowerShop\Sellables\Flower;
use FlowerShop\Sellables\Sellable;
use FlowerShop\Sellables\SellableCollection;

class WarehouseJSON implements Warehouse
{
    private string $name;
    private array $itemsInStock;

    public function __construct(string $name)
    {
        $this->name = $name;

        $plantsWorldJSON = file_get_contents('Storages/plants-world.json');
        foreach (json_decode($plantsWorldJSON, true) as $item) {
            if ($item['type'] == 'candle') {
                $this->addToStock(new Candle($item['name'], $item['type']), (int)$item['amount']);
            } else if ($item['type'] == 'flower') {
                $this->addToStock(new Flower($item['name'], $item['type']), (int)$item['amount']);
            }
        }

    }

    public function getWarehouseName(): string
    {
        return $this->name;
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

    private function addToStock(Sellable $item, int $amount): void
    {
        $this->itemsInStock[] = [$item, $amount];
    }
}


