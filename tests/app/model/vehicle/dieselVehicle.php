<?php
require_once('vehicle.php');

class DieselVehicle extends Vehicle{
    
    private $allowedTasks;
    
    function __construct($aId, $aMake, $aModel, $aOdometer){
        
        $this->allowedTasks = array(TaskType::OIL_CHANGE, TaskType::TIRE_ROT, TaskType::INSPECTION);
        
        parent::__construct($aId, $aMake, $aModel, $aOdometer);
    }
    
    public function addTask($aTaskType){
        if(in_array($aTaskType,$this->allowedTasks))
            return parent::addTask($aTaskType);
        else{
            throw new InvalidTaskTypeException( get_class($this) . " may not be assigned this task: TaskType code: " . $aTaskType);
        }
    }
    
    public function getAllowedTasks(){
        return $this->allowedTasks;
    }
}

?>