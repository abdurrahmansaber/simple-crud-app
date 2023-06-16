<?php

require "config/Config.php";
$config = \scandiweb\config\getDatabaseConfig();
try {
    $connection = new PDO("mysql:host={$config['host']}", $config['username']);
    $sql = file_get_contents("data/init.sql");
    $connection->exec($sql);
    echo "Database Created..." . "<br>";
} catch (PDOException $error) {
    $errorMessage = '[' . date('Y-m-d H:i:s') . '] Error executing SQL query: ' . $e->getMessage();
    error_log($errorMessage);
}
