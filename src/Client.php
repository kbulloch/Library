<?php

    class Client
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
            $statement = $GLOBALS['DB']->query("INSERT INTO clients (name, id)
                                                VALUES ('{$this->getName()}', {$this->getId()});");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            // $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = [];
            foreach($returned_clients as $a_client){
                $name = $a_client['name'];
                $id = $a_client['id'];
                $new_client = new Client($name, $id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients *;");
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET name '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        //written in a different way
        //if there are problems look here
        static function find($search_id)
        {
            $found_client = null;
            $all_clients = Client::getAll();

            foreach($all_clients as $client){
                $client_id = $client->getId();
                if ($client_id == $search_id){
                    $found_client = $client;
                }
            }
            return $found_client;




            // $found_client = null;
            // $statement = $GLOBALS['DB']->query("SELECT * FROM clients WHERE id = {$search_id};");
            // $returned_client = $statement->fetch(PDO::FETCH_ASSOC);
            // var_dump($returned_client);
            // $name = $returned_client['name'];
            // $id = $returned_client['id'];
            // $found_client = new Client($name, $id);
            // return $found_client;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
        }

        function getHistory() //needs to be edited
        {
            $statement = $GLOBALS['DB']->query("SELECT checkouts.* FROM clients
                                                JOIN books ON (books.id = checkouts.book_id)
                                                JOIN clients ON (clients.id = checkouts.client_id)
                                                WHERE clients.id = {$this->getId()};");
            $returned_checkouts = $statement->fetchAll(PDO::FETCH_ASSOC);
            $checkouts = [];
            foreach ($returned_checkouts as $checkout) {
                $due_date = $checkout['due_date'];
                $book_id = $checkout['book_id'];
                $client_id = $checkout['client_id'];
                $id = $checkout['id'];
                $new_checkout = new Checkout($due_date, $book_id, $client_id, $id);
                array_push($checkouts, $new_checkout);
            }
            return $checkouts;
        }

        function checkout($book)
        {
            $due_date = 123;
            $GLOBALS['DB']->exec("INSERT INTO checkouts (client_id, book_id, due_date) VALUES ({$this->getId()}, {$book->getId()}), '{$due_date}';");
        }
    }
 ?>
