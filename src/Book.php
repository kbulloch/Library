<?php

    class Book
    {
        private $title;
        private $id;

        function __construct($title, $id = null)
        {
            $this->title = $title;
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
            $statement = $GLOBALS['DB']->query("INSERT INTO books (title) VALUES ('{$this->getTitle()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = [];
            foreach($returned_books as $a_book){
                $title = $a_book['title'];
                $id = $a_book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books*;");
        }

        function update($new_title)
        {
            $GLOBALS['DB']->exec("UPDATE books SET title '{$new_title}' WHERE id = {$this->getId()};");
            $this->setTitle($new_title);
        }

        //written in a different way
        //if there are problems look here
        static function find($search_id)
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$search_id};");
            $returned_book = $statement->fetch(PDO::FETCH_ASSOC);
            $title = $returned_book['title'];
            $id = $returned_book['id'];
            $found_book = new Book($title, $id);
            return $found_book;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        }

        function getAuthors()
        {
            $statement = $GLOBALS['DB']->query("SELECT authors.* FROM authors JOIN
                                                books_authors ON (books.id = books_authors.book_id)
                                                join authors ON (authors.id = books_authors.author_id)
                                        WHERE books.id = {$this->getId()};");
            var_dump($statement);
            //above returns sql info
            //use author id's to get author objects from database/table
            //use author object to get names


        }

        function addAuthor($new_author)
        {

        }
    }
 ?>
