<?php
namespace wajox\symbitcore\console;

class Command
{
    protected $command;
    protected $params = [];
    
    public function __construct($command, $params = [])
    {
        $this->command = $command;
        $this->params = $params;
    }

    public function run()
    {
        $params = [];
        foreach ($this->params as $key => $param) {
            $params[$key] = '"' . $param . '"';
        }

        $cmd = 'php ' . APP_BIN_DIR . '/run'
            . ' ' . $this->command
            . ' ' . implode(' ', $params)
            . ' >> /dev/null &';

        return shell_exec($cmd);
    }
}
