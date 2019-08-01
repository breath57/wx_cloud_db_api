<?php


namespace app\api\validate;


class DelFileValidate extends BaseValidate
{
    protected $rule= [
        'fileid_list' => 'require'
    ];
}