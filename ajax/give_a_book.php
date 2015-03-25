<?php
require __DIR__.'/../src/DBconn.php';
require __DIR__.'/../model/Book.php';
if ($_POST["give-a-book-button"]) {
    $book = new Book(array('id' => $_POST['book']));
    $book->assignBookToOwner($_POST['owner']);
}
$host  = $_SERVER['HTTP_HOST'];
$extra = 'owners_with_books/';
header("Location: http://$host/$extra");