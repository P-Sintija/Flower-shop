<?php

require_once 'vendor/autoload.php';

use FlowerShop\FlowerShop;
use FlowerShop\Product;
use FlowerShop\Warehouse\WarehouseCollection;
use FlowerShop\Warehouse\WarehouseCSV;
use FlowerShop\Warehouse\WarehouseSellables;
use FlowerShop\Warehouse\WarehouseJSON;
use FlowerShop\Warehouse\WarehouseSQL;


$wareHouse1 = new WarehouseCSV('Storage CSV');
$wareHouse2 = new WarehouseJSON('Storage JSON');
$wareHouse3 = new WarehouseSellables('Storage SELLABLES');
$wareHouse4 = new WarehouseSQL('Storage SQL');


$shopWarehouses = new WarehouseCollection;
$shopWarehouses->addWarehouse($wareHouse1);
$shopWarehouses->addWarehouse($wareHouse2);
$shopWarehouses->addWarehouse($wareHouse3);
$shopWarehouses->addWarehouse($wareHouse4);


$shop = new FlowerShop;
$shop->setWarehouses($shopWarehouses);
$shop->createProductList();

$shop->setDiscountConditions(20, 'female');


function calculateFee(string $gender, Product $item, int $amount, FlowerShop $shop): int
{
    $discount = 0;
    if ($gender === $shop->getDiscountRecipient()) {
        $discount = $shop->getDiscount();
    }
    return $shop->determineFee($item, $amount, $discount);
}


function showBill(Product $product, int $amount, int $price): void
{
    echo $amount . ' ' . $product->getProduct()->getItemsName() . ' will cost you $' .
        number_format($price / 100, 2);
}


function showCorrespondingWarehouses(Product $product, FlowerShop $shop): void
{
    $warehouses = $shop->correspondingWarehouses($product)->getWarehouseList();
    foreach ($warehouses as $warehouse) {
        echo $warehouse->getWarehouseName() . ': ' .
            $warehouse->getProductAmount($product->getProduct()) . ' in stock' . '<br>';
    }
}

require_once 'view.php';


