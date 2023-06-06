<?php

namespace Scandiweb\Models;

class Furniture extends Product
{
    private $height;
    private $width;
    private $length;

    public function __construct($sku, $name, $price, $type, $height, $width, $length)
    {
        parent::__construct($sku, $name, $price, $type);
        $this->$height = $height;
        $this->$width = $width;
        $this->$length = $length;
    }

    public function save(\Scandiweb\Helpers\Database $db)
    {
        $vals = get_object_vars($this);
        unset($vals['id']);

        return $db->insert('furniture', $vals);
    }

    public static function getById(\Scandiweb\Helpers\Database $db, $id)
    {
        $records = $db->select('furniture', $id);

        if (!count($records))
            return false;

        $record = $records[0];

        return new Furniture(...$record);
    }

    public static function update($db, $id, $newVals)
    {
        return $db->update('furniture', $id, $newVals);
    }

    public function delete(\Scandiweb\Helpers\Database $db)
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
