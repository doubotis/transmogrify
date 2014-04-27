<?php
    session_start();
    
    
    include_once dirname(__FILE__) . '/utils/util.php';
    include_once dirname(__FILE__) . '/utils/utils-messages.php';
    require_once dirname(__FILE__) . '/utils/utils-config.php';
    include_once dirname(__FILE__) . '/utils/utils-process.php';
    include_once dirname(__FILE__) . '/utils/utils-quota.php';
    include_once dirname(__FILE__) . '/utils/utils-slot.php';
    include_once dirname(__FILE__) . '/utils/utils-security.php';
    include_once dirname(__FILE__) . '/utils/utils-db.php';
    include_once dirname(__FILE__) . '/utils/utils-parser.php';
    include_once dirname(__FILE__) . '/utils/utils-file.php';
    include_once dirname(__FILE__) . '/utils/utils-filter.php';
    include_once dirname(__FILE__) . '/utils/utils-pagination.php';
    include_once dirname(__FILE__) . '/classes/all.php';
    
    if (isset($_SESSION["user-id"]))
    {
        $user = new User();
        $user->id = $_SESSION["user-id"];
        $req = User::get_standard_query_for_id($user->id);
        $res = db_ask($req);
        $user = User::get_from_array($res[0]);
        $user->last_connected = time();
        $req = $user->get_update_query_connection();
        $res = db_ask($req);
        $GLOBALS["user"] = $user;
    }
    
    function oldPOSTValues($identifier)
    {
        if (!isset($_SESSION))
            return "";
        
        if (!isset($_SESSION["old-post-values"]))
            return "";
        
        if (!isset($_SESSION["old-post-values"][$identifier]))
            return "";
        
        return $_SESSION["old-post-values"][$identifier];
    }
    
    function userIsConnected()
    {
        if (isset($GLOBALS["user"]))
            return true;
        return false;
    }
    
    function userAccountType()
    {
        if (userIsConnected() == false)
            return "none";
       
        return $GLOBALS["user"]->type;
    }
    
    function preventAccessIfNeeded($condition)
    {
        if ($GLOBALS["user"]->type == USER_TYPE_SUPERADMIN)
            return;
        
        if (userAccountType() != ($condition))
        {
            header('Location: ' . "/transmogrify/login.php");
            $_SESSION["error-message"] = ERROR_NOT_SUFFICIENT_PRIVILEGES;
            exit(0);
        }
    }
    
    
?>
