<?php

/**
 * Created by PhpStorm.
 * User: Dominic
 * Date: 6/16/2017
 * Time: 4:42 PM
 */
class electricVehicleTest extends PHPUnit_Framework_TestCase{

    protected $vehicle;

    public function setUp()
    {
        $this->vehicle = new ElectricVehicle(10,"Tesla", "Model X", 20000);
    }

    public function testAddGoodTask(){
        $taskType = TaskType::INSPECTION;

        $this->vehicle->addTask($taskType);

        $this->assertTrue(TRUE);
    }

    public function testAddBadTask(){
        $this->expectException(InvalidTaskTypeException::class);

        $taskType = TaskType::OIL_CHANGE;

        $this->vehicle->addTask($taskType);
    }

    public function testGetAllowedTasks(){
        $expected = array(TaskType::TIRE_ROT,TaskType::INSPECTION);

        $this->assertEquals($expected,$this->vehicle->getAllowedTasks());
    }
}