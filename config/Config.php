<?php
namespace scandiweb\config;

function getDatabaseConfig()
{
    $host = 'localhost';
    $dbname = 'shop';
    $config = [
        'dsn' => "mysql:host={$host};dbname={$dbname}",
        'host' => $host,
        'username' => 'root',
        'password' => '',
        'dbname' => $dbname,
        'options' => [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_PERSISTENT => true
        ]
    ];

    return $config;
}
