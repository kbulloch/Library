<?php

class Copie
    {
      private $id;
      private $book_id;
      private $total;
      private $on_shelf;

      function __construct($book_id, $total, $on_shelf, $id = null)
      {
        $this->book_id;
        $this->total = $total;
        $this->on_shelf = $on_shelf;
        $this->id = $id;
      }

      function setBookId($new_book_id)
      {
          $this->book_id = (int) $new_book_id;
      }
      function getBookId()
      {
          return $this->book_id;
      }

      function getId()
      {
          return $this->id;
      }
      function setId($new_id)
      {
          $this->id = (int) $new_id;
      }

      function setTotal($new_total)
      {
          $this->total = (int) $new_total;
      }
      function getTotal()
      {
        return $this->total;
      }

      function getOnShelf()
      {
        return $this->on_shelf;
      }
      function setOnShelf($new_on_shelf)
      {
          $this->on_shelf = (int) $new_on_shelf;
      }

//create new item into the database and return its id key
      function save()
      {
          $statement = $GLOBALS['DB']->query("INSERT INTO copies (book_id, total, on_shelf) VALUES ({$this->getBookId()}, {$this->getOnShelf()},  {$this->getTotal()}) RETURNING id;");
          $result = $statement->fetch(PDO::FETCH_ASSOC);
          $this->setId($result['id']);
      }
//get all the data from the database (total and id).
    //   static function getAll()
    //   {
    //       $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
    //   $tasks = array();
    //   foreach($returned_tasks as $task) {
    //       $total = $task['total'];
    //       $id = $task['id'];
    //       $on_shelf = $task['on_shelf'];
    //       $new_task = new Task($total, $id, $on_shelf);
    //       array_push($tasks, $new_task);
    //     }
    //     return $tasks;
    //     }
//delete all the data in the tasks table
//       static function deleteAll()
//       {
//           $GLOBALS['DB']->exec("DELETE FROM tasks *;");
//       }
// //search by matching id
//       static function find($search_id)
//          {
//              $found_task = null;
//              $tasks = Task::getAll();
//              foreach($tasks as $task) {
//                  $task_id = $task->getId();
//                  if ($task_id == $search_id) {
//                      $found_task = $task;
//                  }
//              }
//              return $found_task;
//          }
    //
    // $search_title = $book->getTitle();
    // $num_copies = Copie::countCopies($search_title);

        static function countCopies($search_title)
        {
            $number = 0;
            $books = Book::getAll();
            foreach ($books as $book) {
                $book_title = $book->getTitle();
                    if ($book_title == $search_title) {
                        $number++;
                    }
                }
            return $number;
        }

        static function countOnShelf($search_book_title)
        {
            $number_rented = 0;
            $books = Book::findMultiTitle($search_book_title);
            $checkouts = Checkout::getAll();
            var_dump($checkouts);
            foreach ($books as $book) {
                $book_id = $book->getId();

                foreach($checkouts as $checkout) {
                    $book_id_checkout = $checkout->getBookId();
                    if ($book_id_checkout == $book_id) {
                        $number_rented++;
                    }
                }
            }
            $total = Copie::countCopies($search_book_title);
            var_dump($total);
            var_dump($number_rented);
            $on_shelf = $total - $number_rented;
            return $on_shelf;
        }

    }



    ?>
