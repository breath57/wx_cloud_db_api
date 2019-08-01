<?php


namespace app\lib\exception;


class ScopeLimitException extends BaseException
{
    public $code = 403;
    public $msg = '您没有权限访问这个接口';
    public $errorCode = 10001; //自定义的错误码

}