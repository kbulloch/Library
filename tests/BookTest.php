<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";
    require_once "src/Book.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Book::deleteAll();
            Author::deleteAll();
        }

        function testGetTitle()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $test_book = new Book($title);

            //Act
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($title, $result);
        }

        function testSetTitle()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $test_book = new Book($title);
            $new_title = "Dragons";

            //Act
            $test_book->setTitle($new_title);
            $result = $test_book->getTitle();

            //Assert
            $this->assertEquals($new_title, $result);
        }

        function testGetId()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $id = 11;
            $test_book = new Book($title, $id);

            //Act
            $result = $test_book->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function testSetId()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $id = 11;
            $test_book = new Book($title, $id);
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
            $test_book = new Book($title);
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
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Antechrist";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            Book::deleteAll();
            $result = Book::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testUpdate()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $test_book = new Book($title);
            $test_book->save();

            $new_title = "Experiments in Murder";

            //Act
            $test_book->update($new_title);

            //Assert
            $result = $test_book->getTitle();
            $this->assertEquals($new_title, $result);
        }

        function testFind()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Antechrist";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            $result = Book::find($test_book->getId());

            //Assert
            $this->assertEquals($test_book, $result);

        }


        function testDelete()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $test_book = new Book($title);
            $test_book->save();

            $title2 = "Antechrist";
            $test_book2 = new Book($title2);
            $test_book2->save();

            //Act
            $test_book->delete();
            $result = Book::getAll();

            //Assert
            $this->assertEquals($test_book2, $result[0]);

        }

        function testGetAuthors()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $test_book = new Book($title);
            $test_book->save();

            $author_name = "Francis Bacon";
            $test_author = new Author($author_name);
            $test_author->save();

            $author_name2 = "Mike";
            $test_author2 = new Author($author_name2);
            $test_author2->save();

            $test_book->addAuthor($test_author);
            $test_book->addAuthor($test_author2);

            //Act
            $result = $test_book->getAuthors();

            //Assert
            $this->assertEquals([$test_author, $test_author2], $result);
        }

        function testAddAuthor()
        {
            //Arrange
            $title = "Dungeons and Dragons";
            $test_book = new Book($title);
            $test_book->save();

            $author_name = "Francis Bacon";
            $test_author = new Author($author_name);
            $test_author->save();

            //Act
            $test_book->addAuthor($test_author);

            //Assert
            $result = $test_book->getAuthors();
            $this->assertEquals($test_author, $result[0]);
        }


















    }

?>
