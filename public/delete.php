<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/Config.php';

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once __DIR__ . '/../php/' . $class . '.php';
});

use scandiweb\helpers\Database;
use scandiweb\models\Book;
use scandiweb\models\DVD;
use scandiweb\models\Furniture;

$config = scandiweb\config\getDatabaseConfig();

$db = Database::getInstance($config['dsn'], $config['username'], $config['password'], $config['options']);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product'])) {
    $products = [];
    foreach ($_POST['product'] as $productInfo) {
        list($productId, $category) = explode(':', $productInfo);
        if (isset($products[$category])) {
            $products[$category][] = $productId;
        } else {
            $products[$category] = [$productId];
        }
    }

    if (isset($products['book']))
        Book::deleteByIds($db, $products['book']);

    if (isset($products['dvd']))
        DVD::deleteByIds($db, $products['dvd']);

    if (isset($products['furniture']))
        Furniture::deleteByIds($db, $products['furniture']);

    header("Location: index.php");
    exit();
}
