<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Category::deleteAll();
          Task::deleteAll();
        }

        function testGetName()
        {
            //Arrange
            $name = "Kitchen chores";
            $test_category = new Category($name);

            //Act
            $result = $test_category->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            //Arrange
            $name = "Kitchen chores";
            $test_category = new Category($name);

            //Act
            $test_category->setName("Home chores");
            $result = $test_category->getName();

            //Assert
            $this->assertEquals("Home chores", $result);
        }

        function testGetId()
        {
            //Arrange
            $name = "Work stuff";
            $test_category = new Category($name);
            $test_category->save();

            var_dump($test_category);

            //Act
            $result = $test_category->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function testGetTasks()
        {
            //Arrange
            $name = "Home stuff";
            $test_category = new Category($name);
            $test_category->save();
            $category_id = $test_category->getId();

            $name = "Work stuff";
            $test_category2 = new Category($name);
            $test_category2->save();
            $category_id2 = $test_category2->getId();

            $description = "Wash the dog";
            $due_date = 'July 4';
            $test_task = new Task($description, $category_id, $due_date);
            $test_task->save();

            $description2 = "Take out the trash";
            $due_date2 = 'July 6';
            $test_task2 = new Task($description2, $category_id, $due_date2);
            $test_task2->save();

            $description3 = "Turn in final proposal";
            $due_date3 = 'July 10';
            $test_task3 = new Task($description3, $category_id2, $due_date3);
            $test_task3->save();

            //Act
            $result = $test_category2->getTasks();

            // var_dump($result);

            //Assert
            $this->assertEquals([$test_task3], $result);
        }

        function testSave()
        {
            //Arrange
            $name = "Work stuff";
            $test_category = new Category($name);

            //Act
            $executed = $test_category->save();

            // Assert
            $this->assertTrue($executed, "Category not successfully saved to database");
        }

        function testUpdate()
        {
            //Arrange
            $name = "Work stuff";
            $test_category = new Category($name);
            $test_category->save();

            $new_name = "Home stuff";

            //Act
            $test_category->update($new_name);

            //Assert
            $this->assertEquals("Home stuff", $test_category->getName());
        }

        function testDeleteCategory()
        {
            //Arrange
            $name = "Work stuff";
            $test_category = new Category($name);
            $test_category->save();

            $name2 = "Home stuff";
            $test_category2 = new Category($name2);
            $test_category2->save();


            //Act
            $test_category->delete();

            //Assert
            $this->assertEquals([$test_category2], Category::getAll());
        }

        function testGetAll()
        {
            //Arrange
            $name = "Work stuff";
            $test_category = new Category($name);
            $test_category->save();

            $name_2 = "Home stuff";
            $test_category_2 = new Category($name_2);
            $test_category_2->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_category, $test_category_2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $name = "Wash the dog";
            $test_category = new Category($name);
            $test_category->save();

            $name_2 = "Home stuff";
            $test_category_2 = new Category($name_2);
            $test_category_2->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $name = "Wash the dog";
            $test_category = new Category($name);
            $test_category->save();

            $name2 = "Home stuff";
            $test_category_2 = new Category($name2);
            $test_category_2->save();

            //Act
            $result = Category::find($test_category->getId());

            //Assert
            $this->assertEquals($test_category, $result);
        }
    }

?>
