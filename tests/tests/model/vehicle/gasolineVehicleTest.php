<?php

/**
 * Created by PhpStorm.
 * User: Dominic
 * Date: 6/16/2017
 * Time: 5:03 PM
 */
class gasolineVehicleTest extends PHPUnit_Framework_TestCase
{
    protected $vehicle;

    public function setUp()
    {
        $this->vehicle = new GasolineVehicle(10,"Volkswagen", "Golf", 20000);
    }

    public function testAddGoodTask(){
        $taskType = TaskType::INSPECTION;

        $this->vehicle->addTask($taskType);

        $this->assertTrue(TRUE);
    }

    public function testAddBadTask(){
        $this->expectException(InvalidTaskTypeException::class);

        $taskType = "NOT A TASK";

        $this->vehicle->addTask($taskType);
    }

    public function testGetAllowedTasks(){
        $expected = array(TaskType::OIL_CHANGE,TaskType::TIRE_ROT,TaskType::INSPECTION);

        $this->assertEquals($expected,$this->vehicle->getAllowedTasks());
    }
}