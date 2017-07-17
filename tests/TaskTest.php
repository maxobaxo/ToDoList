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
            $name = 'Kitchen chores';
            $test_category = new Category($name);
            $test_category->save();

            $description = "Do dishes.";
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
            $name = 'Kitchen chores';
            $test_category = new Category($name);
            $test_category->save();

            $description = "Do dishes.";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            //Act
            $test_task->setDescription("Drink coffee.");
            $result = $test_task->getDescription();

            //Assert
            $this->assertEquals("Drink coffee.", $result);
        }


        function testGetId()
        {
            //Arrange
            $name = 'Pet Chores';
            $test_category = new Category($name);
            $test_category->save();

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
            $name = 'Pet Chores';
            $test_category = new Category($name);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            //Act
            $executed = $test_task->save();

            // Assert
            $this->assertTrue($executed, "Task not successfully saved to database");
        }

        function testSetDueDate()
        {
            //Arrange
            $name = 'Pet Chores';
            $test_category = new Category($name);
            $test_category->save();

            $description = "Wash the dog";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            $new_due_date = 'July 6';

            //Act
            $test_task->setDueDate($new_due_date);
            $result = $test_task->getDueDate();

            //Assert
            $this->assertEquals($new_due_date, $result);

        }

        function testGetAll()
        {
            //Arrange
            $name = "Housework";
            $test_category = new Category($name);
            $test_category->save();

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
            $name = "Housework";
            $test_category = new Category($name);
            $test_category->save();

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
            $name = "Housework";
            $test_category = new Category($name);
            $test_category->save();

            $description = "Wash the dishes";
            $due_date = 'July 4';
            $test_task = new Task($description, $due_date);
            $test_task->save();

            $description_2 = "Water the lawn";
            $test_task_2 = new Task($description_2, $due_date);
            $test_task_2->save();

            //Act
            $id = $test_task->getId();
            $result = Task::find($id);

            //Assert
            $this->assertEquals($test_task, $result);
        }

        function testUpdate()
        {
            //Arrange
            $name = "Pet Chores";
            $test_category = new Category($name);
            $test_category->save();

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
            $name = "Pet Chores";
            $test_category = new Category($name);
            $test_category->save();

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
    }
?>
