<?php

    class Book
    {
        private $title;
        private $author;
        private $id;

        function __construct($title, $author, $id = null)
        {
            $this->title = $title;
            $this->author = $author;
            $this->id = $id;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setTitle ($new_title)
        {
            $this->title = (string) $new_title;
        }

        function getAuthor()
        {
            return $this->author;
        }

        function setAuthor ($new_author)
        {
            $this->author = (string) $new_author;
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
            $statement = $GLOBALS['DB']->query("INSERT INTO books (title, author) VALUES ('{$this->getTitle()}', '{$this->getAuthor()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = [];
            foreach($returned_books as $a_book){
                $title = $a_book['title'];
                $author = $a_book['author'];
                $id = $a_book['id'];
                $new_book = new Book($title, $author, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books*;");
        }

        function updateTitle($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE books SET title '{$new_title}' WHERE id = {$this->getId()};");
            $this->setTitle($new_title);
        }

        function updateAuthor($new_author)
        {
            $GLOBALS['DB']->exec("UPDATE books SET author '{$new_author}' WHERE id = {$this->getId()};");
            $this->setAuthor($new_author);
        }

        //written in a different way
        //if there are problems look here
        static function find($search_id)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$search_id};");
            $returned_book = $statement->fetch(PDO::FETCH_ASSOC);
            $title = $returned_book['title'];
            $author = $returned_book['author'];
            $id = $returned_book['id'];
            $found_book = new Book($title, $author, $id);
            return $found_book;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        }






























    }
 ?>
