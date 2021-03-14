<?php

namespace FlowerShop\Sellables;

class Candle implements Sellable
{

    private string $name;
    private string $type;

    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getItemsName(): string
    {
        return $this->name;
    }

    public function getItemsType(): string
    {
        return $this->type;
    }
}

