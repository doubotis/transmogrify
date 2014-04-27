<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define( "GATHER_SHELL_SCRIPT_PATH", "sh /var/www/transmogrify/shell/query-wow.sh" );
define( "CHECK_SHELL_SCRIPT_PATH", "sh /var/www/transmogrify/shell/check-wow.sh" );
define( "TRANSFER_SHELL_SCRIPT_PATH", "sh /var/www/transmogrify/shell/transfer.sh" );
define( "INDEX_SHELL_SCRIPT_PATH", "sh /var/www/transmogrify/shell/query-index.sh" );

define( "COMMAND_GATHER", 1 );
define( "COMMAND_CHECK", 2 );
define( "COMMAND_TRANSFER", 3 );
define( "COMMAND_INDEX", 4 );

define( "PROCESS_NOT_EXECUTED", "notexec" );
define( "PROCESS_EXECUTING", "exec" );
define(" PROCESS_PAUSED", "paused" );

function start_process($processType)
{
    if ($processType == COMMAND_GATHER)
    {
        // We must restart the analyzing process.

        $shellExec = GATHER_SHELL_SCRIPT_PATH;
        $shellExec .= " " . intval(get_database_config("background-gather-period"));
        $process = new BackgroundProcess($shellExec);
        $process->run();
        $pid = $process->getPid();
        set_database_config("pid-background-gathering", $pid);
    }
    else if ($processType == COMMAND_CHECK)
    {
        $process = new BackgroundProcess(CHECK_SHELL_SCRIPT_PATH);
        $process->run();
        $pid = $process->getPid();
        set_database_config("pid-background-check", $pid);
    }
    else if ($processType == COMMAND_TRANSFER)
    {
        $process = new BackgroundProcess(TRANSFER_SHELL_SCRIPT_PATH);
        $process->run();
        $pid = $process->getPid();
        set_database_config("pid-background-transfer", $pid);
    }
    else if ($processType == COMMAND_INDEX)
    {
        $shellExec = INDEX_SHELL_SCRIPT_PATH;
        $shellExec .= " " . 1;
        $shellExec .= " " . intval(get_database_config("wow-index-pages-count"));
        $shellExec .= " " . intval(get_database_config("background-index-period"));
        
        $process = new BackgroundProcess($shellExec);
        $process->run();
        $pid = $process->getPid();
        set_database_config("pid-background-index", $pid);
    }
}

function kill_process($processType)
{
    if ($processType == COMMAND_GATHER)
    {
        $pid = get_database_config("pid-background-gathering");
        if ($pid != "")
        {
            $bp = new BackgroundProcess("");
            $bp->setPid($pid);
            if ($bp->isRunning())
            {
                $bp->kill();
            }
        }
        set_database_config("pid-background-gathering","");
    }
    else if ($processType == COMMAND_CHECK)
    {
        $pid = get_database_config("pid-background-check");
        if ($pid != "")
        {
            $bp = new BackgroundProcess("");
            $bp->setPid($pid);
            if ($bp->isRunning())
            {
                $bp->kill();
            }
        }
        set_database_config("pid-background-check","");
    }
    else if ($processType == COMMAND_TRANSFER)
    {
        $pid = get_database_config("pid-background-transfer");
        if ($pid != "")
        {
            $bp = new BackgroundProcess("");
            $bp->setPid($pid);
            if ($bp->isRunning())
            {
                $bp->kill();
            }
        }
        set_database_config("pid-background-transfer","");
    }
    else if ($processType == COMMAND_INDEX)
    {
        $pid = get_database_config("pid-background-index");
        if ($pid != "")
        {
            $bp = new BackgroundProcess("");
            $bp->setPid($pid);
            if ($bp->isRunning())
            {
                $bp->kill();
            }
        }
        set_database_config("pid-background-index","");
    }
}

function get_process_status($processType)
{
    if ($processType == COMMAND_GATHER)
    {
        $pid = get_database_config("pid-background-gathering");
        if ($pid != "")
        {
            $bp = new BackgroundProcess("");
            $bp->setPid($pid);
            if ($bp->isRunning())
            {
                return true;
            }
            else
            {
                set_database_config("pid-background-gathering","");
                return false;
            }
        }
        return false;
    }
    else if ($processType == COMMAND_CHECK)
    {
        $cid = get_database_config("pid-background-check");
        if ($cid != "")
        {
            $cp = new BackgroundProcess("");
            $cp->setPid($cid);
            if ($cp->isRunning())
            {
                $mode = "pause";
                return true;
            }
            else
            {
                set_database_config("pid-background-check","");
                return false;
            }
        }
        return false;
    }
    else if ($processType == COMMAND_TRANSFER)
    {
        $cid = get_database_config("pid-background-transfer");
        if ($cid != "")
        {
            $cp = new BackgroundProcess("");
            $cp->setPid($cid);
            if ($cp->isRunning())
            {
                return true;
            }
            else
            {
                set_database_config("pid-background-transfer","");
                return false;
            }
        }
        return false;
    }
    else if ($processType == COMMAND_INDEX)
    {
        $cid = get_database_config("pid-background-index");
        if ($cid != "")
        {
            $cp = new BackgroundProcess("");
            $cp->setPid($cid);
            if ($cp->isRunning())
            {
                return true;
            }
            else
            {
                set_database_config("pid-background-index","");
                return false;
            }
        }
        return false;
    }
}

function get_gather_process_status()
{
    $mode = "notexec";
    if (get_process_status(COMMAND_GATHER))
    {
        $mode = "exec";
    }
    if (get_process_status(COMMAND_CHECK))
    {
        $mode = "paused";
    }
                        
    return $mode;
}

function get_transfer_process_status()
{
    $mode = "notexec";
    if (get_process_status(COMMAND_TRANSFER))
    {
        $mode = "exec";
    }
                        
    return $mode;
}

function get_indexing_process_status()
{
    $mode = "notexec";
    if (get_process_status(COMMAND_INDEX))
    {
        $mode = "exec";
    }
    
    return $mode;
}

?>