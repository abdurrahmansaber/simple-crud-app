<?php
namespace scandiweb\helpers;

use \PDO;
use \PDOException;
use \Exception;
use \InvalidArgumentException;

class Database
{
    private static $instance;
    private $connection;

    private function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public static function getInstance(string $dsn, string $username, string $password, array $options)
    {
        if (!isset(self::$instance)) {
            try {
                $connection = new PDO($dsn, $username, $password, $options);
                self::$instance = new Database($connection);
            } catch (PDOException $e) {
                $errorMessage = '[' . date('Y-m-d H:i:s') . '] Database connection failed: ' . $e->getMessage();
                error_log($errorMessage);
                echo htmlspecialchars($errorMessage);
            }
        }
        return self::$instance;
    }

    public function insert(string $table, array $valsList)
    {
        try {
            $this->validateTable($table);
            $this->validateValsList($valsList);

            $columns = join(', ', array_keys($valsList));
            $placeholders = ':' . join(', :', array_keys($valsList));

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";

            $insertStmt = $this->connection->prepare($sql);

            foreach ($valsList as $key => $value) {
                $insertStmt->bindValue(":$key", $value);
            }

            $insertStmt->execute();
            return (int)($this->connection->lastInsertId());
        } catch (PDOException $e) {

            $errorMessage = '[' . date('Y-m-d H:i:s') . '] Error executing SQL query: ' . $e->getMessage();
            error_log($errorMessage);
            echo htmlspecialchars($errorMessage);
        }
    }

    public function select(string $table, ?int $id=null)
    {
        try {
            $this->validateTable($table);

            $sql = "SELECT * FROM $table";

            if ($id) {
                $this->validateId($id);
                $sql = $sql . " WHERE id=$id";
            }

            $selectStmt = $this->connection->prepare($sql);
            $selectStmt->execute();
            $records = $selectStmt->fetchAll(mode: PDO::FETCH_ASSOC);
            $selectStmt->closeCursor();

            return $records;
        } catch (PDOException $e) {

            $errorMessage = '[' . date('Y-m-d H:i:s') . '] Error executing SQL query: ' . $e->getMessage();
            error_log($errorMessage);
        }
    }

    public function update(string $table, int $id, array $valsList)
    {
        try {
            $this->validateId($id);
            $this->validateTable($table);
            $this->validateValsList($valsList);

            if (key_exists('id', $valsList))
                unset($newVals['id']);

            if (!count($valsList))
                return false;

            $placeholders = "";

            foreach (array_keys($valsList) as $key) {
                $placeholders .= "$key = :$key, ";
            }

            $placeholders = rtrim($placeholders, ' ,');

            $sql = "UPDATE $table SET $placeholders WHERE id=$id";

            $updateStmt = $this->connection->prepare($sql);

            foreach ($valsList as $key => $value) {
                $updateStmt->bindValue(":$key", $value);
            }

            $updateStmt->execute();
            return $updateStmt->rowCount();
        } catch (PDOException $e) {

            $errorMessage = '[' . date('Y-m-d H:i:s') . '] Error executing SQL query: ' . $e->getMessage();
            error_log($errorMessage);
            echo htmlspecialchars($errorMessage);
        }
    }

    public function delete(string $table, array $ids)
    {
        $this->validateTable($table);
        $this->validateIds($ids);
        try {
            $sql = sprintf("DELETE FROM %s WHERE id in (%s)", $table, join(", ", $ids));
            $deleteStmt = $this->connection->prepare($sql);
            $deleteStmt->execute();
            return $deleteStmt->rowCount();
        } catch (PDOException $e) {
            $errorMessage = '[' . date('Y-m-d H:i:s') . '] Error executing SQL query: ' . $e->getMessage();
            error_log($errorMessage);
            echo htmlspecialchars($errorMessage);
        }
    }

    private function validateTable($table)
    {
        if (empty($table))
            throw new InvalidArgumentException('Invalid table name');
    }

    private function validateValsList($valsList)
    {
        if (empty($valsList))
            throw new InvalidArgumentException('Invalid values list');
    }
    private function validateIds($ids)
    {
        if (empty($ids)) {
            throw new InvalidArgumentException('Invalid ids list');
            foreach ($ids as $id) {
                $this->validateId($id);
            }
        }
    }
    private function validateId($id)
    {
        if ($id <= 0 || !is_int($id))
            throw new InvalidArgumentException('Invalid ID');
    }
}
