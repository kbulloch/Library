<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Copie.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library');

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__."/../views"));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig');
    });

    $app->get("/librarian", function() use ($app) {
        return $app['twig']->render('librarian_home.twig', array('books' => Book::getAll(), 'clients' => Client::getAll() ));
    });


    return $app;

 ?>
