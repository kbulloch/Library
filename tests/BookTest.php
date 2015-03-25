<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
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

        function testGetAuthor()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $author = "James Brown";
            $test_book = new Book($title, $author);

            //Act
            $result = $test_book->getAuthor();

            //Assert
            $this->assertEquals($author, $result);
        }

        function testSetAuthor()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $author = "James Brown";
            $test_book = new Book($title, $author);
            $new_author = "Dragons";

            //Act
            $test_book->setAuthor($new_author);
            $result = $test_book->getAuthor();

            //Assert
            $this->assertEquals($new_author, $result);
        }

        function testGetId()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $author = "James Brown";
            $id = 11;
            $test_book = new Book($title, $author, $id);

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function testSetId()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $author = "James Brown";
            $id = 11;
            $test_book = new Book($title, $author, $id);
            $new_id = 22;

            //Act
            $test_book->setId($new_id);
            $result = $test_book->getId();

            //Assert
            $this->assertEquals($new_id, $result);
        }

        function testSave()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $author = "James Brown";
            $test_book = new Book($title, $author);
            $test_book->save();

            //Act
            $result = Book::getAll();

            //Assert
            $this->assertEquals($test_book, $result[0]);
        }

        function testDeleteAll()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $author = "James Brown";
            $test_book = new Book($title, $author);
            $test_book->save();

            $title2 = "Antechrist";
            $author2 = "Amelie Notomb";
            $test_book2 = new Book($title2, $author2);
            $test_book2->save();

            //Act
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testUpdateTitle()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $author = "James Brown";
            $test_book = new Book($title, $author);
            $test_book->save();

            $new_title = "Experiments in Murder";

            //Act
            $test_book->updateTitle($new_title);

            //Assert
            $result = $test_book->getTitle();
            $this->assertEquals($new_title, $result);
        }

        function testUpdateAuthor()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $author = "James Brown";
            $test_book = new Book($title, $author);
            $test_book->save();

            $new_author = "Francis Bacon";
            
            //Act
            $test_book->updateAuthor($new_author);

            //Assert
            $result = $test_book->getAuthor();
            $this->assertEquals($new_author, $result);
        }





















    }

?>
