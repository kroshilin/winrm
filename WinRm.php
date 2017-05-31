<?php
/**
 * Created by PhpStorm.
 * User: kroshilin
 * Date: 31/05/17
 * Time: 10:45
 */

namespace SofarmLib\WinRm;


class WinRm
{
    const PATH = "./bin/winrm-ps-exec.py";

    private $ip;
    private $login;
    private $password;
    private $execCommand;

    public function __construct(string $ip, string $login, string $password)
    {
        $this->ip = $ip;
        $this->login = $login;
        $this->password = $password;
        $this->execCommand = $this->composeExecString();
    }

    public function executeCommand(string $psCommand): \stdClass
    {
        $result = null;
        $output = [];

        exec($this->composeExecString() . $psCommand, $output, $result);
        if ($result != 0) {
            // @todo analyze output and throw exception
        } else {
            return json_decode($output);
        }
    }

    private function composeExecString()
    {
        return 'python ' . self::PATH . ' ' . $this->ip . ' ' . $this->login . ' ' . $this->password . ' ';
    }
}