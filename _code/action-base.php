<?php

include_once 'web.php';
include_once 'utils/util.php';
include_once 'utils/utils-db.php';
include_once 'utils/utils-security.php';
include_once 'utils/utils-date.php';
include_once 'locales/errors.php';
include_once 'classes/all.php';

$request_type = $_GET["req"];

// REQUETES DE NIVEAU STANDARD

if ($request_type == "register")
{
    
    if (isset($_POST["email"]) == false || $_POST["email"] == "")
        exitWithErrorAndRedirect('/transmogrify/register.php', ERROR_REGISTER_MAIL_NOT_SET);
    
    if (contains('@', $_POST["email"]) == false)
        exitWithErrorAndRedirect('/transmogrify/register.php', ERROR_REGISTER_INCORRECT_MAIL);
    
    if (isset($_POST["pseudo"]) == false || $_POST["pseudo"] == "")
        exitWithErrorAndRedirect('/transmogrify/register.php', ERROR_REGISTER_PSEUDO_NOT_SET);
    
    if (isset($_POST["password"]) == false || $_POST["password"] == "")
        exitWithErrorAndRedirect('/transmogrify/register.php', ERROR_REGISTER_PASSWORD_NOT_SET);
    
    if (isset($_POST["retape-password"]) == false || $_POST["password"] == "")
        exitWithErrorAndRedirect('/transmogrify/register.php', ERROR_REGISTER_PASSWORDS_MUST_MATCH);
    
    if ($_POST["retape-password"] != $_POST["password"])
        exitWithErrorAndRedirect('/transmogrify/register.php', ERROR_REGISTER_PASSWORDS_MUST_MATCH);
    
    $email = sql_sanitize($_POST["email"]);
    $pseudo = sql_sanitize($_POST["pseudo"]);
    $password = sql_sanitize($_POST["password"]);
    $sha1password = sha1($password);
    $type = "simple";
    
    $req = "SELECT * FROM users WHERE email LIKE '" . $email . "' AND deleted = false";
    $res = db_ask($req);
    if (count($res) > 0)
        exitWithErrorAndRedirect('/transmogrify/register.php', ERROR_REGISTER_MAIL_ALREADY_USED);
    
    $u = new User();
    $u->mail = $mail;
    $u->sha1password = $sha1password;
    $u->pseudo = $pseudo;
    $u->type = $type;
    $req = $u->get_insert_query();
    $res = db_ask($req);
    print_r($res);
    if (is_bool($res) && $res == true)
        exitAndRedirect('/transmogrify/register.php?step=2');
    else
        exitWithErrorAndRedirect('/transmogrify/register.php', ERROR_DATABASE . $res);
    
}

if ($request_type == "new-set")
{
    if (!userIsConnected())
        exitWithErrorAndRedirect('/transmogrify/_code/pagelets/create-new-set.php', ERROR_NOT_LOGGED_ON);
    
    if (isset($_POST["set-name"]) == false || $_POST["set-name"] == "")
        exitWithErrorAndRedirect('/transmogrify/_code/pagelets/create-new-set.php', ERROR_NEW_SET_NAME_NOT_SET);
    
    if (isset($_POST["set-state"]) == false || $_POST["set-name"] == "")
        exitWithErrorAndRedirect('/transmogrify/_code/pagelets/create-new-set.php', ERROR_NEW_SET_STATE_NOT_SET);
    
    if(isset($_FILES['set-image']))
    {
        $maxsize    = 65536;
        $acceptable = array(
            'image/jpeg',
            'image/jpg',
            'image/gif',
            'image/png'
        );

        if(($_FILES['set-image']['size'] >= $maxsize))
        {
            exitWithErrorAndRedirect('/transmogrify/_code/pagelets/create-new-set.php', ERROR_TOO_BIG_IMAGE);
        }
        
        if((!in_array($_FILES['set-image']['type'], $acceptable)) && (!empty($_FILES["set-image"]["type"])))
        {
            exitWithErrorAndRedirect('/transmogrify/_code/pagelets/create-new-set.php', ERROR_WRONG_TYPE_IMAGE);
        }
    }
    
    
    $setName = sql_sanitize($_POST["set-name"]);
    $itemCount = sql_sanitize($_POST["count-items"]);
    $state = sql_sanitize($_POST["set-state"]);
    $slot = sql_sanitize($_POST["equipment"]);
    if ($state == "public")
        $state = 0;
    else
        $state = 1;
    
    $equipments = split(";",$slot);
    if (count($equipments) != 12)
        exitWithErrorAndRedirect('/transmogrify/_code/pagelets/create-new-set.php', ERROR_NEW_SET_EQUIPMENT_INTEGRITY);
    $countOfEquipments = 0;
    for ($i=0; $i < count($equipments); $i++)
    {
        if (is_numeric($equipments[$i]))
            $countOfEquipments++;
    }
    if ($countOfEquipments <= 1)
        exitWithErrorAndRedirect('/transmogrify/_code/pagelets/create-new-set.php', ERROR_NEW_SET_EQUIPMENT_MANY_REQUIRED);
    
    $userid = $_SESSION["user-id"];
    
    $req = "INSERT INTO sets (id,name,items_count,slots,creator_user_id,state) VALUES (0,'$setName',$itemCount,'$slot',$userid,$state)";
    $res = db_ask($req);
    
    $req = "SELECT MAX(id) AS m FROM sets";
    $res = db_ask($req);
    $lastID = $res[0]["m"];
    
    if (isset($_FILES['set-image']) && ($_FILES["set-image"]["size"] > 0))
    {
        $imageData = stripslashes(file_get_contents($_FILES['set-image']['tmp_name']));
        $imageData = sql_sanitize($imageData);
        $format = $_FILES['set-image']['type'];
        $format = sql_sanitize($format);
        
        //header("Content-Type: image/png");
        //readfile($_FILES['set-image']['tmp_name']);
        //echo $image;
        //readfile($_FILES['set-image']['tmp_name']);
        //echo readfile("/home/mysql/temp/test.png");
        
        //$data = readfile("/home/mysql/temp/test.txt");
        //$im = imagecreatefromstring($imageData);
        //imagepng($im);
        //echo $data;
        
        $req = "INSERT INTO sets_thumbnail VALUES ($lastID,'" . $imageData . "','$format')";
        $res = db_ask($req);
        print_r($res);
        /*if (!(is_bool($res) && $res == true))
            exitWithErrorAndRedirect('/transmogrify/_code/pagelets/create-new-set.php', ERROR_DATABASE . $res);*/
    }
    
    //exitAndRedirect('/transmogrify/_code/pagelets/create-new-set.php?close=true');
    
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