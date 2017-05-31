<?php
/**
 * Created by PhpStorm.
 * User: kroshilin
 * Date: 31/05/17
 * Time: 11:04
 */

namespace SofarmLib\WinRm\Exceptions;


class PythonNotFoundException extends \Exception
{
    public $message = 'Python not found on your system';
}