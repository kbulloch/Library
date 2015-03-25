<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";

//    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            //deleteALl()
        }

        function testGetTitle()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $author = "James Brown";
            $test_book = new Book($title, $author);

            //Act
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($title, $result);
        }

        function testSetTitle()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $author = "James Brown";
            $test_book = new Book($title, $author);
            $new_title = "Dragons";

            //Act
            $test_book->setTitle($new_title);
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($new_title, $result);
        }


    }

?>
