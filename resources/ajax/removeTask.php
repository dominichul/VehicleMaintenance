<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/lib/VehicleMaintenance/controller/vehicleManager.php");
session_start();
if(isset($_SESSION['vManager'])){
    if(isset($_POST['vehicleId']) && isset($_POST['taskId'])){
        $vehicleManager = $_SESSION['vManager'];
        if($vehicleManager->removeMaintenanceTask($_POST['vehicleId'],$_POST['taskId'])){
            try{
                $newTaskList = $vehicleManager->getVehicleTaskListItems($_POST['vehicleId']);
                $response_array["status"] = "success";
                $response_array["newTaskList"] = $newTaskList;
                echo json_encode($response_array);
            } catch (Exception $e){
                $response_array["status"] = "error";
                echo json_encode($response_array);
            }
        } else{
            $response_array["status"] = "error";
            $response_array["message"] = "Vehicle ID or Task Id is not valid";
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