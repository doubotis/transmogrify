<?php

include_once 'utils/util.php';
include_once 'utils/utils-db.php';
include_once 'utils/utils-security.php';
include_once 'utils/utils-date.php';
include_once 'locales/errors.php';
include_once 'classes/all.php';

$request_type = $_GET["req"];

print_r($_POST);

session_start();

// REQUETES DE NIVEAU STANDARD

if ($request_type == "login")
{
    
    if (isset($_POST["email"]) == false || $_POST["email"] == "")
        exitWithErrorAndRedirect('/transmogrify/login.php', ERROR_REGISTER_MAIL_NOT_SET);
    
    if (isset($_POST["password"]) == false || $_POST["password"] == "")
        exitWithErrorAndRedirect('/transmogrify/login.php', ERROR_REGISTER_PASSWORD_NOT_SET);
    
    $email = sql_sanitize($_POST["email"]);
    $password = sql_sanitize($_POST["password"]);
    $sha1password = sha1($password);
    
    $req = "SELECT * FROM users WHERE email LIKE '" . $email . "' AND password LIKE '" . $sha1password . "' AND deleted = false";
    $res = db_ask($req);
    print_r($res);
    if (count($res) == 1)
    {
        $_SESSION["user-id"] = $res[0]["id"];
        exitAndRedirect('/transmogrify/profile.php');
    }
    else
        exitWithErrorAndRedirect('/transmogrify/login.php', ERROR_LOGIN_WRONG_CREDENTIALS);
}

if ($request_type == "logout")
{
    unset($_SESSION["user-id"]);
    exitAndRedirect('/transmogrify/index.php');
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