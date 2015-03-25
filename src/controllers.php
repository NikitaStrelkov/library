<?php
$app->get('/', function (Silex\Application $app)  { // Match the root route (/) and supply the application as argument
    return $app['twig']->render( // Render the page index.html.twig
        'index.html.twig',
        array()
    );
})
    ->bind('index');

$app->get('/books/', function (Silex\Application $app) {
    $books = Book::getList();
    return $app['twig']->render(
        'books.html.twig',
        array(
            'books' => $books,
        )
    );
})
    ->bind('books');

$app->get('/owners/', function (Silex\Application $app) {
    $owners = Owner::getList();
    return $app['twig']->render(
        'owners.html.twig',
        array(
            'owners' => $owners,
        )
    );
})
    ->bind('owners');

$app->get('/owners_with_books/', function (Silex\Application $app) {
    $owners = Owner::getList(true);
    $all = Owner::getList();
    $books = Book::getList(true);
    return $app['twig']->render(
        'owners_with_books.html.twig',
        array(
            'ownersWithBooks' => $owners,
            'allOwners' => $all,
            'books' => $books,
        )
    );
})
    ->bind('owners_with_books');
