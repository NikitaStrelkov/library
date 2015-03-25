<?php
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../templates'
));
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
