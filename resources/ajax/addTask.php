<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/lib/VehicleMaintenance/controller/vehicleManager.php");
session_start();
if(isset($_SESSION['vManager'])){
    if(isset($_POST['taskType']) && isset($_POST['id'])){
        $vehicleManager = $_SESSION['vManager'];
        if($vehicleManager->addMaintenanceTask($_POST['id'],$_POST['taskType'])){
            try{
                $newTaskList = $vehicleManager->getVehicleTaskListItems($_POST['id']);
                $response_array["status"] = "success";
                $response_array["newTaskList"] = $newTaskList;
                echo json_encode($response_array);
            } catch (Exception $e){
                $response_array["status"] = "error";
                echo json_encode($response_array);
            }
        } else{
            $response_array["status"] = "error";
            $response_array["message"] = "Vehicle ID or Task Type is not defined";
            echo json_encode($response_array); 
        }
    }
}
else{
    $response_array["status"] = "error";
    $repsonse_array["message"] = "Vehicle Manager Object not defined in session";
    echo json_encode($response_array);
}


?>