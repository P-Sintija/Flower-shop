<?php

namespace FlowerShop;


use FlowerShop\Sellables\Sellable;

class Product
{
    private Sellable $item;
    private int $price = 0;
    private int $amount;

    public function __construct(Sellable $item)
    {
        $this->item = $item;
    }

    public function getProduct(): Sellable
    {
        return $this->item;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function setPrice(int $price): void
    {
        if ($price < 0) return;
        $this->price = $price;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

}
