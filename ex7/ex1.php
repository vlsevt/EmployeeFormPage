<?php

require_once 'OrderLine.php';
require_once 'OrderLineDao.php';


$dto = new OrderLineDao('data/order.txt');

// print list of order line objects
foreach ($dto->getOrderLines() as $orderLine) {
    printf('name: %s, price: %s; in stock: %s' . PHP_EOL,
        $orderLine->productName,
        $orderLine->price,
        $orderLine->inStock ? 'true' : 'false');
}

