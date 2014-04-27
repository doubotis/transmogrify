<?php

class BackgroundProcess
{
    private $command;
    private $pid;

    public function __construct($command)
    {
        $this->command = $command;
    }

    public function run()
    {
        /*$this->pid = shell_exec(sprintf(
            '%s > %s 2>&1 & echo $!',
            $this->command,
            $outputFile
        ));*/
        ///dev/null
        $finalCommand =  $this->command . ' > /dev/null 2>&1 & echo $!; ';
        $this->pid = exec($finalCommand, $output, $outputStatus);
    }
    
    public function kill()
    {
        shell_exec(sprintf("kill -9 %d", $this->pid));
    }

    public function isRunning()
    {
        try {
            $result = shell_exec(sprintf('ps %d', $this->pid));
            if(count(preg_split("/\n/", $result)) > 2) {
                return true;
            }
        } catch(Exception $e) {}

        return false;
    }

    public function getPid()
    {
        return $this->pid;
    }
    
    public function setPid($newPid)
    {
        $this->pid = $newPid;
    }
}

?>