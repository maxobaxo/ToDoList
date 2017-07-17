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

            //Act
            $result = $test_category->getId();

            //Assert
            $this->assertTrue(is_numeric($result));
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

        function testDelete()
        {
            //Arrange
            $name = "Work stuff";
            $test_category = new Category($name);
            $test_category->save();

            $description = "Launder the Sheets";
            $due_date = "Monday";
            $test_task = new Task($description, $due_date);
            $test_task->save();

            //Act
            $test_category->addTask($test_task);
            $test_category->delete();

            //Assert
            $this->assertEquals([], $test_category->getTasks());
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

        function testAddTask()
        {
            // Arrange
            $name = "Pet Chores";
            $test_category = new Category($name);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            // Act
            $test_category->addTask($test_task);

            // Assert
            $this->assertEquals($test_category->getTasks(), [$test_task]);
        }

        function testGetTasks()
        {
            // Arrange
            $name = "Home";
            $test_category = new Category($name);
            $test_category->save();

            $description = "Launder the Sheets";
            $due_date = "Monday";
            $test_task = new Task($description, $due_date);
            $test_task->save();

            $description2 = "Hang paintings";
            $due_date2 = "Friday";
            $test_task2 = new Task($description2, $due_date2);
            $test_task2->save();

            // Act
            $test_category->addTask($test_task);
            $test_category->addTask($test_task2);

            // Assert
            $this->assertEquals($test_category->getTasks(), [$test_task, $test_task2]);
        }
    }

?>
