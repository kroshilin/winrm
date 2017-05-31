<?php
/**
 * Created by PhpStorm.
 * User: kroshilin
 * Date: 31/05/17
 * Time: 11:04
 */

namespace SofarmLib\WinRm\Exceptions;


use Throwable;

class WinRmExecException extends \Exception
{
    protected $message = 'Error while executing python script. Note that you have to install https://github.com/diyan/pywinrm to use this library. ';

    public function __construct($message = "", $code, Throwable $previous = null)
    {
        $message = $this->message . $message;
        parent::__construct($message, $code, $previous);
    }
}