<?php
require __DIR__.'/../vendor/autoload.php';
$app = new Silex\Application();
$app['debug'] = true;
require __DIR__.'/registers.php';
require __DIR__.'/DBconn.php';
require __DIR__ . '/../model/Owner.php';
require __DIR__.'/../model/Book.php';
require __DIR__.'/controllers.php';
return $app;