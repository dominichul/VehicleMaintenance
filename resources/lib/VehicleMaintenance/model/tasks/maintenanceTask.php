<?php
require_once('taskProgress.php');
require_once('taskProgressEntry.php');
require_once('taskProgressLog.php');
require_once('taskType.php');
require_once('invalidTaskTypeException.php');

class MaintenanceTask{
    
    private $type;
    private $vehicleId;
    private $taskId;
    
    private $currentTaskProgress;
    private $progressLog;
    
    function __construct($aType, $aVehicleId, $aTaskId){
        switch ($aType) {
            case TaskType::OIL_CHANGE:
                //do something
                $this->type = $aType;
                break;
            case TaskType::TIRE_ROT:
                //do something
                $this->type = $aType;
                break;
            case TaskType::INSPECTION:
                //do something
                $this->type = $aType;
                break;
            default;
                //throw exception for invalid task
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
                //update progressLog
                break;
            case TaskProgress::IN_PROGRESS:
                $this->currentTaskProgress = $aProgress;
                //update progressLog
                break;
            case TaskProgress::COMPLETED:
                $this->currentTaskProgress = $aProgress;
                //update progressLog
                break;
            default:
                return null;
        }
        return true;
    }
    
    function __destruct(){
        
    }
}

?>