<?php


namespace app\api\validate;


use think\Validate;

class IDMustBePositiveInt extends BaseValidate
{
        protected $rule = [
          'id' => 'require|isPositiveInt'
        ];

}