<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Copie.php";
    require_once __DIR__."/../src/Checkout.php";


    $DB = new PDO('pgsql:host=localhost;dbname=library');

    $app = new Silex\Application();
    // $app['debug']=true;
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

    $app->get("/log_in", function() use ($app) {
        return $app['twig']->render('log_in_client.twig');
    });

    $app->post("/client", function() use ($app) {
        $name = $_POST['name'];
        $id = $_POST['id'];
        $checked_client = Client::find($id);
        $error = "Try with another id.";
        if ($checked_client == null) {
            $client = new Client($name, $id);
            $client->save();
            //var_dump($client);
        }
        elseif ($name == $checked_client->getName()) {
                $client = Client::find($id);
        }
        else {
            echo $error;
            return $app['twig']->render('log_in_client.twig');
        }
        $books = Book::getAll();
        return $app['twig']->render('client_home.twig',  array('books' => $books, 'client' => $client));
    });

    $app->post("/find_book", function() use ($app) {
        $new_title = $_POST['title'];
        $the_book = Book::findTitle($new_title);
        return $app['twig']->render('found_book.twig', array('book' => $the_book));

    });

    $app->post("/find_author", function() use ($app) {
        $new_name = $_POST['author'];
        $the_author = Author::findName($new_name);
        if($the_author != null) {
            $books = $the_author->getBooks();
        } else {
            $books = null;
        }
        return $app['twig']->render('found_author.twig', array('books' => $books, 'author' => $the_author));
    });

    $app->get("/{client_id}/about/{book_id}", function($client_id, $book_id) use ($app) {
        $book = Book::find($book_id);
        $authors = $book->getAuthors();
        $client = Client::find($client_id);
        $book_title = $book->getTitle();
        $total = Copie::countCopies($book_title);
        $on_shelf = Copie::countOnShelf($book_title);
        return $app['twig']->render('about_book.twig', array('on_shelf' => $on_shelf, 'total' => $total, 'book' => $book, 'authors' => $authors, 'client' => $client));
    });

    $app->get("/{client_id}/rent/{book_id}", function($client_id, $book_id) use ($app) {
        //$client_id, $due_date, $book_id, $id = null
        $book = Book::find($book_id);
        $due_date = "Tomorrow";
        $client = Client::find($client_id);
        $checkout = new Checkout($client_id, $due_date, $book_id);
        $checkout->save();
        return $app['twig']->render('rent_success.twig', array('client' => $client, 'due_date' => $due_date, 'book' => $book));
    });

    $app->get("/history_client/{client_id}", function($client_id) use ($app) {
        $client = Client::find($client_id);
        $history = $client->getHistory();
        $books = [];
        foreach($history as $element){
            $book = Book::find($element->getBookId());
            array_push($books, $book);
        }
        return $app['twig']->render('history_client.twig', array('histories' => $history, 'client' => $client, 'books' => $books));
    });



    return $app;

 ?>
