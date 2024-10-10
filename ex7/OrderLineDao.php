<?php

class OrderLineDao {

    public string $filePath;

    public function __construct($filePath) {
        $this->filePath = $filePath;
    }

    public function getOrderLines(): array {
        $lines = file($this->filePath);

        $orderLines = [];
        foreach ($lines as $line) {

            [$name, $price, $inStock] = explode(';', trim($line));

            $price = floatval($price); // string to float
            $inStock = $inStock === 'true'; // string to boolean

            $orderLines[] = new OrderLine($name, $price, $inStock);
        }

        return $orderLines;
    }


}
