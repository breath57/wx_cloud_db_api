<?php


namespace app\api\validate;


use app\api\model\BaseModel;

class FileIDNotEmpty   extends BaseValidate
{
        protected $rule = [
            'file_id' => 'require'
        ];
}