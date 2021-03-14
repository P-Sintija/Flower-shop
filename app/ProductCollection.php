<?php

namespace FlowerShop;

class ProductCollection
{
    private array $products;

    public function addProducts(Product $product): void
    {
        $this->products[] = $product;
    }

    public function getAllProducts(): array
    {
        return $this->products;
    }
}


