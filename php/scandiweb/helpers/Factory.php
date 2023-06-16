<?php
namespace scandiweb\helpers;

use scandiweb\models\Book;
use scandiweb\models\DVD;
use scandiweb\models\Furniture;
use scandiweb\models\Product;
use \InvalidArgumentException;

class Factory
{
    public static function createProduct(string $type, array $data): Product
    {
        if (!self::array_keys_exists(['sku', 'name', 'price'], $data))
            throw new InvalidArgumentException('Invalid form input for a product');

        $product = null;

        switch ($type) {
            case 'book':
                if (array_key_exists('weight', $data))
                    $product = new Book($data['sku'], $data['name'], $data['price'], $data['weight']);
                break;

            case 'dvd':
                if (array_key_exists('size', $data))
                    $product = new DVD($data['sku'], $data['name'], $data['price'], $data['size']);
                break;

            case 'furniture':
                if (self::array_keys_exists(['height', 'width', 'length'], $data))
                    $product = new Furniture($data['sku'], $data['name'], $data['price'], $data['height'], $data['width'], $data['length']);
                break;

            default:
                throw new InvalidArgumentException('Invalid product type');
        }

        return $product;
    }

    private static function array_keys_exists(array $keys, array $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }
}
