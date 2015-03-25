<?php
require __DIR__.'/../src/DBconn.php';
$id = intval($_POST['id']);
$class = (string)$_POST['class'];
require __DIR__.'/../model/'.$class.'.php';

if ($id && $class) {
    $class::delete($id);
}
