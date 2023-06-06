<?php

namespace Scandiweb\Config;

$host       = "localhost";
$username   = "root";
$password   = "root";
$dbname     = "shop";
$dsn        = "mysql:host=$host;dbname=$dbname";
$options    = array(
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_PERSISTENT => true
);
