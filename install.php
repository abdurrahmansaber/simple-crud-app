<?php

require "config/db_config.php";

try {
    $connection = new PDO("mysql:host=$host", $username);
    $sql = file_get_contents("data/init.sql");
    $connection->exec($sql);
    echo "Database Created..." . "<br>";
} catch (PDOException $error) {
    $errorMessage = '[' . date('Y-m-d H:i:s') . '] Error executing SQL query: ' . $e->getMessage();
    error_log($errorMessage);
    throw new Exception($errorMessage);
}
