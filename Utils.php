<?php

namespace scandiweb\helpers;

require_once __DIR__ . '/config/Config.php';

use scandiweb\helpers\Database;

function getDB()
{
    $config = \scandiweb\config\getDatabaseConfig();
    return Database::getInstance($config['dsn'], $config['username'], $config['password'], $config['options']);
}
function autoload(){
    spl_autoload_register(function ($class) {
        $class = str_replace('\\', '/', $class);
        require_once __DIR__ . '/php/' . $class . '.php';
    });
}
