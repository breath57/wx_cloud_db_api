<?php


namespace app\api\validate;



class GetToken extends BaseValidate
{
        protected $rule = [
          'uid' => 'require|isNotEmpty',
          'pw' => 'require|isNotEmpty'
        ];
}