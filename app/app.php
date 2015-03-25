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

    $app->post("/books", function() use ($app) {
        $title = $_POST['title'];
        $author = $_POST['author'];
        $new_book = new Book($title);
        $new_book->save();
        $new_author = new Author($author);
        $new_author->save();
        $new_book->addAuthor($new_author);

        return $app['twig']->render('librarian_home.twig', array('books' => Book::getAll(), 'clients' => Client::getAll() ));
    });

    $app->delete("/delete_all_books", function() use ($app) {
        Book::deleteAll();
        return $app['twig']->render('librarian_home.twig', array('books' => Book::getAll(), 'clients' => Client::getAll() ));
    });

    $app->post("/clients", function() use ($app) {
        $name = $_POST['name'];
        $new_client = new Client($name);
        $new_client->save();
        return $app['twig']->render('librarian_home.twig', array('books' => Book::getAll(), 'clients' => Client::getAll() ));
    });

    $app->delete("/delete_all_clients", function() use ($app) {
        Client::deleteAll();
        return $app['twig']->render('librarian_home.twig', array('books' => Book::getAll(), 'clients' => Client::getAll() ));
    });

    return $app;

 ?>
