$(document).ready(function(){
    
    $("#registerVehicleBtn").on("click", function(e){
        e.preventDefault();
        if($('#vehicleMake').val() != "" && $('#vehicleModel').val() != "" && $('#vehicleOdometer').val() != ""){
            
            $make = $('#vehicleMake').val();
            $model = $('#vehicleModel').val();
            $odometer = $('#vehicleOdometer').val();
            $type = $('#vehicleType option:selected').text();
            
            $.ajax({
                type: "POST",
                url: "/resources/ajax/registerVehicle.php",
                data: {
                    make: $make,
                    model: $model,
                    odometer: $odometer,
                    type: $type
                },
                success: function(data) {
                    response = JSON.parse(data);
                    if(response.status == "success"){
                        alert("Successfully added vehicle record");
                        return;
                    } else if (response.status == "error"){
                        alert(response.message);
                    }
                }
            });
        }
        });
    
    $("#vehicleSearch").on("click", function(e){
        e.preventDefault();
        
        $('#vehicleDisplay').data('id',"");
        
        if($('#vehicleId').val() != "" ){
            $id = $('#vehicleId').val();
            $('#vehicleDisplay').hide();
            
            $.ajax({
                type: "GET",
                url: "/resources/ajax/findVehicle.php",
                data: {
                    id: $id
                },
                success: function(data) {
                    response = JSON.parse(data);
                    
                    if(response.status == "success"){
                        $('#displayVehicleId').empty();
                        $('#vehicleFormMake').empty();
                        $('#vehicleFormModel').empty();
                        $('#vehicleFormOdometer').empty();
                        $('#selectNewTask').empty();
                        
                        for (var i = 0; i < response['vehicleInfo']['allowedTasks'].length; i++){
                            $('#selectNewTask').append("<option>" + response['vehicleInfo']['allowedTasks'][i] + "</option>");
                        }
                        
                        $('#vehicleDisplay').data('id', response.vehicleInfo.id);
                        
                        $('#displayVehicleId').append(response.vehicleInfo.id);
                        $('#vehicleFormMake').append(response.vehicleInfo.make);
                        $('#vehicleFormModel').append(response.vehicleInfo.model);
                        $('#vehicleFormOdometer').append(response.vehicleInfo.odometer + "km");
                        
                        $('#vehicleDisplay').show();
                        
                    } else{
                        alert(response.message);
                    }
                    
                }
            });
            
        }
    });
    
    $("#addTask").on("click",function(e){
        e.preventDefault();
            
        if($('#selectNewTask option:selected').text() != "" && $('#vehicleDisplay').data('id') != ""){
            
            $taskType = $('#selectNewTask option:selected').text();
            $id = $('#vehicleDisplay').data('id');
            
            $.ajax({
                type: "POST",
                url: "/resources/ajax/addTask.php",
                data:{
                    taskType: $taskType,
                    id : $id
                },
                success: function(data) {
                    response = JSON.parse(data);
                    if(response.status == "success"){
                        
                        $('#selectExistingTask').empty();
                        $('#selectExistingTask').append("<option></option>");
                        
                        for(var i = 0; i < response['newTaskList'].length; i++){
                            $('#selectExistingTask').append("<option data-id='" + response['newTaskList'][i].taskId + "'>ID#" + response['newTaskList'][i].taskId + " " + response['newTaskList'][i].taskType + "</option>");
                        }
                        
                    }
                    else{
                        alert(response.message);
                    }
                }
            });
            
        }
    });
    
    $('#selectExistingTask').change(function(){
        if($(this).children('option:selected').text() != "" && $('#vehicleDisplay').data('id') != ""){
            $taskId = $(this).children('option:selected').data('id');
            $vehicleId = $('#vehicleDisplay').data('id');
            
            $.ajax({
                type:"GET",
                url: "/resources/ajax/getTaskDetails.php",
                data: {
                    vehicleId: $vehicleId,
                    taskId: $taskId
                },
                success: function(data){
                    response = JSON.parse(data);
                    if(response.status == "success"){
                        
                        $('#taskProgress').empty();
                        $('#taskProgress').removeClass();
                        switch(response["taskDetails"]["taskProgress"]){
                            case "NOT STARTED":
                                $('#taskProgress').addClass("text-danger control-label");
                                $('#taskProgress').append("Not Started");
                                break;
                            case "IN PROGRESS":
                                $('#taskProgress').addClass("text-info control-label");
                                $('#taskProgress').append("In Progress");
                                break;
                            case "COMPLETED":
                                $('#taskProgress').addClass("text-success control-label");
                                $('#taskProgress').append("Completed");
                                break;
                            default:
                                $('#taskProgress').addClass("text-danger control-label");
                                $('#taskProgress').append("Not Started");                              
                                
                        }
                        
                        $('#progressSection').show();
                        
                    } else{
                        alert(response.message);
                    }
            }
            });
        }
        else{
            $('#taskProgress').empty();
            $('#progressSection').hide();
        }
    });
    
    $('#updateTaskProgressBtn').on("click",function(e){
        e.preventDefault();
        if($('#updateTaskProgress option:selected').text() != ""){
            $taskId = $('#selectExistingTask option:selected').data('id');
            $vehicleId = $('#vehicleDisplay').data('id');
            $progressUpdate = $('#updateTaskProgress option:selected').text();
            $.ajax({
                type:"POST",
                url: "/resources/ajax/updateProgress.php",
                data:{
                    taskId: $taskId,
                    vehicleId: $vehicleId,
                    progressUpdate: $progressUpdate
                },
                success: function(data){
                    response = JSON.parse(data);
                    if(response.status == "success"){
                        $('#taskProgress').empty();
                        $('#taskProgress').removeClass();
                        
                        switch(response.newProgress){
                            case "NOT STARTED":
                                $('#taskProgress').addClass("text-danger control-label");
                                $('#taskProgress').append("Not Started");
                                break;
                            case "IN PROGRESS":
                                $('#taskProgress').addClass("text-info control-label");
                                $('#taskProgress').append("In Progress");
                                break;
                            case "COMPLETED":
                                $('#taskProgress').addClass("text-success control-label");
                                $('#taskProgress').append("Completed");
                                break;
                            default:
                                $('#taskProgress').addClass("text-danger control-label");
                                $('#taskProgress').append("Not Started");  
                        }
                    } else{
                        alert(response.message);
                    }
                }
           
            });
        }
    });
    
    
    
    
    });