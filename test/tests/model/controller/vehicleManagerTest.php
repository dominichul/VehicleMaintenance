<?php

/**
 * Created by PhpStorm.
 * User: Dominic
 * Date: 6/17/2017
 * Time: 12:48 PM
 */
class vehicleManagerTest extends PHPUnit_Framework_TestCase{

    protected $vm;

    public function setUp(){
        $this->vm = new VehicleManager();
    }

    public function testAddValidVehicle(){
        $vehicleId = $this->vm->addVehicle("Ford","F-150",1000,"Gasoline");

        $this->assertNotNull($vehicleId);
    }

    public function testAddInvalidVehicle(){
        $vehicleId = $this->vm->addVehicle("Ford","F-150",1000,"NotAType");

        $this->assertNull($vehicleId);
    }

    public function testGetVehicleCount(){
        $vehicleId = $this->vm->addVehicle("Ford","F-150",1000,"Gasoline");

        $expected = 1;

        $this->assertEquals($expected,$this->vm->getVehicleCount());
    }

    public function testGetVehicleById(){
        $vehicleId = $this->vm->addVehicle("Ford","F-150",1000,"Gasoline");

        $this->assertInstanceOf(Vehicle::class, $this->vm->getVehicleById($vehicleId));
    }

    public function testValidGetVehicleInfo(){
        $vehicleId = $this->vm->addVehicle("Ford","F-150",1000,"Gasoline");

        $this->assertNotNull($this->vm->getVehicleInfo($vehicleId));
    }

    public function testInvalidGetVehicleInfo(){
        $vehicleId = $this->vm->addVehicle("Ford","F-150",1000,"Gasoline");

        $this->assertNull($this->vm->getVehicleInfo(100));
    }

    public function testValidUpdateVehicleOdometer(){
        $vehicleId = $this->vm->addVehicle("Ford","F-150",1000,"Gasoline");

        $this->assertTrue($this->vm->updateVehicleOdometer($vehicleId,2000));
    }

    public function testInvalidUpdateVehicleOdometer(){
        $vehicleId = $this->vm->addVehicle("Ford","F-150",1000,"Gasoline");

        $this->assertFalse($this->vm->updateVehicleOdometer($vehicleId,"NotValid"));
    }

    public function testAddValidMaintenanceTask(){
        $vehicleId = $this->vm->addVehicle("Tesla","Model-S",1000,"Electric");

        $this->assertNotNull($this->vm->addMaintenanceTask($vehicleId,TaskType::INSPECTION));

    }

    public function testAddInvalidMaintenanceTask(){
        $vehicleId = $this->vm->addVehicle("Tesla","Model-S",1000,"Electric");

        $this->assertNull($this->vm->addMaintenanceTask($vehicleId,TaskType::OIL_CHANGE));
    }

    public function testRemoveValidMaintenanceTask(){
        $vehicleId = $this->vm->addVehicle("Tesla","Model-S",1000,"Electric");
        $taskId = $this->vm->addMaintenanceTask($vehicleId,TaskType::INSPECTION);

        $this->assertTrue($this->vm->removeMaintenanceTask($vehicleId,$taskId));
    }

    public function testRemoveInvalidMaintenanceTask(){
        $vehicleId = $this->vm->addVehicle("Tesla","Model-S",1000,"Electric");
        $taskId = $this->vm->addMaintenanceTask($vehicleId,TaskType::INSPECTION);

        $this->assertFalse($this->vm->removeMaintenanceTask(2,2));
    }

    public function testGetVehicleTaskListItems(){
        $vehicleId = $this->vm->addVehicle("Tesla","Model-S",1000,"Electric");
        $taskId = $this->vm->addMaintenanceTask($vehicleId,TaskType::INSPECTION);

        $expected1 = 1;
        $expected2 = 1;
        $expected3 = TaskType::INSPECTION;

        $this->assertEquals($expected1, count($this->vm->getVehicleTaskListItems($vehicleId)));
        $this->assertEquals($expected2,$this->vm->getVehicleTaskListItems($vehicleId)[0]["taskId"]);
        $this->assertEquals($expected3,$this->vm->getVehicleTaskListItems($vehicleId)[0]["taskType"]);
    }

    public function testGetVehicleTaskDescription(){
        $vehicleId = $this->vm->addVehicle("Tesla","Model-S",1000,"Electric");
        $taskId = $this->vm->addMaintenanceTask($vehicleId,TaskType::INSPECTION);

        $expected1 = 1;
        $expected2 = TaskType::INSPECTION;
        $expected3 = TaskProgress::NOT_STARTED;

        $this->assertEquals($expected1,$this->vm->getVehicleTaskDescription($vehicleId,$taskId)["taskId"]);
        $this->assertEquals($expected2,$this->vm->getVehicleTaskDescription($vehicleId,$taskId)["taskType"]);
        $this->assertEquals($expected3,$this->vm->getVehicleTaskDescription($vehicleId,$taskId)["taskProgress"]);

    }

    public function testUpdateTaskProgress(){
        $vehicleId = $this->vm->addVehicle("Tesla","Model-S",1000,"Electric");
        $taskId = $this->vm->addMaintenanceTask($vehicleId,TaskType::INSPECTION);

        $this->assertTrue($this->vm->updateTaskProgress($vehicleId,$taskId,TaskProgress::IN_PROGRESS));

        $this->assertEquals(TaskProgress::IN_PROGRESS, $this->vm->getVehicleTaskDescription($vehicleId,$taskId)["taskProgress"]);
    }
}