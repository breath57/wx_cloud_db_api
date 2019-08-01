<?php


namespace app\lib\Exception;


use think\Exception;

class BaseException extends Exception
{
        public $msg = "未知错误";
        public $code = 500;
        public $error_code = 999;
        public function __construct($params = [])
        {
            if(!is_array($params)) {
                return;
            }else{
                if(array_key_exists('code',$params)){
                    $this->code = $params['code'];
                }
                if(array_key_exists('msg', $params)){
                    $this->msg = $params['msg'];
                }
                if(array_key_exists('error_code', $params)){
                    $this->error_code = $params['error_code'];
                }
            }
        }
}