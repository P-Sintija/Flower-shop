<!DOCTYPE html>
<html>
<head>
    <title>
    </title>
</head>

<body>
<h1 style="color:green;">Plants Plants Plants!!!</h1>

<table border='1' cellpadding='0' cellspacing='0' width='50%'>
    <tr>
        <th>Nr.</th>
        <th>Product type</th>
        <th>Name</th>
        <th>Price</th>
        <th>In Stock</th>
    </tr>

    <?php
    $counter = 1;
    foreach ($shop->onlyPricedProducts() as $product) {

        $productsNumber = $counter++; ?>

        <tr style="text-align:center;">
            <td>
                <form method="post">
                    <input type="submit" name="number"
                           class="button" value=<?php echo $productsNumber; ?>>
            </td>
            <td><?php echo $product->getProduct()->getItemsType() ?></td>
            <td><?php echo $product->getProduct()->getItemsName() ?></td>
            <td><?php echo number_format($product->getPrice() / 100, 2) ?></td>
            <td><?php echo $product->getAmount() ?></td>
        </tr>
    <?php } ?>
</table>

<form method="post">
    <label for="amount">Amount:</label><br>
    <input type="text" id="amount" name="amount"><br>

    <?php
    showResults($shop);
    ?>

</body>
</html>

