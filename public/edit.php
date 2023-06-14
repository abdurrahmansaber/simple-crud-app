<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once __DIR__ . '/../php/' . $class . '.php';
});

use scandiweb\helpers\Database;
use scandiweb\models\Book;
use scandiweb\models\DVD;
use scandiweb\models\Furniture;

$db = Database::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'], $_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    if ($type === 'book') {
        $product = Book::getById($db, $id);
    } elseif ($type === 'dvd') {
        $product = DVD::getById($db, $id);
    } elseif ($type === 'furniture') {
        $product = Furniture::getById($db, $id);
    }
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
        <button form="product_edit_form" formaction="edit.php">Save</button>
        <button id="cancel-add-btn">Cancel</button>
    </header>
    <form method="post" id="product_edit_form">
        <div id="basic-input">
            <label for="sku">SKU</label>
            <input name="sku" id="sku" type="text" required value="<?php echo htmlspecialchars($product->getSku()); ?>">
            <label for="name">Name</label>
            <input name="name" id="name" type="text" required value="<?php echo htmlspecialchars($product->getName()); ?>">
            <label for="price">Price (&dollar;)</label>
            <input name="price" id="price" type="number" required value="<?php echo htmlspecialchars($product->getPrice()); ?>">
            <label for="type">Type</label>
            <select name="type" id="productType" required>
                <option id="Book" value="book" <?php echo ($type === 'book') ? 'selected' : ''; ?>>Book</option>
                <option id="Furniture" value="furniture" <?php echo ($type === 'furniture') ? 'selected' : ''; ?>>Furniture</option>
                <option id="DVD" value="dvd" <?php echo ($type === 'dvd') ? 'selected' : ''; ?>>DVD</option>
            </select>
        </div>
        <div id="additional-input">
            <div id="book-attrs">
                <label for="weight">Weight (KG)</label>
                <input name="weight" id="weight" type="number" value="<?php echo ($type === 'book') ? $product->getWeight() : ''; ?>">
            </div>
            <div id="dvd-attrs" style="display: none;">
                <label for="size">Size (MB)</label>
                <input name="size" id="size" type="number" value="<?php echo ($type === 'dvd') ? $product->getSize() : ''; ?>">
            </div>
            <div id="furniture-attrs" style="display: none;">
                <label for="height">Height (CM)</label>
                <input name="height" id="height" type="number" value="<?php echo ($type === 'furniture') ? $product->getHeight() : ''; ?>">
                <label for="width">Width (CM)</label>
                <input name="width" id="width" type="number" value="<?php echo ($type === 'furniture') ? $product->getWidth() : ''; ?>">
                <label for="length">Length (CM)</label>
                <input name="length" id="length" type="number" value="<?php echo ($type === 'furniture') ? $product->getLength() : ''; ?>">
            </div>
        </div>
    </form>
    <script src="js/add-product.js"></script>
</body>

</html>
