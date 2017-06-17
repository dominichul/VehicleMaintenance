<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/lib/VehicleMaintenance/controller/vehicleManager.php");
session_start();

if(isset($_SESSION['vManager'])){
    unset($_SESSION['vManager']);
    $response_array["status"] = "success";
    echo json_encode($response_array);
} else{
    $response_array["status"] = "error";
    $repsonse_array["message"] = "Vehicle Manager Object not defined in session";
    echo json_encode($response_array);
}
?>