<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $name = "James Brown";
            $test_author = new Author($name);

            //Act
            $result = $test_author->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            //Arrange
            $name = "James Brown";
            $test_author = new Author($name);
            $new_name = "Francis Bacon";

            //Act
            $test_author->setName($new_name);
            $result = $test_author->getName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "James Brown";
            $id = 11;
            $test_author = new Author($name, $id);

            //Act
            $result = $test_author->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function testSetId()
        {
            //Arrange
            $name = "James Brown";
            $id = 11;
            $test_author = new Author($name, $id);
            $new_id = 22;

            //Act
            $test_author->setId($new_id);
            $result = $test_author->getId();

            //Assert
            $this->assertEquals($new_id, $result);
        }

        function testSave()
        {
            //Arrange
            $name = "James Brown";
            $test_author = new Author($name);
            $test_author->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals($test_author, $result[0]);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "James Brown";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Amelie Notomb";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            Author::deleteAll();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "James Brown";
            $test_author = new Author($name);
            $test_author->save();

            $new_name = "Francis Bacon";

            //Act
            $test_author->update($new_name);

            //Assert
            $result = $test_author->getName();
            $this->assertEquals($new_name, $result);
        }

        function testFind()
        {
            //Arrange
            $name = "James Brown";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Amelie Notomb";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $result = Author::find($test_author->getId());

            //Assert
            $this->assertEquals($test_author, $result);
        }

        function testDelete()
        {
            //Arrange
            $name = "James Brown";
            $test_author = new Author($name);
            $test_author->save();

            $name2 = "Amelie Notomb";
            $test_author2 = new Author($name2);
            $test_author2->save();

            //Act
            $test_author->delete();
            $result = Author::getAll();

            //Assert
            $this->assertEquals($test_author2, $result[0]);

        }




        function testGetBooks()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $test_book = new Book($title);
            $test_book->save();

            $author_name = "Francis Bacon";
            $test_author = new Author($author_name);
            $test_author->save();

            $title2 = "Dragons";
            $test_book2 = new Book($title2);
            $test_book2->save();


            $test_author->addBook($test_book);
            $test_author->addBook($test_book2);

            //Act
            $result = $test_author->getBooks();

            //Assert
            $this->assertEquals([$test_book, $test_book2], $result);
        }

        function testAddBook()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $test_book = new Book($title);
            $test_book->save();

            $author_name = "Francis Bacon";
            $test_author = new Author($author_name);
            $test_author->save();

            //Act
            $test_author->addBook($test_book);

            //Assert
            $result = $test_author->getBooks();
            $this->assertEquals($test_book, $result[0]);
        }















    }

?>
