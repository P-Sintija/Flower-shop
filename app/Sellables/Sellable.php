<?php

namespace FlowerShop\Sellables;


interface Sellable
{
    public function getItemsName(): string;

    public function getItemsType(): string;
}
