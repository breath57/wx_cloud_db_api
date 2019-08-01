<?php


namespace app\api\validate;


class FileIDMissValidate   extends  BaseValidate
{
        protected $rule = [
            'collection_name' => 'require',
            'doc_id' => 'require'
        ];
}