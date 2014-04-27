<?php

require_once 'utils-db.php';
//include_once dirname(__FILE__) . '/../logging.php';
//require_once dirname(__FILE__) . '/../classes/message.php';

/** Vérifie l'authentification de la personne sur base des données de la DB. */
function auth_verify($username, $password)
{
    $array = db_ask("SELECT id, username, password FROM user WHERE username LIKE '$username'");
    if ($array == false)
    {
        $_SESSION["user-id"] = "";
        return false;
    }
    
    //$_SESSION["reason"] = print_r($array, true);
    
    $codedpassword = sha1($password);
    //$_SESSION["reason"] = "From Form: " . $codedpassword . " From DB: " . $array[0]["password"];
    
    if (count($array) <= 0)
    {
        $_SESSION["user-id"] = "";
        return false;
    }
        
    
    if ($codedpassword == $array[0]["password"])
    {
        $_SESSION["user-id"] = $array[0]["id"];
        return true;
    }
    else
    {
        $_SESSION["user-id"] = "";
        return false;
    }
    
}

/** Indique si les droits de $rights sont suffisants par rapport à ceux demandés par $wanted. */
function has_sufficient_rights($rights, $wanted)
{
    
}

/** Permet l'enregistrement pour que l'utilisateur soit ensuite authorisé à se connecter. */
function register($username, $password, $mail)
{
    
}

function checkIfAdmin($user)
{
    $req = "SELECT phpbb_users.user_id AS user_id, username FROM phpbb_users INNER JOIN phpbb_user_group ON (phpbb_users.user_id = phpbb_user_group.user_id) INNER JOIN phpbb_groups ON (phpbb_groups.group_id = phpbb_user_group.group_id) WHERE phpbb_groups.group_id = 8;";
    $res = db_ask($req);
    $hasrights = false;
    for ($i=0; $i < count($res); $i++)
    {
        if ($res[$i]["user_id"] == $user->data["user_id"])
        {
            // Cette personne est autorisée, on lui affiche le bloc.
            return true;
        }
    }
    
    return false;
}

function checkIfOfficer($user)
{
    $req = "SELECT phpbb_users.user_id AS user_id, username FROM phpbb_users INNER JOIN phpbb_user_group ON (phpbb_users.user_id = phpbb_user_group.user_id) INNER JOIN phpbb_groups ON (phpbb_groups.group_id = phpbb_user_group.group_id) WHERE phpbb_groups.group_id = 8;";
    $res = db_ask($req);
    $hasrights = false;
    for ($i=0; $i < count($res); $i++)
    {
        if ($res[$i]["user_id"] == $user->data["user_id"])
        {
            // Cette personne est autorisée, on lui affiche le bloc.
            return true;
        }
    }
    
    return false;
}

function checkIfRedactor($user)
{
    $req = "SELECT phpbb_users.user_id AS user_id, username FROM phpbb_users INNER JOIN phpbb_user_group ON (phpbb_users.user_id = phpbb_user_group.user_id) INNER JOIN phpbb_groups ON (phpbb_groups.group_id = phpbb_user_group.group_id) WHERE phpbb_groups.group_id = 13;";
    $res = db_ask($req);
    $hasrights = false;
    for ($i=0; $i < count($res); $i++)
    {
        if ($res[$i]["user_id"] == $user->data["user_id"])
        {
            // Cette personne est autorisée, on lui affiche le bloc.
            return true;
        }
    }
    
    return false;
}

function checkPageIfAdmin()
{
    $isAdminEnabled = $user->data["session_admin"];
    if ($isAdminEnabled == 0)
    {
        $_SESSION["message"] = new Message("Droits insuffisants", "Vous n'avez pas les droits suffisants pour accéder à cette page.");
        header('Location: adm/login.php');
    }
}

function sql_sanitize( $sCode )
{
    $mysqli = new mysqli($GLOBALS["config"]["host"], $GLOBALS["config"]["db_auth_username"], $GLOBALS["config"]["db_auth_password"], $GLOBALS["config"]["db_auth_dbname"]);
    
    /*if ( function_exists( "mysqli_real_escape_string" ) ) { // If PHP version > 4.3.0
            */
            $sCode2 = $mysqli->real_escape_string( $sCode ); // Escape the MySQL string.
    /*} else { // If PHP version < 4.3.0
            $sCode2 = addslashes( $sCode ); // Precede sensitive characters with a slash \
    }*/
    
    $mysqli->close();
    //$sCode = htmlentities($sCode);
    return $sCode2; // Return the sanitized code
}

?>
