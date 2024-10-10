<?php

class OrderLine {

    public string $productName = '';
    public float $price = 0.0;
    public bool $inStock = false;

    public function __construct(string $productName, float $price, bool $inStock)
    {
        $this->productName = $productName;
        $this->price = $price;
        $this->inStock = $inStock;
    }

}
