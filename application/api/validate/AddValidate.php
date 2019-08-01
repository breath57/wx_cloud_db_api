<?php


namespace app\api\validate;


class AddValidate extends BaseValidate
{
    protected $rule =[
        'collection_name' => 'require',
        'records' => 'require',
    ];
}