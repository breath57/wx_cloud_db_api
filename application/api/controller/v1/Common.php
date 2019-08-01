<?php


namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\BaseModel;
use app\api\service\AppToken;
use app\api\validate\AddValidate;
use app\api\validate\BatchUptValidate;
use app\api\validate\ComGetDataValidate;
use app\api\validate\DelFileValidate;
use app\api\validate\FileIDMissValidate;
use app\api\validate\FileIDNotEmpty;
use app\api\validate\GetToken;
use app\api\validate\PaginateParameterValidate;
use app\api\validate\SingleUptValidate;
use think\Request;

class Common extends BaseController
{
        //TODO: 预置函数
        protected $beforeActionList = [
            'checkCMSScope'  => ['only'=>'singleDel,batchUpt,batchFilesDel,batchGet,singleUpt,singleGet,
            batchDel,getDownloadFileUrl,getByPaginate,getUploadFileUrl,addRecords,getCount']
        ];

        //TODO:查询

        public static function batchGet(Request $request){
            (new ComGetDataValidate())->goCheck();
            return BaseModel::batchesQuery($request->post('collection_name'),
                $request->post('where'), $request->post('order_key'),
                $request->post('order_type'), $request->post('skip'),
                $request->post('limit'));
        }

        public static function singleGet(Request $request){
            (new FileIDMissValidate())->goCheck();
            return BaseModel::singleQuery($request->post('collection_name'),
                $request->post('doc_id'));
        }

        public static function getByPaginate(Request $request){
            (new PaginateParameterValidate())->goCheck();
            return BaseModel::queryByPaginate($request->post('collection_name'),
                $request->post('p_number'), $request->post('p_size'),
                $request->post('where'), $request->post('order_key'),
                $request->post('order_type'));
        }

        public static function getCount(){
            (new ComGetDataValidate())->goCheck();
            return BaseModel::getCount(input('param.collection_name'));
        }

        public static function getToken(Request $request) {
            (new GetToken())->goCheck();
            return AppToken::grantToken( $request->post('uid') , $request->post('pw') );
        }

        //TODO:删除

        public static function batchDel(Request $request){
            (new ComGetDataValidate())->goCheck();
            return BaseModel::batchDeleter($request->post('collection_name'),
                $request->post('where'));
        }

        public static function singleDel(Request $request){
            (new FileIDMissValidate())->goCheck();
            return BaseModel::singleDeleter($request->post('collection_name'),
                $request->post('doc_id'));
        }

        //TODO:更新

        public static function singleUpt(Request $request){
            (new SingleUptValidate())->goCheck();
            return BaseModel::singleUpdate($request->post('collection_name'),
                $request->post('doc_id'), $request->post('upt_content'));
        }

        public static function batchUpt(Request $request){
            (new BatchUptValidate())->goCheck();
            return BaseModel::batchUpdate($request->post('collection_name'),
                $request->post('where'),$request->post('upt_content'));
        }

        //TODO:增加

        public static function addRecords(Request $request){
            (new AddValidate())->goCheck();
            return BaseModel::batchAdd($request->post('collection_name'),
                $request->post('records'));
        }

        //TODO:文件操作

        //获取上传链接
        public static function getUpLoadFileUrl(Request $request){
            return BaseModel::getUpLoadFileUrl($request->post('path'));
        }
        //或者下载文件链接
        public static function getDownloadFileUrl(Request $request)
        {
            (new FileIDNotEmpty())->goCheck();
            return BaseModel::getDownloadFileUrl($request->post('file_id'));
        }
        //删除文件
        public static function batchFilesDel(Request $request){
            (new DelFileValidate())->goCheck();
            return BaseModel::batchFilesDel($request->post('fileid_list'));
        }

}