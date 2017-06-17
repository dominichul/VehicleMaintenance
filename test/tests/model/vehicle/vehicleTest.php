<?php

class VehicleTest extends PHPUnit_Framework_TestCase{

    protected $vehicle;

    public function setUp(){
     $this->vehicle = new Vehicle(10,"SomeMake","SomeModel", 12345);
    }

    public function testAddBadTask(){
        $this->expectException(InvalidTaskTypeException::class);

        $taskType = "NOT A TASK";

        $this->vehicle->addTask($taskType);

    }

    public function testAddGoodTask(){
        $taskType = TaskType::OIL_CHANGE;

        $this->vehicle->addTask($taskType);

        $this->assertTrue(true);
    }

    public function testRemoveTask(){
        $taskType = TaskType::OIL_CHANGE;

        $taskId = $this->vehicle->addTask($taskType);
        $this->vehicle->removeTask($this->vehicle->getTaskById($taskId));
        $expected = 0;
        $this->assertEquals($expected, count($this->vehicle->getTasks()));
    }

    public function testGetTasks(){
        $taskType = TaskType::OIL_CHANGE;

        $this->vehicle->addTask($taskType);

        $tasks = $this->vehicle->getTasks();

        $expected = 1;

        $this->assertEquals($expected, count($tasks));
        $this->assertInstanceOf(MaintenanceTask::class,$tasks[0]);
    }

    public function testValidGetTaskById(){
        $taskType = TaskType::OIL_CHANGE;

        $taskId = $this->vehicle->addTask($taskType);

        $this->assertNotNull($this->vehicle->getTaskById($taskId));

    }

    public function testInvalidGetTaskById(){
        $taskType = TaskType::OIL_CHANGE;

        $this->vehicle->addTask($taskType);

        $this->assertNull($this->vehicle->getTaskById(100));

    }

    public function testValidRemoveTask(){
        $taskType = TaskType::OIL_CHANGE;

        $taskId = $this->vehicle->addTask($taskType);
        $task = $this->vehicle->getTaskById($taskId);

        $this->assertTrue($this->vehicle->removeTask($task));

    }

    public function testInvalidRemoveTask(){
        $taskType = TaskType::OIL_CHANGE;

        $taskId = $this->vehicle->addTask($taskType);
        $task = new MaintenanceTask(TaskType::OIL_CHANGE,2,1);

        $this->assertFalse($this->vehicle->removeTask($task));

    }



}