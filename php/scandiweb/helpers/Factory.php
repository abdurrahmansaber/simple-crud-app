<?php

namespace scandiweb\helpers;

use scandiweb\models\Book;
use scandiweb\models\DVD;
use scandiweb\models\Furniture;
use scandiweb\models\Product;
use \InvalidArgumentException;

class Factory
{
    private const PRODUCT_TYPES = [
        'book' => 'createBook',
        'dvd' => 'createDVD',
        'furniture' => 'createFurniture',
    ];

    public static function createProduct(string $type, array $data): Product
    {
        if (!self::array_keys_exists(['sku', 'name', 'price'], $data)) {
            throw new InvalidArgumentException('Invalid form input for a product');
        }

        if (!isset(self::PRODUCT_TYPES[$type])) {
            throw new InvalidArgumentException('Invalid product type');
        }

        $method = self::PRODUCT_TYPES[$type];
        return self::$method($data);
    }

    private static function createBook(array $data): Book
    {
        if (!array_key_exists('weight', $data)) {
            throw new InvalidArgumentException('Invalid form input for a book');
        }

        return new Book($data['sku'], $data['name'], $data['price'], $data['weight']);
    }

    private static function createDVD(array $data): DVD
    {
        if (!array_key_exists('size', $data)) {
            throw new InvalidArgumentException('Invalid form input for a DVD');
        }

        return new DVD($data['sku'], $data['name'], $data['price'], $data['size']);
    }

    private static function createFurniture(array $data): Furniture
    {
        if (!self::array_keys_exists(['height', 'width', 'length'], $data)) {
            throw new InvalidArgumentException('Invalid form input for furniture');
        }

        return new Furniture($data['sku'], $data['name'], $data['price'], $data['height'], $data['width'], $data['length']);
    }

    private static function array_keys_exists(array $keys, array $arr): bool
    {
        return !array_diff_key(array_flip($keys), $arr);
    }
}
