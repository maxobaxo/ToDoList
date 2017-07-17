<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";
    require_once "src/Category.php";

    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class TaskTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Task::deleteAll();
            Category::deleteAll();
        }

        function testGetDescription()
        {
            //Arrange
            $description = "Do Dishes";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            //Act
            $result = $test_task->getDescription();

            //Assert
            $this->assertEquals($description, $result);
        }

        function testSetDescription()
        {
            //Arrange
            $description = "Do Dishes";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            //Act
            $test_task->setDescription("Drink Coffee");
            $result = $test_task->getDescription();

            //Assert
            $this->assertEquals("Drink Coffee", $result);
        }


        function testGetId()
        {
            //Arrange
            $description = "Wash the dog";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            //Act
            $result = $test_task->getId();

            //Assert
            $this->assertTrue(is_numeric($result));
        }

        function testSave()
        {
            //Arrange
            $description = "Wash the dog";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            //Act
            $executed = $test_task->save();

            // Assert
            $this->assertTrue($executed, "Task not successfully saved to database");
        }

        function testGetDueDate()
        {
            //Arrange
            $description = "Do Dishes";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            //Act
            $result = $test_task->getDueDate();

            //Assert
            $this->assertEquals($due_date, $result);
        }

        function testSetDueDate()
        {
            //Arrange
            $description = "Wash the dog";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            //Act
            $test_task->setDueDate("July 6");
            $result = $test_task->getDueDate();

            //Assert
            $this->assertEquals("July 6", $result);
        }

        function testGetAll()
        {
            //Arrange
            $description = "Wash the dishes";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            $description_2 = "Water the lawn";
            $test_task_2 = new Task($description_2, $due_date);
            $test_task_2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$test_task, $test_task_2], $result);
        }

        function testDeleteAll()
        {
            //Arrange
            $description = "Wash the dishes";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            $description_2 = "Water the lawn";
            $test_task_2 = new Task($description_2, $due_date);
            $test_task_2->save();

            //Act
            Task::deleteAll();

            //Assert
            $result = Task::getAll();
            $this->assertEquals([], $result);
        }

        function testFind()
        {
            //Arrange
            $description = "Wash the dishes";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            $description_2 = "Water the lawn";
            $test_task_2 = new Task($description_2, $due_date);
            $test_task_2->save();

            //Act
            $result = Task::find($test_task->getId());

            //Assert
            $this->assertEquals($test_task, $result);
        }

        function testUpdate()
        {
            //Arrange
            $description = "Bathe the dog";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            $new_description = "Clean the dog";

            //Act
            $test_task->update($new_description);

            //Assert
            $this->assertEquals("Clean the dog", $test_task->getDescription());
        }

        function testDelete()
        {
            //Arrange
            $description = "Wash the dog";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            $description2 = "Feed the dog";
            $test_task2 = new Task($description2, $due_date);
            $test_task2->save();

            //Act
            $test_task->delete();

            //Assert
            $this->assertEquals([$test_task2], Task::getAll());
        }

        function testAddCategory()
        {
            // Arrange
            $name = "Work";
            $test_category = new Category($name);
            $test_category->save();

            $description = "Do the laundry";
            $due_date = "6pm tonight";
            $test_task = new Task($description, $due_date);
            $test_task->save();

            // Act
            $test_task->addCategory($test_category);

            // Assert
            $this->assertEquals($test_task->getCategories(), [$test_category]);
        }

        function testGetCategories()
        {
            // Arrange
            $name = "Work";
            $test_category = new Category($name);
            $test_category->save();

            $name_2 = "Volunteer";
            $test_category_2 = new Category($name_2);
            $test_category_2->save();

            $description = "Prepare new client proposal";
            $due_date = "Tomorrow";
            $test_task = new Task($description, $due_date);
            $test_task->save();

            // Act
            $test_task->addCategory($test_category);
            $test_task->addCategory($test_category_2);

            // Assert
            $this->assertEquals($test_task->getCategories(), [$test_category, $test_category_2]);
        }
    }
?>
