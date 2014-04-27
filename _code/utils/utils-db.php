<?php

include_once dirname(__FILE__) . '/../config.php';
include_once dirname(__FILE__) . '/utils-logging.php';

function db_ask($request)
{
    $mysqli = new mysqli($GLOBALS["config"]["host"], $GLOBALS["config"]["db_auth_username"], $GLOBALS["config"]["db_auth_password"], $GLOBALS["config"]["db_auth_dbname"]);    
    $result = $mysqli->query($request);
    
    $log = $request;
    
    if ($mysqli->field_count == 0 && $result == false)
    {
        $errmessage = $mysqli->error;
        log_write("ERROR: " . $log . " (" . $errmessage . ")");
        return $errmessage;
    }
    if ($mysqli->field_count == 0)
    {
        log_write("UPDATE SUCCESSFUL: " . $log);
        return true;
    }
    
    $i = 0;
    $count = mysqli_num_rows($result);
    if ($count == (int)1)
    {
        $obj = array();
        $obj[0] = mysqli_fetch_array($result, MYSQLI_ASSOC);
    }
    else
    {
        $obj = array();
        while($row = mysqli_fetch_assoc($result))
        {
            $obj[$i] = $row;
            $i = $i + 1;
        }
    }
    
    log_write("SELECT SUCCESSFUL: " . $log);
    return $obj;
    
    
    /*while($row = $result->fetch_assoc())
    {
        $obj[$i] = array("name" => $row[0], "count" => $row[1]);
        $i = $i + 1;
    }*/
}

?>