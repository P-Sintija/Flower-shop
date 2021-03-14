<?php

namespace FlowerShop\Sellables;

class SellableCollection
{
    private array $itemList = [];

    public function addItem(Sellable $item): void
    {
        $this->itemList[] = $item;
    }

    public function getItemList(): array
    {
        return $this->itemList;
    }
}
