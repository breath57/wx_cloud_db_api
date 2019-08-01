<?php


namespace app\lib\exception;


class TokenException extends BaseException
{
        public $code = 401;
        public $msg = 'Token已经过期或者Token不存在';
        public $errorCode = 10001; //自定义的错误码

}