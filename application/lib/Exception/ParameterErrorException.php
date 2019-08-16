<?php


namespace app\lib\Exception;


class ParameterErrorException extends BaseException
{
        public $msg = "参数错误";
        public $code = 200;
        public $error_code = 10000;
}