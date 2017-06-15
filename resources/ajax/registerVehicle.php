<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/resources/lib/VehicleMaintenance/controller/vehicleManager.php");
session_start();
if(isset($_SESSION['vManager'])){
    if ($_POST['make'] && $_POST['model'] && $_POST['odometer'] && $_POST['type']){
        $vehicleManager = $_SESSION['vManager'];
        try{
            $vehicleManager->addVehicle($_POST['make'],$_POST['model'],$_POST['odometer'],$_POST['type']);
            $response_array['status'] = 'success';
            echo json_encode($response_array);
        } catch (Exception $e){
            $response_array['status'] = 'error';
            $response_array["message"] ="Exception was caught";
            echo json_encode($response_array);
        }
        
    }
} else{
    $response_array['status'] = 'error';
    $response_array['message'] = 'Vehicle Manager Object not defined in session';
    echo json_encode($response_array);
}
?>