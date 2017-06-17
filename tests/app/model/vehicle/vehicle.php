<?php
require_once('app/model/tasks/maintenanceTask.php');

class Vehicle{
    
    protected $id;
    
    protected $tasks;
    
    protected $make;
    protected $model;
    protected $odometer;
    
    protected $tasksAdded;
     /**
     
     **/
    function __construct($aId, $aMake, $aModel, $aOdometer) {
        $this->id = $aId;
        $this->make = $aMake;
        $this->model = $aModel;
        $this->odometer = $aOdometer;
        $this->tasksAdded = 0;
        
        $this->tasks = array();
    }
    
    public function getTasks(){
        return $this->tasks;
    }
    
    public function getTaskById($aTaskId){
        foreach ($this->tasks as $value){
            if($value->getId() == $aTaskId)
                return $value;
        }
        return null;
    }
    
    public function addTask($aTaskType){
        $this->tasksAdded++;
        $newTask = new MaintenanceTask($aTaskType, $this->id, $this->tasksAdded);
        array_push($this->tasks,$newTask);
        return $this->tasksAdded;
    }
    
    public function removeTask($task){
        if(($key = array_search($task, $this->tasks)) !== false) {
            unset($this->tasks[$key]);
            $this->tasks = array_values($this->tasks);
            return true;
        }
        else{
            return false;
        }
        
    }
    
    public function updateTask($task, $newProgress){
        $task->updateProgress($newProgress);
    }
    
     public function getId(){
        return $this->id;
    }
    
    public function getMake(){
        return $this->make;
    }
    
    public function setMake($aMake){
        $this->make = $aMake;
    }
    
    public function getModel(){
        return $this->model;
    }
    
    public function setModel($aModel){
        $this->model = aModel;
    }
    
    public function getOdometer(){
        return $this->odometer;
    }

    public function setOdometer($aOdometer){
        $this->odometer = $aOdometer;
    }
    
    function __destruct(){
    }
    
}

?>