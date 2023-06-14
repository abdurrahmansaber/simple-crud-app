<?php
namespace scandiweb\models;

use scandiweb\helpers\Database; 

class DVD extends Product
{
    private $size;

    public function __construct($sku, $name, $price, $size, $id=null)
    {
        parent::__construct($sku, $name, $price, $id);
        $this->size = $size;
    }

    public function save(Database $db)
    {
        $vals = get_object_vars($this);
        unset($vals['id']);

        return $db->insert('dvd', $vals);
    } 

    public static function getById(Database $db, $id)
    {
        $records = $db->select('dvd', $id);

        if (!count($records))
            return false;

        $record = $records[0];
        
        return new Dvd(...$record);
    } 

    public static function update(Database $db, $id, $newVals){
        return $db->update('dvd', $id, $newVals);
    }

    public function delete(Database $db)
    {
        return $db->delete('dvd', [$this->id]);

    }

    public function getSize()
    {
        return $this->size;
    }
}
