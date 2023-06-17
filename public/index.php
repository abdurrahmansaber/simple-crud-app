<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
use scandiweb\models\Product;

require_once __DIR__ . '/../Utils.php';

scandiweb\helpers\autoload();

$db = scandiweb\helpers\getDB();

$products = Product::getAllProducts($db);
$productsCount = count($products);

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <header>
        <h1>Products List</h1>
        <nav>
            <a href="add-product.php">
                <button id="add-product-btn">ADD</button>
            </a>
            <button id="delete-product-btn" form="delete-form" type="submit">MASS DELETE</button>
        </nav>
    </header>
    <hr>
    <div class="grid-container" id="container">
        <?php if ($productsCount > 0) : ?>
            <?php foreach ($products as $product) : ?>
                <?php $categName = strtolower(substr(strrchr(get_class($product), '\\'), 1)); ?>
                <div class="grid-item" data-id=<?php echo htmlspecialchars("{$product->getId()}") ?> data-type=<?php echo htmlspecialchars("$categName") ?>>
                    <input type="checkbox" class="delete-checkbox" name="product[]" form="delete-form" value="<?php echo htmlspecialchars("{$product->getId()}:{$categName}") ?>" />
                    <h3><?php echo htmlspecialchars($product->getSku()); ?></h3>
                    <p><?php echo htmlspecialchars($product->getName()); ?></p>
                    <p>Price: $<?php echo htmlspecialchars($product->getPrice()); ?></p>
                    <p>
                        <?php echo htmlspecialchars($product->getDescription()); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <form id="delete-form" action="delete.php" method="POST"></form>
    <hr>
    <footer>
        <p>Scandiweb Test Assignment</p>
    </footer>
    <script src="js/index.js"></script>
</body>

</html>