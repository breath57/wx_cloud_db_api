<?php


namespace app\api\validate;


class SingleUptValidate extends BaseValidate
{
    protected $rule =[
        'collection_name' => 'require',
        'upt_content' => 'require',
        'doc_id' => 'require'
    ];
}