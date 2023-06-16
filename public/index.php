<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/Config.php';

spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    require_once __DIR__ . '/../php/' . $class . '.php';
});

use scandiweb\helpers\Database;
use scandiweb\models\Product;

$config = scandiweb\config\getDatabaseConfig();

$db = Database::getInstance($config['dsn'], $config['username'], $config['password'], $config['options']);

$productCatgories = Product::getAllProducts($db);
$productsCount = count($productCatgories, 1);

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
            <button id="add-product-btn">ADD</button>
            <button form="delete-form" type="submit" id="delete-product-btn">MASS DELETE</button>
        </nav>
    </header>
    <hr>
    <div class="grid-container" id="container">
        <?php if ($productsCount > 3) : ?>
            <?php foreach ($productCatgories as $categName => $products) : ?>
                <?php foreach ($products as $product) : ?>
                    <div class="grid-item clickable-div" data-id=<?php echo htmlspecialchars("{$product->getId()}") ?> data-type=<?php echo htmlspecialchars("$categName") ?>>
                        <input type="checkbox" class="delete-checkbox" name="product[]" form="delete-form" value="<?php echo htmlspecialchars("{$product->getId()}:{$categName}") ?>" />
                        <h3><?php echo htmlspecialchars($product->getSku()); ?></h3>
                        <p><?php echo htmlspecialchars($product->getName()); ?></p>
                        <p>Price: $<?php echo htmlspecialchars($product->getPrice()); ?></p>
                        <p>
                            <?php
                            if ($categName === 'book') echo htmlspecialchars('Weight: ' . $product->getWeight() . ' KG');
                            else if ($categName === 'dvd') echo htmlspecialchars('Size: ' . $product->getSize() . ' MB');
                            else if ($categName === 'furniture') echo htmlspecialchars('Dimesions: ' . $product->getLength() . 'x' . $product->getWidth() . 'x' . $product->getHeight());
                            ?>
                        </p>
                    </div>
                <?php endforeach; ?>
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