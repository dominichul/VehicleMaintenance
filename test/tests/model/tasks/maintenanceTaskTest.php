<?php

class maintenanceTaskTest extends PHPUnit_Framework_TestCase{

    protected $task;

    public function setUp()
    {
        $this->task = new MaintenanceTask("INSPECTION",2,1);
    }

    public function testGetId(){
        $expected = 1;

        $this->assertEquals($expected, $this->task->getId());
    }

    public function testGetType(){
        $expected = TaskType::INSPECTION;

        $this->assertEquals($expected, $this->task->getType());
    }

    public function testDefaultProgress(){
        $expected = TaskProgress::NOT_STARTED;

        $this->assertEquals($expected, $this->task->getCurrentProgress());
    }

    public function testUpdateProgress(){
        $expected1 = true;
        $expected2 = TaskProgress::IN_PROGRESS;

        $this->assertEquals($expected1,$this->task->updateProgress("IN PROGRESS"));
        $this->assertEquals($expected2,$this->task->getCurrentProgress());

    }
}

?>