<?php


class Checkout {
    private $client_id;
    private $due_date;
    private $book_id;
    private $id;

    function __construct($client_id, $due_date, $book_id, $id = null)
    {

    $this->client_id = $client_id;
    $this->book_id = $book_id;
    $this->due_date = $due_date;
    $this->id = $id;
    }

    function getClientId()
    {
        return $this->client_id;
    }

    function setClientId ($new_client_id)
    {
        $this->client_id = (int) $new_client_id;
    }

    function getBookId()
    {
        return $this->book_id;
    }

    function setBookId ($new_book_id)
    {
        $this->book_id = (int) $new_book_id;
    }

    function getDueDate()
    {
        return $this->due_date;
    }

    function setDueDate ($new_due_date)
    {
        $this->due_date = (string) $new_due_date;
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
        $statement = $GLOBALS['DB']->query("INSERT INTO checkouts (client_id, due_date, book_id)
                                            VALUES ({$this->getClientId()}, '{$this->getDueDate()}', {$this->getBookId()}) RETURNING id;");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setId($result['id']);
    }

    static function getAll()
    {
        $returned_checkouts = $GLOBALS['DB']->query("SELECT * FROM checkouts;");
        $checkouts = [];
        foreach($returned_checkouts as $a_checkout){
            $client_id = $a_checkout['client_id'];
            $id = $a_checkout['id'];
            $book_id = $a_checkout['book_id'];
            $due_date = $a_checkout['due_date'];
            $new_checkout = new Checkout($client_id, $due_date, $book_id, $id);
            array_push($checkouts, $new_checkout);
        }
        return $checkouts;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM checkouts *;");
    }

    // function update($new_name)
    // {
    //     $GLOBALS['DB']->exec("UPDATE checkouts SET name '{$new_name}' WHERE id = {$this->getId()};");
    //     $this->setName($new_name);
    // }

    //written in a different way
    //if there are problems look here
    // static function find($search_id)
    // {
    //     $statement = $GLOBALS['DB']->query("SELECT * FROM checkouts WHERE id = {$search_id};");
    //     $returned_checkout = $statement->fetch(PDO::FETCH_ASSOC);
    //     $client_id = $returned_checkout['client_id'];
    //     $book_id = $returned_checkout['book_id'];
    //     $due_date = $returned_checkout['due_date'];
    //     $id = $returned_checkout['id'];
    //     $found_checkout = new Checkout($client_id, $book_id, $due_date, $id);
    //     return $found_checkout;
    // }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM checkouts WHERE id = {$this->getId()};");
    }

    // function getHistory() //needs to be edited
    // {
    //     $statement = $GLOBALS['DB']->query("SELECT checkouts.* FROM checkouts
    //                                         JOIN books ON (books.id = checkouts.book_id)
    //                                         JOIN checkouts ON (checkouts.id = checkouts.client_id)
    //                                         WHERE checkouts.id = {$this->getId()};");
    //     $returned_checkouts = $statement->fetchAll(PDO::FETCH_ASSOC);
    //     $checkouts = [];
    //     foreach ($returned_checkouts as $checkout) {
    //         $due_date = $checkout['due_date'];
    //         $book_id = $checkout['book_id'];
    //         $client_id = $checkout['client_id'];
    //         $id = $checkout['id'];
    //         $new_checkout = new Checkout($due_date, $book_id, $client_id, $id);
    //         array_push($checkouts, $new_checkout);
    //     }
    //     return $checkouts;
    // }

    // function checkout($book)
    // {
    //     $due_date = 123;
    //     $GLOBALS['DB']->exec("INSERT INTO checkouts (client_id, book_id, due_date) VALUES ({$this->getId()}, {$book->getId()}), '{$due_date}';");
    // }
}
?>
