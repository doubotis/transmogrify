<?php

function errorMessage($message)
{
    $content = "<div class=\"alert alert-danger\"><strong>Error:</strong> " . $message . "</div>";
    return $content;
}

function printErrorMessagesFromSession()
{
    if (isset($_SESSION["error-message"]))
    {
        echo errorMessage($_SESSION["error-message"]);
        unset($_SESSION["error-message"]);
    }
}

function successMessage($message)
{
    $content = "<div class=\"alert alert-success\"><strong>Success</strong> " . $message . "</div>";
    return $content;
}

function phpErrorMessage($errno, $message, $errfile, $errline)
{
    $content = "<div class=\"alert alert-danger\"><strong>PHP Error $errno:</strong> $message at line $errline of file $errfile</div>";
    return $content;
}

function myErrorHandler($errno, $errstr, $errfile, $errline)
{
   if (!(error_reporting() & $errno)) {
        // Ce code d'erreur n'est pas inclus dans error_reporting()
        return;
    }

    switch ($errno)
    {
    case E_USER_ERROR:
        echo phpErrorMessage($errno, $errstr, $errfile, $errline);
        break;

    case E_USER_WARNING:
        echo phpErrorMessage($errno, $errstr, $errfile, $errline);
        break;

    case E_USER_NOTICE:
        echo phpErrorMessage($errno, $errstr, $errfile, $errline);
        break;
        
    default:
        echo phpErrorMessage($errno, $errstr, $errfile, $errline);
        //throw new Exception($errstr);
        break;
    }

    /* Ne pas exécuter le gestionnaire interne de PHP */
    return true;
}
$old_error_handler = set_error_handler("myErrorHandler");

?>