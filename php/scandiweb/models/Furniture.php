<?php

namespace scandiweb\models;

use scandiweb\helpers\Database;
use \Exception;

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function __construct(string $sku, string $name, float $price, float $height, float $width, float $length, ?int $id = null)
    {
        parent::__construct($sku, $name, $price, $id);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function save(Database $db)
    {
        $vals = get_object_vars($this);
        unset($vals['id']);

        return $db->insert('furniture', $vals);
    }

    public static function getById(Database $db, int $id)
    {
        $records = $db->select('furniture', $id);

        if (!count($records))
            return false;

        $record = $records[0];

        return new Furniture(...$record);
    }

    public static function update(Database $db, int $id, array $newVals)
    {
        return $db->update('furniture', $id, $newVals);
    }

    public function delete(Database $db)
    {
        return $db->delete('furniture', [$this->id]);
    }

    public static function deleteByIds(Database $db, array $ids)
    {
        if (!empty($ids)) {
            return $db->delete('furniture', $ids);
        } else {
            throw new Exception("Invalid ids input.");
        }
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getLength()
    {
        return $this->length;
    }
}
