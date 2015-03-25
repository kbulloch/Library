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

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id = {$this->getId()};");
        }






























    }
 ?>
