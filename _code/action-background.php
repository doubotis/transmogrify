<?php

include_once 'web.php';
include_once 'utils/util.php';
include_once 'utils/utils-db.php';
include_once 'utils/utils-security.php';
include_once 'utils/utils-date.php';
include_once 'locales/errors.php';
include_once 'classes/all.php';

define( "PROCESS_SHELL", "sh /var/www/transmogrify/shell/query-wow.sh" );

$request_type = $_GET["req"];

print_r($_POST);

// REQUETES DE NIVEAU ADMIN
preventAccessIfNeeded(USER_TYPE_ADMIN);

if ($request_type == "start-process-gather")
{
    start_process(COMMAND_GATHER);

    exitAndRedirect("/transmogrify/admin/item-gathering.php");
}

if ($request_type == "kill-process-gather")
{
    kill_process(COMMAND_GATHER);
    kill_process(COMMAND_CHECK);
    
    exitAndRedirect("/transmogrify/admin/item-gathering.php");
}

if ($request_type == "clear-gather")
{
    $req = "DELETE FROM gather_items";
    $res = db_ask($req);
    $req = "UPDATE gather_index SET storage_temp = 0";
    $res = db_ask($req);
    
    array_map('unlink', glob("/var/www/transmogrify/blobs/*"));
    
    if ($res == true)
        exitAndRedirect("/transmogrify/admin/item-temporary-store.php");
    else
        exitWithErrorAndRedirect('/transmogrify/admin/item-temporary-store.php', ERROR_DATABASE . "Unknown");
    
}

if ($request_type == "start-process-transfer")
{
    start_process(COMMAND_TRANSFER);
    
    exitAndRedirect("/transmogrify/admin/item-temporary-store.php");
}

if ($request_type == "stop-process-transfer")
{
    kill_process(COMMAND_TRANSFER);
    
    exitAndRedirect("/transmogrify/admin/item-temporary-store.php");
}

if ($request_type == "start-process-index")
{
    start_process(COMMAND_INDEX);
    
    exitAndRedirect("/transmogrify/admin/item-indexing.php");
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