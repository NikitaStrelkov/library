<?php
require __DIR__.'/../src/DBconn.php';
$class = (string)$_POST['class'];
require __DIR__.'/../model/'.$class.'.php';
if($class === 'Book') {
    if($_POST["id"]) {
        $id = intval($_POST['id']);
    }
    $title = htmlspecialchars($_POST["title"], ENT_QUOTES);
    $author = htmlspecialchars($_POST["author"], ENT_QUOTES);
    $numberOfPages = htmlspecialchars($_POST["numberOfPages"], ENT_QUOTES);

    $el = new Book(array(
        'id' => $id,
        'title' => $title,
        'author' => $author,
        'numberOfPages' => $numberOfPages
    ));

} elseif ($class === 'Owner') {

    if($_POST["id"]) {
        $id = intval($_POST['id']);
    }
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES);
    $lastName = htmlspecialchars($_POST["lastName"], ENT_QUOTES);
    $job = htmlspecialchars($_POST["job"], ENT_QUOTES);

    $el = new Owner(array(
        'id' => $id,
        'name' => $name,
        'lastName' => $lastName,
        'job' => $job
    ));
}
if(isset($el)) {
    $el->saveToDB();
}
