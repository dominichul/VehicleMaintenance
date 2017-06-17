<?php
require_once('taskProgress.php');
require_once('taskType.php');
require_once('invalidTaskTypeException.php');

class MaintenanceTask{
    
    private $type;
    private $vehicleId;
    
    //$taskId only unique to its vehicle object
    private $taskId;
    
    private $currentTaskProgress;
    
    function __construct($aType, $aVehicleId, $aTaskId){
        switch ($aType) {
            case TaskType::OIL_CHANGE:
                $this->type = $aType;
                break;
            case TaskType::TIRE_ROT:
                $this->type = $aType;
                break;
            case TaskType::INSPECTION:
                $this->type = $aType;
                break;
            default;
                throw new InvalidTaskTypeException( get_class($this) . " This task is not a valid task type: " . $aType);
                break; //remove later
        }
        
        $this->currentTaskProgress = TaskProgress::NOT_STARTED;
        $this->vehicleId = $aVehicleId;
        $this->taskId = $aTaskId;
    }
    
    public function getId(){
        return $this->taskId;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function getCurrentProgress(){
        return $this->currentTaskProgress;
    }
    
    public function updateProgress($aProgress){
        switch ($aProgress) {
            case TaskProgress::NOT_STARTED:
                $this->currentTaskProgress = $aProgress;
                break;
            case TaskProgress::IN_PROGRESS:
                $this->currentTaskProgress = $aProgress;
                break;
            case TaskProgress::COMPLETED:
                $this->currentTaskProgress = $aProgress;
                break;
            default:
                return false;
        }
        return true;
    }
    
    function __destruct(){
        
    }
}

?>