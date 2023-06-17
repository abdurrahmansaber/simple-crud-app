<?php

namespace scandiweb\models;

use scandiweb\helpers\Database;
use scandiweb\models\Book;
use scandiweb\models\DVD;
use scandiweb\models\Furniture;

abstract class Product
{
    protected $sku;
    protected $id;
    protected $name;
    protected $price;
    protected $description;

    public function __construct(string $sku, string $name, float $price, ?int $id = null)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->id = $id;
    }

    abstract public function save(Database $db);
    abstract public static function getById(Database $db, int $id);
    abstract public function delete(Database $db);
    abstract public static function deleteByIds(Database $db, array $ids);
    abstract public function getDescription();

    public static function getAllProducts(Database $db)
    {
        $books = array_map(fn ($vals) => new Book(...$vals), $db->select('book'));
        $dvds = array_map(fn ($vals) => new DVD(...$vals), $db->select('dvd'));
        $furniture = array_map(fn ($vals) => new Furniture(...$vals), $db->select('furniture'));
        $products = array_merge($dvds, $furniture, $books,);

        usort($products, fn ($p1, $p2) => $p1->getId() < $p2->getId() ? -1 : 1);

        return $products;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }
    
}
