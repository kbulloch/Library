<?php

    class Author
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName ($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getId()
        {
            return $this->id;
        }

        function setId ($new_id)
        {
            $this->id = (int) $new_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO authors (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = [];
            foreach($returned_authors as $author){
                $name = $author['name'];
                $id = $author['id'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors*;");
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE authors SET name '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }


        //written in a different way
        //if there are problems look here
        static function find($search_id)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM authors WHERE id = {$search_id};");
            $returned_author = $statement->fetch(PDO::FETCH_ASSOC);
            $name = $returned_author['name'];
            $id = $returned_author['id'];
            $found_author = new Author($name, $id);
            return $found_author;
        }

        static function findName($search_name)
        {
            $found_author = null;
            $all_authors = Author::getAll();
            foreach($all_authors as $author) {
                $author_name = $author->getName();
                if ($author_name == $search_name) {
                    $found_author = $author;
                }
            }
            return $found_author;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
        }


        function getBooks()
        {
            $statement = $GLOBALS['DB']->query("SELECT books.* FROM authors
                                                JOIN books_authors ON (authors.id = books_authors.author_id)
                                                JOIN books ON (books.id = books_authors.book_id)
                                                WHERE authors.id = {$this->getId()};");
            $returned_books = $statement->fetchAll(PDO::FETCH_ASSOC);
            $books = [];
            foreach ($returned_books as $book) {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        function addBook($new_book)
        {
            $GLOBALS['DB']->exec("INSERT INTO books_authors (book_id, author_id) VALUES ({$new_book->getId()}, {$this->getId()});");
        }





    }
 ?>
