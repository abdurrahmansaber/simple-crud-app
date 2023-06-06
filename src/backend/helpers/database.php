<?php

namespace Scandiweb\Helpers;

class Database
{
    private static $instance;
    private $connection;

    private function __construct(){
        require dirname(__FILE__) . "/../../config/db_config.php";

        try {
            $this->connection = new \PDO($dsn, $username, '', $options);
        } catch (\PDOException $e) {
            $errorMessage = 'Database connection failed: ' . $e->getMessage();
            error_log($errorMessage);
            throw new \Exception($errorMessage);
        }
    }

    public static function getInstance(){
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function insert($table, $valsList){
        try {
            $dbObject = Database::getInstance();

            $columns = join(', ', array_keys($valsList));
            $placeholders = ':' . join(', :', array_keys($valsList));

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

            $insertStmt = $dbObject->connection->prepare($sql);

            foreach ($valsList as $key => $value) {
                $insertStmt->bindValue(":$key", $value);
            }

            $insertStmt->execute();            
            return (int)($dbObject->connection->lastInsertId());

        } catch (\PDOException $e) {

            $errorMessage = 'Error executing SQL query: ' . $e->getMessage();
            error_log($errorMessage);
            throw new \Exception($errorMessage);

            return false;
        }
    }

    public function select($table, $id = false){
        try {
            $dbObject = Database::getInstance();

            $sql = "SELECT * FROM $table";

            if ($id)
                $sql = $sql . " WHERE id=$id";

            $selectStmt = $dbObject->connection->prepare($sql);
            $selectStmt->execute();
            $record = $selectStmt->fetchAll(mode: \PDO::FETCH_ASSOC);
            $selectStmt->closeCursor();
           
            return $record;
        } catch (\PDOException $e) {

            $errorMessage = 'Error executing SQL query: ' . $e->getMessage();
            error_log($errorMessage);
            throw new \Exception($errorMessage);

            return false;
        }
    }

    public function update(string $table, int $id, array $newVals){
        try {
            if (key_exists('id', $newVals))
                unset($newVals['id']);

            if (!count($newVals))
                return false;

            $dbObject = Database::getInstance();
            $placeholders = "";
            
            foreach (array_keys($newVals) as $key) {
                $placeholders .= "$key = :$key, ";
            }

            $placeholders = rtrim($placeholders, ' ,');

            $sql = "UPDATE $table SET $placeholders WHERE id=$id";

            $updateStmt = $dbObject->connection->prepare($sql);

            foreach ($newVals as $key => $value) {
                $updateStmt->bindValue(":$key", $value);
            }

            $updateStmt->execute();
            return $updateStmt->rowCount();
        } catch (\PDOException $e) {

            $errorMessage = 'Error executing SQL query: ' . $e->getMessage();
            error_log($errorMessage);
            throw new \Exception($errorMessage);

            return false;
        }
    }

    public static function delete(string $table, array $ids){
        try{
            $dbObject = Database::getInstance();
            $sql = sprintf("DELETE FROM %s WHERE id in (%s)", $table, join(", ", $ids));
            $deleteStmt = $dbObject->connection->prepare($sql);
            $deleteStmt->execute();
            return $deleteStmt->rowCount();
        }catch (\PDOException $e) {
            $errorMessage = 'Error executing SQL query: ' . $e->getMessage();
            error_log($errorMessage);
            throw new \Exception($errorMessage);
            return false;
        }
    }
}

