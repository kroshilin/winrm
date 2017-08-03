<?php
/**
 * Created by PhpStorm.
 * User: kroshilin
 * Date: 31/05/17
 * Time: 10:45
 */

namespace SofarmLib\WinRm;


use SofarmLib\WinRm\Exceptions\PythonNotFoundException;
use SofarmLib\WinRm\Exceptions\WinRmExecException;
use SofarmLib\WinRm\Exceptions\WinRmResponseException;

class WinRm
{
    const PATH = __DIR__  . "/bin/winrm-ps-exec.py";

    const EXIT_CODE_COMMAND_NOT_FOUND = 127;

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

    public function executeCommand(string $psCommand): string
    {
        $result = null;
        $output = [];

        $echo = exec($this->composeExecString() . escapeshellarg($psCommand), $output, $result);
        if ($result != 0) {
            switch ($result) {
                case self::EXIT_CODE_COMMAND_NOT_FOUND:
                    throw new PythonNotFoundException();
                default:
                    throw new WinRmExecException($echo, $result);
            }
        } else {
            return $this->parseResponse($output[0]);
        }
    }

    private function parseResponse(string $response)
    {
        $object = json_decode($response);
        if (!$object) {
            throw new WinRmResponseException("Json decode error " . json_last_error() . ". Response was: " . $response);
        }

        if ($object->status_code != 0) {
            throw new WinRmResponseException($object->std_err, $object->status_code);
        }

        return $object->std_out;
    }

    private function composeExecString()
    {
        return 'python ' . self::PATH . ' ' . escapeshellarg($this->ip) . ' ' . escapeshellarg($this->login) . ' ' . escapeshellarg($this->password) . ' ';
    }
}
