<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/lib/VehicleMaintenance/controller/vehicleManager.php");
session_start();
if(isset($_SESSION['vManager'])){
    if(isset($_GET['vehicleId']) && isset($_GET['taskId'])){
        $vehicle = $_SESSION['vManager'];
        
        try{
        $result = $vehicle->getVehicleTaskDescription($_GET['vehicleId'],$_GET['taskId']);
        $response_array["status"] = "success";
        $response_array["taskDetails"] = $result;
        echo json_encode($response_array);
        } catch (Exception $e){
            $response_array["status"] = "error";
            $response_array["message"] ="Exception was caught";
            echo json_encode($response_array);
        }
    } else{
            $response_array["status"] = "error";
            $repsonse_array["message"] = "Vehicle ID or Task ID not defined";
            echo json_encode($response_array);
    }
} else{
    $response_array["status"] = "error";
    $repsonse_array["message"] = "Vehicle Manager Object not defined in session";
    echo json_encode($response_array);
}
?>