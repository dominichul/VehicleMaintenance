<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/lib/VehicleMaintenance/controller/vehicleManager.php");
session_start();
if(isset($_SESSION['vManager'])){
    if (isset($_GET['id'])){
        $vehicleManager = $_SESSION['vManager'];
        try{
            $vehicleInfo = $vehicleManager->getVehicleInfo($_GET['id']);
            if($vehicleInfo != null){
                $response_array['status'] = 'success';
                $response_array['vehicleInfo'] = $vehicleInfo;
                echo json_encode($response_array);
            } else{
                $response_array['status'] = 'error';
                $response_array['message'] = 'Vehicle not found';
                echo json_encode($response_array);
            }
        } catch (Exception $e){
            $response_array['status'] = 'error';
                $response_array['message'] = 'Exception was caught';
                echo json_encode($response_array);  
        }
    }
}
else{
    $response_array['status'] = 'error';
    $repsonse_array['message'] = 'Vehicle Manager Object not defined in session';
    echo json_encode($response_array);
}
?>