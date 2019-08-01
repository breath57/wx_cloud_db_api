<?php


namespace app\api\validate;


use app\lib\Exception\AccountErrorException;
use app\lib\Exception\ParameterErrorException;

use think\Validate;

class BaseValidate  extends Validate
{
        //子类只需要编写规则就可以啦 , 超级好用哦
        public function goCheck(){
            $allData = input('param.');

//            if(array_key_exists('u',$allData)&&array_key_exists('p',$allData)){
//                if(!($allData['u']=='hzw123'&&$allData['p']=='123')){
//                    throw new AccountErrorException([
//                        'msg' => '账号或者密码错误'
//                    ]);
//                }
//            }else{
//                throw new AccountErrorException([
//                    'msg' => '请传入账号和密码'
//                ]);
//            }

            $result = $this->batch()->check($allData);
            //校验器本身 , 自带 错误信息
            if(!$result){
                throw new ParameterErrorException([
                   'msg' => $this->error ,
                    'code' => 400,
                    'error_code' => 10003
                ]);
            } else{
                return true;
            }
        }

        public static function checkJSObject($value,$rule='',$data='',$field=''){
           
        }

        protected function isPositiveInt($value,$rule='',$data='',$field=''){
            if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0){
                return true;
            } else {
                return $field."必须是正整数";
            }
        }

        protected function checkOrder($value,$rule='',$data='',$field=''){
            if(is_string($value) && ( (trim($value)=="desc")||(trim($value)=="asc") ) ){
                return true;
            } else {
                return $field."必须为 desc  或者 asc ";
            }
        }

        public function isNotEmpty($value){
            if(empty($value)){
                return false;
            }
            return true;
        }
}