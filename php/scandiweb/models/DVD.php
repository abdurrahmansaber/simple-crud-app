<?php
namespace scandiweb\models;

use scandiweb\helpers\Database;

class DVD extends Product
{
    private $size;

    public function __construct(string $sku, string $name, float $price, int $size, ?int $id=null)
    {
        parent::__construct($sku, $name, $price, $id);
        $this->size = $size;
    }

    public function save(Database $db)
    {
        $vals = get_object_vars($this);
        unset($vals['id']);
        unset($vals['description']);

        return $db->insert('dvd', $vals);
    } 

    public static function getById(Database $db, int $id)
    {
        $records = $db->select('dvd', $id);

        if (!count($records))
            return false;

        $record = $records[0];
        
        return new DVD(...$record);
    } 

    public static function deleteByIds(Database $db, array $ids){
        if (!empty($ids) && is_array($ids)){
            return $db->delete('dvd', $ids);
        }else{
            echo htmlspecialchars("Invalid ids input.");
        }
    }

    public static function update(Database $db, int $id, array $newVals){
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

    public function getDescription(){
        return 'Size: ' . $this->getSize() . ' MB';
    }
}
