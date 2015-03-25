<?php
require __DIR__.'/../vendor/autoload.php';
class DBconn {
    public static function connect () {
        return $conn = Doctrine\DBAL\DriverManager::getConnection(array(
            'driver' => 'pdo_mysql',
            'dbname' => 'library',
            'host' => 'localhost',
            'user' => 'root',
            'password' => '981tugubi',
            'charset' => 'utf8'
        ));

    }

}