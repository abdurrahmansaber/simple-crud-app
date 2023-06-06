<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../config/db_config.php";
require_once "../src/models/book.php";
require_once "../src/utils/database.php";

$db = Database::getInstance();
echo "<pre>";
// $insertBook = new Book("test123", "test", 5, 4);
// $id = $insertBook->save($db);
// echo var_dump($id) . "<br>";
// $selectBook = Book::getById($db, 25);
// echo var_dump($selectBook) . "<br>";
$updateBook = Book::update($db, 25, ['name' => 'updatedName', 'price' => 33]);
echo var_dump($updateBook)."<br>";
$selectBook = Book::getById($db, 25);
echo var_dump($selectBook) . "<br>";
echo "</pre>";


