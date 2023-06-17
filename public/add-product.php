<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
require_once __DIR__ . '/../Utils.php';

scandiweb\helpers\autoload();

$db = scandiweb\helpers\getDB();

use scandiweb\helpers\Factory;
use \Exception;

function sanitizeInput(string $input)
{
    return addslashes(trim(strip_tags($input)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        array_map('sanitizeInput', $_POST);
        $product = Factory::createProduct($_POST['type'], $_POST);
        $product->save($db);
    } catch (Exception $e) {
        $errorMessage = '[' . date('Y-m-d H:i:s') . '] Error adding product: ' . $e->getMessage();
        error_log($errorMessage);
        echo htmlspecialchars($errorMessage);
    }
    header('Location: index.php');
    exit();
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Add</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <header>
        <h1>Product Add</h1>
        <nav>
            <button form="product_form" formaction="add-product.php">Save</button>
            <a href="index.php"><button id="cancel-add-btn">Cancel</button></a>
        </nav>
    </header>
    <hr>
    <form method="post" id="product_form">
        <div id="basic-input">
            <label for="sku">SKU</label>
            <input name="sku" id="sku" type="text" maxlength="30" minlength="1" required>
            <label for="name">Name</label>
            <input name="name" id="name" type="text" maxlength="30" minlength="1" required>
            <label for="price">Price (&dollar;)</label>
            <input name="price" id="price" type="number" step="0.01" min="0.01" max="999999.99" required>
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
                <input name="weight" id="weight" type="number" step="0.01" min="0.01" max="99.99" required>
                <strong>Please, provide weight</strong>
            </div>
            <div id="dvd-attrs" style="display: none;">
                <label for="size">Size (MB)</label>
                <input name="size" id="size" type="number" min="1" max="4000000000">
                <strong>Please, provide size</strong>
            </div>
            <div id="furniture-attrs" style="display: none;">
                <label for="height">Height (CM)</label>
                <input name="height" id="height" type="number" step="0.01" min="1" max="1000">
                <label for="width">Width (CM)</label>
                <input name="width" id="width" type="number" step="0.01" min="1" max="1000">
                <label for="length">Length (CM)</label>
                <input name="length" id="length" type="number" step="0.01" min="1" max="1000">
                <strong>Please, provide dimensions</strong>
            </div>
        </div>
    </form>
    <hr>
    <footer>
        <p>Scandiweb Test Assignment</p>
    </footer>
    <script src="js/add-product.js"></script>

</body>

</html>