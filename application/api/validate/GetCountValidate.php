<?php


namespace app\api\validate;


use app\api\model\BaseModel;

class GetCountValidate   extends BaseValidate
{
        protected $rule = [
            'collection_name' => 'require',
        ];
}