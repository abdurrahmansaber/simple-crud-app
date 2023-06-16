<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/Config.php';

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once __DIR__ . '/../php/' . $class . '.php';
});

use scandiweb\helpers\Database;
use scandiweb\helpers\Factory;
use \Exception;

$config = scandiweb\config\getDatabaseConfig();
$db = Database::getInstance($config['dsn'], $config['username'], $config['password'], $config['options']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $product = Factory::createProduct($_POST['type'], $_POST);
        $product->save($db);
    } catch (Exception $e) {
        $errorMessage = '[' . date('Y-m-d H:i:s') . '] Error adding product: ' . $e->getMessage();
        error_log($errorMessage);
        throw new Exception($errorMessage);
    }
    header('Location: index.php');
    die();
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <h1>Product Add</h1>
        <button form="product_form" formaction="add-product.php">Save</button>
        <button id="cancel-add-btn">Cancel</button>
    </header>
    <form method="post" id="product_form">
        <div id="basic-input">
            <label for="sku">SKU</label>
            <input name="sku" id="sku" type="text" required>
            <label for="name">Name</label>
            <input name="name" id="name" type="text" required>
            <label for="price">Price (&dollar;)</label>
            <input name="price" id="price" type="number" required>
            <label for="type">Type</label>
            <select name="type" id="productType" required>
                <option id="Book" value="book">Book</option>
                <option id="Furniture" value="furniture">Furniture</option>
                <option id="DVD" value="dvd">DVD</option>
            </select>
        </div>
        <div id="additional-input">
            <div id="book-attrs">
                <label for="weight">Weight (KG)</label>
                <input name="weight" id="weight" type="number" required>
            </div>
            <div id="dvd-attrs" style="display: none;">
                <label for="size">Size (MB)</label>
                <input name="size" id="size" type="number">
            </div>
            <div id="furniture-attrs" style="display: none;">
                <label for="height">Height (CM)</label>
                <input name="height" id="height" type="number">
                <label for="width">Width (CM)</label>
                <input name="width" id="width" type="number">
                <label for="length">Length (CM)</label>
                <input name="length" id="length" type="number">
            </div>
        </div>
    </form>
    <script src="js/add-product.js"></script>

</body>

</html>