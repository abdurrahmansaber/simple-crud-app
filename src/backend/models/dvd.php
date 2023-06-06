<?php

namespace Scandiweb\Models;

class Dvd extends Product
{
    private $size;

    public function __construct($sku, $name, $price, $type, $size)
    {
        parent::__construct($sku, $name, $price, $type);
        $this->$size = $size;
    }

    public function save(\Scandiweb\Helpers\Database $db)
    {
        $vals = get_object_vars($this);
        unset($vals['id']);

        return $db->insert('dvd', $vals);
    } 

    public static function getById(\Scandiweb\Helpers\Database $db, $id)
    {
        $records = $db->select('dvd', $id);

        if (!count($records))
            return false;

        $record = $records[0];
        
        return new Dvd(...$record);
    } 

    public static function update($db, $id, $newVals){
        return $db->update('dvd', $id, $newVals);
    }

    public function delete(\Scandiweb\Helpers\Database $db)
    {
        return $db->delete('dvd', [$this->id]);

    }

    public function getSize()
    {
        return $this->size;
    }
}
