<?php
namespace scandiweb\models;

use scandiweb\helpers\Database;

class Book extends Product
{

    private $weight;

    public function __construct(string $sku, string $name, float $price, float $weight, ?int $id=null)
    {
        parent::__construct($sku, $name, $price, $id);
        $this->weight = $weight;
    }

    public function save(Database $db)
    {
        $vals = get_object_vars($this);
        unset($vals['id']);
        unset($vals['description']);
        
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

    public static function update(Database $db, int $id, array $newVals){
        return $db->update('book', $id, $newVals);
    }

    public static function deleteByIds(Database $db, array $ids){
        if (!empty($ids) && is_array($ids)){
            return $db->delete('book', $ids);
        }else{
            echo htmlspecialchars("Invalid ids input.");
        }
    }

    public function delete(Database $db)
    {
        return $db->delete('book', [$this->id]);
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getDescription(){
        return 'Weight: ' . $this->getWeight() . ' KG';
    }
}
