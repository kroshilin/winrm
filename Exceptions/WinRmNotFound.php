<?php
/**
 * Created by PhpStorm.
 * User: kroshilin
 * Date: 31/05/17
 * Time: 11:04
 */

namespace SofarmLib\WinRm\Exceptions;


class WinRmNotFound extends \Exception
{
    public $message = 'Python library winrm not found - see https://github.com/diyan/pywinrm';
}