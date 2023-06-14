<?php
namespace scandiweb\models;

use scandiweb\helpers\Database; 

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $height, $width, $length, $id=null)
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

    public static function getById(Database $db, $id)
    {
        $records = $db->select('furniture', $id);

        if (!count($records))
            return false;

        $record = $records[0];

        return new Furniture(...$record);
    }

    public static function update(Database $db, $id, $newVals)
    {
        return $db->update('furniture', $id, $newVals);
    }

    public function delete(Database $db)
    {
        return $db->delete('furniture', [$this->id]);
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
