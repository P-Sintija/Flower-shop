<?php

namespace FlowerShop\Warehouse;

use FlowerShop\Sellables\Sellable;
use FlowerShop\Sellables\SellableCollection;

interface Warehouse
{
    public function getWarehouseName(): string;

    public function getStockProducts(): SellableCollection;

    public function getProductAmount(Sellable $item): int;
}
