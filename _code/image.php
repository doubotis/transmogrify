<?php

include_once 'web.php';
include_once 'utils/util.php';
include_once 'utils/utils-db.php';
include_once 'utils/utils-security.php';
include_once 'utils/utils-date.php';
include_once 'locales/errors.php';
include_once 'classes/all.php';

$request_type = $_GET["type"];

// REQUETES DE NIVEAU STANDARD

if ($request_type == "set")
{
    $id = sql_sanitize($_GET["id"]);
    
    $req = "SELECT thumbnail,format FROM sets_thumbnail WHERE set_id = " . $id;
    $res = db_ask($req);
    if (count($res) > 0)
    {
        $image = $res[0];
        $data = $image["thumbnail"];
        $format = $image["format"];
        $data = stripslashes($data);

        header("Content-Type: " . $format);
        echo $data;        
        
    }
    else
    {
        header("Content-Type: image/png");
        readfile("/var/www/transmogrify/images/no-set-image.png");
    }
}



?>