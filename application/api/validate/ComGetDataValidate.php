<?php


namespace app\api\validate;


class ComGetDataValidate extends BaseValidate
{
        protected $rule= [
            'collection_name'=>'require',
            'skip' => 'integer|egt:0',
            'limit' => 'integer|egt:1',
            'order_content' => 'checkOrder'
        ];
}