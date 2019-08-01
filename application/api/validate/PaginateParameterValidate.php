<?php


namespace app\api\validate;


class PaginateParameterValidate extends BaseValidate
{
    protected $rule = [
        'p_size' => 'require|integer|egt:1|elt:80',
        'p_number' => 'require|integer|egt:1',
        'collection_name' => 'require',
        'order_type' => 'checkOrder'
    ];

}