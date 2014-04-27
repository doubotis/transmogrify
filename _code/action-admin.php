<?php

include_once 'web.php';
include_once 'utils/util.php';
include_once 'utils/utils-db.php';
include_once 'utils/utils-security.php';
include_once 'utils/utils-date.php';
include_once 'locales/errors.php';
include_once 'classes/all.php';

$request_type = $_GET["req"];

print_r($_POST);

// REQUETES DE NIVEAU ADMIN
preventAccessIfNeeded(USER_TYPE_ADMIN);

if ($request_type == "set-config")
{
    $configName = $_GET["name"];
    $configValue = $_POST["config-value"];
    $res = set_database_config($configName, $configValue);
    
    if ($res == true)
        exitAndRedirect("/transmogrify/admin/config.php");
    else
        exitWithErrorAndRedirect('/transmogrify/admin/config.php', ERROR_DATABASE . $res);
}

//

function exitWithErrorAndRedirect($location, $code)
{
    header('Location: ' . $location);
    $_SESSION["error-message"] = $code;
    $_SESSION["old-post-values"] = $_POST;
    exit(0);
}

function exitAndRedirect($location)
{
    header('Location: ' . $location);
    exit(0);
}

?>