<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Author.php";

    $DB = new PDO('pgsql:host=localhost;dbname=library_test');

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
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


















    }

?>
