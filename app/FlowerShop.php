<?php

namespace FlowerShop;

use FlowerShop\Sellables\SellableCollection;
use FlowerShop\Warehouse\WarehouseCollection;

class FlowerShop
{
    private WarehouseCollection $warehouseList;
    private ProductCollection $products;
    private int $discount = 0;
    private ?string $discountRecipient;


    public function setWarehouses(WarehouseCollection $warehouses): void
    {
        $this->warehouseList = $warehouses;
    }

    public function createProductList(): void
    {
        $this->products = new ProductCollection();
        $allItems = $this->possibleItemList();
        $uniqueItems = $this->removeDuplicates($allItems);
        $this->addProductsToList($uniqueItems);
    }

    public function setProductPrice(Product $product, int $price): void
    {
        for ($i = 0; $i < count($this->products->getAllProducts()); $i++) {
            $item = $this->products->getAllProducts()[$i];
            if ($item->getProduct()->getItemsName() === $product->getProduct()->getItemsName()) {
                $item->setPrice($price);
            }
        }
    }


    public function onlyPricedProducts(): array
    {
        $pricedGoods = [];
        foreach ($this->products->getAllProducts() as $products) {
            if ($products->getPrice() > 0) {
                $pricedGoods[] = $products;
            }
        }
        return $pricedGoods;
    }


    public function setDiscountConditions(int $discount, ?string $gender = null): void
    {
        $this->setDiscount($discount);
        $this->setDiscountRecipient($gender);
    }

    public function getDiscountRecipient(): ?string
    {
        return $this->discountRecipient;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }

    public function determineFee(Product $product, int $amount, int $discount): int
    {
        if ($amount < 0) {
            $amount = 0;
        }
        return $product->getPrice() * $amount * (100 - $discount) / 100;
    }


    public function correspondingWarehouses(Product $item): WarehouseCollection
    {
        $warehouses = new WarehouseCollection;
        foreach ($this->warehouseList->getWarehouseList() as $warehouse) {
            if (in_array($item->getProduct(), $warehouse->getStockProducts()->getItemList())) {
                $warehouses->addWarehouse($warehouse);
            }
        }
        return $warehouses;
    }


    private function possibleItemList(): SellableCollection
    {
        $itemsInWarehouses = new SellableCollection();
        foreach ($this->warehouseList->getWarehouseList() as $warehouse) {
            foreach ($warehouse->getStockProducts()->getItemList() as $item) {
                if ($warehouse->getProductAmount($item) > 0) {
                    $itemsInWarehouses->addItem($item);
                }
            }
        }
        return $itemsInWarehouses;
    }

    private function removeDuplicates(SellableCollection $allItems): SellableCollection
    {
        $uniqueItems = new SellableCollection();
        foreach ($allItems->getItemList() as $item) {
            if (!in_array($item, $uniqueItems->getItemList())) {
                $uniqueItems->addItem($item);
            }
        }
        return $uniqueItems;
    }

    private function addProductsToList(SellableCollection $uniqueItems): ProductCollection
    {
        for ($i = 0; $i < count($uniqueItems->getItemList()); $i++) {
            $product = new Product($uniqueItems->getItemList()[$i]);
            $product->setAmount($this->addProductAmount($product));
            $this->products->addProducts($product);
        }
        return $this->products;
    }

    private function addProductAmount(Product $product): int
    {
        $amount = [];
        foreach ($this->warehouseList->getWarehouseList() as $warehouse) {
            if (in_array($product->getProduct(), $warehouse->getStockProducts()->getItemList())) {
                $amount[] = $warehouse->getProductAmount($product->getProduct());
            }
        }
        return array_sum($amount);
    }


    private function setDiscount(int $discount): void
    {
        if ($discount > 0) {
            $this->discount = $discount;
        }
    }

    private function setDiscountRecipient(?string $gender = null): void
    {
        $this->discountRecipient = $gender;
    }

}

