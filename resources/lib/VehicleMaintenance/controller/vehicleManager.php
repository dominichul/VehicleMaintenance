<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/lib/VehicleMaintenance/model/vehicle/gasolineVehicle.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/lib/VehicleMaintenance/model/vehicle/dieselVehicle.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/lib/VehicleMaintenance/model/vehicle/electricVehicle.php');

    class VehicleManager{
        
        private $vehicleList;

        private $totalVehicleCount;
        
        public function __construct(){
            $this->vehicleList = array();
        }
        
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
                    //throw exception
                    break;
            }
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
            $vehicleInfo["tasks"]= $taskInfo;
            
            foreach($tasks as $task){
                array_push($taskInfo,array("taskId"=>$task->getId(), "taskType"=>$task->getType(), "taskProgress"=>$task->getProgress()));
            }
            return $vehicleInfo;
        }
        
        
        public function getVehicleTaskDescription($aId, $aTaskId){
            $vehicle = $this->getVehicleById($aId);
            
            $task = $vehicle->getTaskById($aTaskId);
            
            $result = array("taskId"=>$aTaskId, "taskType"=>$task->getType(), "taskProgress"=>$task->getCurrentProgress());
            
            return $result; 
        }
        
        public function updateTaskProgress($aId, $aTaskId, $aProgress){
            $vehicle = $this->getVehicleById($aId);
             
            $task = $vehicle->getTaskById($aTaskId);
            
            $taskProgress;
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
            }
            
            if($task->updateProgress($taskProgress))
                return $taskProgress;
            else
                return null;
        }
        
        //returns array of MaintenanceTask objects associated with vehicle of ID $aId
        public function getVehicleTaskList($aId){
            $vehicle = $this->getVehicleById($aId);
            $result = $vehicle->getTasks();
            return $result;
        }
        
        //returns ID number, task type, and current task progress for each task associated with vehicle
        public function getVehicleTaskListDescriptions($aId){
            $list = $this->getVehicleTaskList($aId);
            $result = array();
            foreach($list as $task){
                array_push($result, array("taskId"=>$task->getId(), "taskType"=>$task->getType(), "taskProgress"=>$task->getCurrentProgress()));
            }
            return $result;
        }
        
        public function getVehicleTaskListItems($aId){
            $list = $this->getVehicleTaskList($aId);
            $result = array();
            foreach($list as $task){
                array_push($result, array("taskId"=>$task->getId(), "taskType"=>$task->getType()));
            }
            return $result;
        }
        
        public function addMaintenanceTask($aId,$aTaskType){
            $vehicle = $this->getVehicleById($aId);
            
            $taskTypeId;
            
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
            }
            
            try{
            $vehicle->addTask($taskTypeId);
            } catch (InvalidTaskTypeException $e){
                echo $e;
                return false;
            }
            
            return true;
            
        }
        
        
        
    }
?>