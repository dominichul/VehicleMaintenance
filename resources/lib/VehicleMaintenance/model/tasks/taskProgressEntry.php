<?php

class TaskProgressEntry{
    
    private $date;
    private $progressType;
    
    function __construct($aProgressType){
        $this->$date = date("Y-m-d H:i");
        
        switch ($aProgressType){
            case TaskProgress::NOT_STARTED:
                $this->$progressType = $aProgressType;
                break;
            case TaskProgress::IN_PROGRESS:
                $this->$progressType = $aProgressType;
                break;
            case TaskProgress::COMPLETED:
                $this->$progressType = $aProgressType;
                break;
            default:
                //throw exception
                break;
        }
        
    }
    
    function getDate(){
        return $this->$date;
    }
    
    function getProgressType(){
        return $this->$progressType;
    }
    
    function __destruct(){
        
    }
    
}

?>