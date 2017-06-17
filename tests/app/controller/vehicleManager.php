<?php
require_once ('app/model/vehicle/gasolineVehicle.php');
require_once('app/model/vehicle//dieselVehicle.php');
require_once('app/model/vehicle//electricVehicle.php');

    class VehicleManager{
        
        private $vehicleList;

        private $totalVehicleCount;
        
        public function __construct(){
            $this->vehicleList = array();
        }
        
        //returns vehicle ID larger than 0 if successfull, null if not
        public function addVehicle($aMake, $aModel, $aOdometer, $aType){
            $vehicleId = $this->totalVehicleCount + 1;
            switch($aType){
                case "Gasoline":
                    $newVehicle = new GasolineVehicle($vehicleId, $aMake, $aModel, $aOdometer);
                    array_push($this->vehicleList, $newVehicle);
                    $this->totalVehicleCount++;
                    break;
                case "Diesel":
                    $newVehicle = new DieselVehicle($vehicleId, $aMake, $aModel, $aOdometer);
                    array_push($this->vehicleList, $newVehicle);
                    $this->totalVehicleCount++;
                    break;
                case "Electric":
                    $newVehicle = new ElectricVehicle($vehicleId, $aMake, $aModel, $aOdometer);
                    array_push($this->vehicleList, $newVehicle);
                    $this->totalVehicleCount++;
                    break;
                default:
                    return null;
            }
            return $vehicleId;
        }
        
        public function getVehicleCount(){
            return $this->totalVehicleCount;
        }
        
        //Assumes vehicle ID is relative to array's index number, and vehicle records are never removed..
        public function getVehicleById($aId){
            if(count($this->vehicleList) >= $aId && $aId>0){
                return $this->vehicleList[$aId-1];
            }
            else
                return null;
        }
        
        //Returns an array with basic vehicle attributes, its allowed maintenance tasks, and its task's properties. Returns null if vehicle is not found
        public function getVehicleInfo($aId){
            $vehicle = $this->getVehicleById($aId);
            
            if($vehicle == null){
                return null;
            }
            
            $vehicleInfo = array("id"=>$vehicle->getId(),"make"=>$vehicle->getMake(), "model"=>$vehicle->getModel(), "odometer"=>$vehicle->getOdometer());
            
            $allowedTasks = $vehicle->getAllowedTasks();
            
            $vehicleInfo["allowedTasks"] = $allowedTasks;
            
            $tasks = $vehicle->getTasks();
            
            $taskInfo = array();
            
            foreach($tasks as $task){
                array_push($taskInfo,array("taskId"=>$task->getId(), "taskType"=>$task->getType(), "taskProgress"=>$task->getCurrentProgress()));
            }
            
            $vehicleInfo["tasks"]= $taskInfo;
            
            return $vehicleInfo;
        }
        
        //return true if odometer is successfully updated. return null if not.
        public function updateVehicleOdometer($aId,$aOdometer){
            if(!is_numeric($aOdometer) || $aOdometer < 0)
                return false;
            if(($vehicle = $this->getVehicleById($aId)) == null)
                return false;
            
            $vehicle->setOdometer($aOdometer);
                return true;
        }
        
        
        //Returns task Id, task type and current task progress of a given task. Returns null if unsuccessful
        public function getVehicleTaskDescription($aId, $aTaskId){
            if(($vehicle = $this->getVehicleById($aId)) == null)
                return null;
                
            if(($task = $vehicle->getTaskById($aTaskId)) == null)
                return null;
            
            $result = array("taskId"=>$aTaskId, "taskType"=>$task->getType(), "taskProgress"=>$task->getCurrentProgress());
            
            return $result; 
        }
        
        //updates a specific tasks current progress. $aProgress must match "NOT STARTED", "IN PROGRESS", or "COMPLETED". Returns null if unsuccessful
        public function updateTaskProgress($aId, $aTaskId, $aProgress){
            if(($vehicle = $this->getVehicleById($aId)) == null)
                return false;
             
            if(($task = $vehicle->getTaskById($aTaskId)) == null)
                return false;
            
            $taskProgress = null;
            switch($aProgress){
                case "NOT STARTED":
                    $taskProgress = TaskProgress::NOT_STARTED;
                    break;
                case "IN PROGRESS":
                    $taskProgress = TaskProgress::IN_PROGRESS;
                    break;
                case "COMPLETED":
                    $taskProgress = TaskProgress::COMPLETED;
                    break;
                default:
                    $taskProgress = null;
                    return false;
            }
            
            if($task->updateProgress($taskProgress))
                return true;
            else
                return false;
        }
        
        //returns array of MaintenanceTask objects associated with vehicle of ID $aId
        public function getVehicleTaskList($aId){
            $vehicle = $this->getVehicleById($aId);

            if($vehicle) {
                $result = $vehicle->getTasks();
                return $result;
            } else {
                return null;
            }
        }
        
        //returns an array, storing task ID, and task type for each task stored within vehicle with ID $aId
        public function getVehicleTaskListItems($aId){
            $list = $this->getVehicleTaskList($aId);
            $result = array();
            foreach($list as $task){
                array_push($result, array("taskId"=>$task->getId(), "taskType"=>$task->getType()));
            }
            return $result;
        }
        
        //if task is successfully added, returns true. Otherwise returns false 
        public function addMaintenanceTask($aId,$aTaskType){
            if(($vehicle = $this->getVehicleById($aId)) == null)
                return null;
            
            $taskTypeId = null;
            
            switch($aTaskType){
                case "OIL CHANGE":
                   $taskTypeId = TaskType::OIL_CHANGE;
                    break;
                case "TIRE ROTATION":
                    $taskTypeId = TaskType::TIRE_ROT;
                    break;
                case "INSPECTION":
                    $taskTypeId = TaskType::INSPECTION;
                    break;
                default:
                    $taskTypeId = null;
                    return null;
            }
            
            try{
                return $vehicle->addTask($taskTypeId);

            return $taskId;
            } catch (InvalidTaskTypeException $e){
                echo $e;
                return null;
            }
            
        }
        
        //if task is successfully removed, returns true. Otherwise returns false
        public function removeMaintenanceTask($aId,$aTaskId){
            if(($vehicle = $this->getVehicleById($aId)) == null)
                return false;
            
            if(($task = $vehicle->getTaskById($aTaskId)) == null)
                return false;
            
            if($vehicle->removeTask($task))
                return true;
            else
                return false;
        }
        
        
        
    }
?>