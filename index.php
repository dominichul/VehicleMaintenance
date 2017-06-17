<!DOCTYPE html>
<html>

<head>
    <title> Vehicle Maintenance Tracking System </title>
    <?php require_once("header.php"); ?>
</head>

<body>
    <?php 
    require_once("/resources/lib/VehicleMaintenance/controller/vehicleManager.php");
    require_once("nav.php");
    ?>

    <?php
    session_start();
    if(!isset($_SESSION['vManager'])){
            $vManager = new VehicleManager();
            $_SESSION['vManager'] = $vManager;
        }
    ?>

        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-md-offset-10 col-md-2 col-sm-offset-9 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-primary form-control" id="clearSession"> Reset Data </button>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div panel-group>
                        <div class="panel panel-default">
                            <div class="panel-heading"> <b>Register a new vehicle</b> </div>
                            <div class="panel-body">
                                <form id="registerVehicle" method="post">
                                    <div class="row-fluid">
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label"> Make: </label>
                                                <input id="vehicleMake" type="text" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label"> Model: </label>
                                                <input id="vehicleModel" type="text" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label"> Odometer (km): </label>
                                                <input id="vehicleOdometer" type="number" class="form-control" required="true">
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label"> Vehicle Type: </label>
                                                <select id="vehicleType" class="form-control">
                                                <option>Gasoline</option>
                                                <option>Diesel</option>
                                                <option>Electric</option>
                                            </select>
                                            </div>
                                        </div>
                                        <div class="col-md-offset-9 col-sm-offset-6 col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label"> &nbsp; </label>
                                                <button class="btn btn-primary form-control" id="registerVehicleBtn"> Add </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
                <div class="col-md-6 col-sm-6 col-xm-12">
                    <div class="col-md-6 col-sm-6 col-xm-12">
                        <form id="findVehicleByID" action="findVehiclebyId">
                            <div class="row-fluid">
                                <div class="form-group">
                                    <label class="control-label"> Find Vehicle by ID </label>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input id="vehicleId" type="number" class="form-control">
                                        <div class="input-group-btn">
                                            <button id="vehicleSearch" class="btn btn-default"> <i class="glyphicon glyphicon-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xm-12">
                    <form id="filterVehicles" action="filterVehicles">
                        <div class="row-fluid">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label"> Filter by make and model </label>
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <select class="form-control"></select>
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-12">
                                <div class="form-group">
                                    <select class="form-control"></select>
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-12">
                                <div class="form-group">
                                    <button class="btn btn-primary" disabled> Filter </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="form-group col-md-12 col-sm-12 col-xs-12">
                    <ul class="list-group stat-panel" style="margin:0; padding: 0;">
                        <li class="list-group-item row">
                            <div class="col-md-2"> Vehicle ID: </div>
                            <div class="col-md-3"> Make: </div>
                            <div class="col-md-3"> Model: </div>
                            <div class="col-md-3"> Odometer: </div>
                            <div class="col-md-1"></div>
                        </li>
                    </ul>
                    <ul class="list-group stat-panel" id="vehicleListings" style="margin: 0; padding: 0;"></ul>
                    <button type="button" id="nextBtn" class="btn btn-default" style="float:right; margin-top: 5px; margin-left:5px;" disabled> Next </button>
                    <button type="button" id="prevBtn" class="btn btn-default" style="float:right; margin-top: 5px; margin-right:5px;" disabled> Previous </button>
                </div>
                <div class="col-xs-12">
                    <hr>
                </div>
                <div id="vehicleDisplay" class="col-xs-12" data-id="" style="display:none">
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="vehicleFormHeading"><b>Tracking Form - ID#</b> <b id="displayVehicleId"></b></div>
                            <div class="panel-body" id="vehicleFormBody">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <h4> Make: </h4>
                                        <h3 id="vehicleFormMake"></h3>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <h4> Model: </h4>
                                        <h3 id="vehicleFormModel"></h3>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-6 col-sm-offset-3 col-xs-offset-0">
                                        <h4> Odometer: </h4>
                                        <h3 id="vehicleFormOdometer"></h3>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <hr>
                                </div>
                                <div class="col-xs-12">
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label"> Select Maintenance Task </label>
                                            <select id="selectExistingTask" class="form-control"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">&nbsp; </ br>
                                </div>
                                <div id="progressSection" class="col-xs-12" style="display:none">
                                    <div class="col-xs-12">
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label"> Current Progress:&nbsp; <p id="taskProgress" class="text-danger control-label"> </p></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label"> Update Progress: </label>
                                                <select id="updateTaskProgress" class="form-control"><option>NOT STARTED</option><option>IN PROGRESS</option><option>COMPLETED</option></select>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label"> &nbsp; </label>
                                                <button id="updateTaskProgressBtn" class="btn btn-success form-control"> Update </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="col-md-3 col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label"> Update Odometer: </label>
                                                <input id="updateOdometer" class="form-control" type="number" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-sm-3 col-xs-6">
                                            <div class="form-group">
                                                <label class="control-label"> &nbsp; </label>
                                                <button id="updateOdometerBtn" class="btn btn-success form-control"> Update </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12">
                                        <div class="col-md-2 col-md-offset-0 col-sm-2 col-sm-offset-0 col-xs-offset-3 col-xs-6">
                                            <div class="form-group">
                                                <button id="removeTaskBtn" class="btn btn-danger form-control"> Delete Task </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <hr>
                                </div>
                                <div class="col-xs-12">
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        <div class="form-group">
                                            <label class="control-label"> Add New Task </label>
                                            <select class="form-control" id="selectNewTask"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-3 col-xs-6">
                                        <div class="form-group">
                                            <label class="control-label"> &nbsp; </label>
                                            <button id="addTask" class="btn btn-primary form-control"> Add </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

</body>

</html>
