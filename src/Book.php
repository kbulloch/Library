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
    }




 ?>
