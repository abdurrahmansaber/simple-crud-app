<?php
namespace scandiweb\models;

use scandiweb\helpers\Database;

class Book extends Product
{

    private $weight;

    public function __construct($sku, $name, $price, $weight, $id = null)
    {
        parent::__construct($sku, $name, $price, $id);
        $this->weight = $weight;
    }

    public function save(Database $db)
    {
        $vals = get_object_vars($this);
        unset($vals['id']);

        return $db->insert('book', $vals);
    }

    public static function getById(Database $db,int $id)
    {
        $records = $db->select('book', $id);

        if (!count($records))
            return false;

        $record = $records[0];
        
        return new Book(...$record);
    }

    public static function update(Database $db, $id, $newVals){
        return $db->update('book', $id, $newVals);
    }

    public function delete(Database $db)
    {
        return $db->delete('book', [$this->id]);
    }

    public function getWeight()
    {
        return $this->weight;
    }
}
