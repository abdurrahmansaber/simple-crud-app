<?php

namespace Scandiweb\Models;

class Book extends Product
{

    private $weight;

    public function __construct($sku, $name, $price, $weight, $id = null)
    {
        parent::__construct($sku, $name, $price, $id);
        $this->weight = $weight;
    }

    public function save($db)
    {
        $vals = get_object_vars($this);
        unset($vals['id']);

        return $db->insert('book', $vals);
    }

    public static function getById($db,int $id)
    {
        $records = $db->select('book', $id);

        if (!count($records))
            return false;

        $record = $records[0];
        
        return new Book(...$record);
    }

    public static function update($db, $id, $newVals){
        return $db->update('book', $id, $newVals);
    }

    public function delete($db)
    {
        return $db->delete('book', [$this->id]);
    }

    public function getWeight()
    {
        return $this->weight;
    }
}
