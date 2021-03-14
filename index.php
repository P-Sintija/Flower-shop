<?php

require_once 'vendor/autoload.php';

use FlowerShop\FlowerShop;
use FlowerShop\Product;
use FlowerShop\Sellables\Candle;
use FlowerShop\Sellables\Flower;
use FlowerShop\Warehouse\WarehouseCollection;
use FlowerShop\Warehouse\WarehouseOne;
use FlowerShop\Warehouse\WarehouseThree;
use FlowerShop\Warehouse\WarehouseTwo;


$flowerPowerCSV = "Storages/flower-power.csv";
$plantsWorldJSON = file_get_contents('Storages/plants-world.json');


$wareHouse1 = new WarehouseOne('Storage ONE');
$itemsCSV = [];
if (($file = fopen($flowerPowerCSV, "r")) !== FALSE) {
    while (($data = fgetcsv($file, 20, ",")) !== FALSE) {
        $itemsCSV[] = $data;
    }
    fclose($file);
}

foreach ($itemsCSV as $item) {
    if ($item[1] == 'candle') {
        $wareHouse1->addToStock(new Candle($item[0], $item[1]));
    } else if ($item[1] == 'flower') {
        $wareHouse1->addToStock(new Flower($item[0], $item[1]));
    }
}

$wareHouse1->addItemsAmount('tulip', 100);
$wareHouse1->addItemsAmount('lily', 50);
$wareHouse1->addItemsAmount('ordinary', 20);


$wareHouse2 = new WarehouseTwo('Storage TWO');
foreach (json_decode($plantsWorldJSON, true) as $item) {
    if ($item['type'] == 'candle') {
        $wareHouse2->addToStock(new Candle($item['name'], $item['type']));
    } else if ($item['type'] == 'flower') {
        $wareHouse2->addToStock(new Flower($item['name'], $item['type']));
    }
}

$wareHouse2->addItemsAmount('tulip', 113);
$wareHouse2->addItemsAmount('rose', 40);
$wareHouse2->addItemsAmount('honey', 666);


$wareHouse3 = new WarehouseThree('Storage THREE');
$wareHouse3->addToStock(new Candle('aromatherapy', 'candle'), 20);
$wareHouse3->addToStock(new Flower('tulip', 'flower'), 100);
$wareHouse3->addToStock(new Flower('lily', 'flower'), 350);
$wareHouse3->addToStock(new Flower('cactus', 'flower'), 150);

$shopWarehouses = new WarehouseCollection;
$shopWarehouses->addWarehouse($wareHouse1);
$shopWarehouses->addWarehouse($wareHouse2);
$shopWarehouses->addWarehouse($wareHouse3);


$shop = new FlowerShop;
$shop->setWarehouses($shopWarehouses);
$shop->createProductList();

$shop->setProductPrice(new Product(new Flower('tulip', 'flower')), 100);
$shop->setProductPrice(new Product(new Flower('lily', 'flower')), 350);
$shop->setProductPrice(new Product(new Flower('rose', 'flower')), 200);
$shop->setProductPrice(new Product(new Flower('daffodil', 'flower')), 80);
$shop->setProductPrice(new Product(new Flower('cactus', 'flower')), 250);
$shop->setProductPrice(new Product(new Candle('ordinary', 'candle')), 150);
$shop->setProductPrice(new Product(new Candle('honey', 'candle')), 250);
$shop->setProductPrice(new Product(new Candle('aromatherapy', 'candle')), 500);

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


