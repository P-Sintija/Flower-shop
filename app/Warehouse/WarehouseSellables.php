<?php

namespace FlowerShop\Warehouse;

use FlowerShop\Sellables\Sellable;
use FlowerShop\Sellables\SellableCollection;
use FlowerShop\Sellables\Candle;
use FlowerShop\Sellables\Flower;

class WarehouseSellables implements Warehouse
{

    private string $name;
    private array $itemsInStock;

    public function __construct(string $name)
    {
        $this->name = $name;

        $this->addToStock(new Candle('aromatherapy', 'candle'), 20);
        $this->addToStock(new Flower('tulip', 'flower'), 100);
        $this->addToStock(new Flower('lily', 'flower'), 350);
        $this->addToStock(new Flower('cactus', 'flower'), 150);

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

