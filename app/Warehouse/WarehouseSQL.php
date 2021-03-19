<?php

namespace FlowerShop\Warehouse;

use FlowerShop\Sellables\Flowerpot;
use FlowerShop\Sellables\Sellable;
use FlowerShop\Sellables\SellableCollection;

use Medoo\Medoo;

class WarehouseSQL implements Warehouse
{
    private string $name;
    private array $itemsInStock;

    public function __construct(string $name)
    {
        $this->name = $name;

        $database = new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'flowershop',
            'server' => 'localhost',
            'username' => 'root',
            'password' => ''
        ]);

        $data = $database->select('products', '*');

        foreach ($data as $info) {
            $this->addToStock(
                new Flowerpot($info['name'], $info['type']), (int)$info['amount']);
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