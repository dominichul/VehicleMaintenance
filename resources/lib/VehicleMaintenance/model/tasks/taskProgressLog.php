<?php

class TaskProgressLog{
    
    private $vehicleId;
    private $taskId;
    
    private $log;
    
    function __construct($aVehicleId, $aTaskId){
        if($aVehicleID < 0 || $aTaskID < 0){
            //throw exception
        } else{
            $this->$vehicleId = $aVehicleId;
            $this->$taskId = $aTaskId;
            
            $this->$log = $array();
        }
    }
    
    function addEntry($aProgressEntry){
        if ( $aProgressEntry instanceof TaskProgressEntry ){
            array_push($this->log,$aProgressEntry);
        } else{
            //throw exception
        }
    }
    
    function getLog(){
        return $this->$log;
    }
    
    function getTaskId(){
        return $this->$taskId;
    }
    
    function getVehicleId(){
        return $this->$vehicleId;
    }
    
    function __destruct(){
        
    }
    
}

?>