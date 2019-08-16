<?php


namespace app\lib\Exception;


class AccountErrorException extends BaseException
{
    public $msg = "账户信息错误";
    public $code = 200;
    public $error_code = 40003;
}