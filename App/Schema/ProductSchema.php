<?php
namespace App\Schema;

class ProductSchema {

    public $id;

    public $brand;

    public $variant;

    public $price;

    public $pack_size;


    function __construct(int $id, string $brand, string $variant, int $price, int $pack_size) 
    {
        $this->id = $id;
        $this->brand = $brand;
        $this->variant = $variant;
        $this->price = $price;
        $this->pack_size = $pack_size;
    }
}
