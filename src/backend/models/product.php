<?php

namespace Scandiweb\Models;

abstract class Product{

    protected $sku;
    protected $id;
    protected $name;
    protected $price;

    public function __construct($sku, $name, $price, $id) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->id = $id;
    }

    abstract public function save(\Scandiweb\Helpers\Database $db); 
    abstract public static function getById(\Scandiweb\Helpers\Database $db,int $id); 
    abstract public function delete(\Scandiweb\Helpers\Database $db); 

    public function getSku() {
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }
    
}