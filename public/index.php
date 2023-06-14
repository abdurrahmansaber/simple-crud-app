<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once __DIR__ . '/../php/' . $class . '.php';
});


use scandiweb\helpers\Database;
use scandiweb\models\Product;

$db = Database::getInstance();
$productCatgories = Product::getAllProducts($db);
$productsCount = count($productCatgories, 1);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/index.css" />
</head>

<body>
    <header>
        <h1>Products List</h1>
        <nav>
            <button id="add-product-btn">ADD</button>
            <button id="delete-product-btn">MASS DELETE</button>
        </nav>
    </header>
    <div class="grid-container" id="container">
        <?php if ($productsCount > 3) : ?>
            <?php foreach ($productCatgories as $categName => $products) : ?>
                <?php foreach ($products as $product) : ?>
                    <div class="grid-item clickable-div" data-id=<?php echo "{$product->getId()}"?> data-type=<?php echo "$categName"?>>
                        <h3><?php echo $product->getSku(); ?></h3>
                        <p><?php echo $product->getName(); ?></p>
                        <p>Price: $<?php echo $product->getPrice(); ?></p>
                        <p>
                            <?php if ($categName === 'book') echo 'Weight';
                            else if ($categName === 'dvd') echo 'Size';
                            else if ($categName === 'furniture') echo 'Dimesions';
                            ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <footer>
        <p style="text-align: center;">Scandiweb Test Assignment</p>
    </footer>
    <script src="js/index.js"></script>
</body>

</html>