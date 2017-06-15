<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/lib/VehicleMaintenance/controller/vehicleManager.php");
session_start();
if(isset($_SESSION['vManager'])){
    if (isset($_POST['vehicleId']) && isset($_POST['taskId']) && isset($_POST['progressUpdate'])){
        $vehicleManager = $_SESSION['vManager'];
        try{
            $progressUpdate = $vehicleManager->updateTaskProgress($_POST['vehicleId'],$_POST['taskId'],$_POST['progressUpdate']);
            $response_array['status'] = 'success';
            $response_array['newProgress'] = $progressUpdate;
            echo json_encode($response_array);
        } catch(Exception $e){
            $response_array['status'] = 'error';
            $response_array['message'] = 'Exception was caught';
            echo json_encode($response_array);
        }
    }
} else{
    $response_array['status'] = 'error';
    $response_array['message'] = 'Vehicle Manager Object not defined in session';
    echo json_encode($response_array);
}
    
?>