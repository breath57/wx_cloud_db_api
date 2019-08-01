<?php


namespace app\api\validate;


class BatchUptValidate extends BaseValidate
{
        protected $rule =[
            'collection_name' => 'require',
            'upt_content' => 'require',
            'where' => 'require'
        ];
}