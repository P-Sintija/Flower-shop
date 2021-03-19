<?php

namespace FlowerShop\Warehouse;

use FlowerShop\Sellables\Candle;
use FlowerShop\Sellables\Flower;
use FlowerShop\Sellables\Sellable;
use FlowerShop\Sellables\SellableCollection;

class WarehouseCSV implements Warehouse
{
    private string $name;
    private array $itemsInStock;

    public function __construct(string $name)
    {
        $this->name = $name;

        $flowerPowerCSV = "Storages/flower-power.csv";
        $itemsCSV = [];
        if (($file = fopen($flowerPowerCSV, "r")) !== FALSE) {
            while (($data = fgetcsv($file, 20, ",")) !== FALSE) {
                $itemsCSV[] = $data;
            }
            fclose($file);
        }

        foreach ($itemsCSV as $item) {
            if ($item[1] == 'candle') {
                $this->addToStock(new Candle($item[0], $item[1]), (int)$item[2]);
            } else if ($item[1] == 'flower') {
                $this->addToStock(new Flower($item[0], $item[1]), (int)$item[2]);
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

