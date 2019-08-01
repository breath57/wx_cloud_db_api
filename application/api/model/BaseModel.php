<?php


namespace app\api\model;

use app\lib\Exception\BaseException;
use app\lib\Exception\ParameterErrorException;
use think\Exception;
use think\Model;


class BaseModel extends Model
{
        /*
         *  默认排序:   时间 降序
         * 1.获得 所有商品的信息
         * 2.获得某个商品的信息 _id 根据商品的id
         * 3.根据校区获取商品的信息
         * 4.根据指定天数内的商品
         * 5.根据商品的ID删除商品
         * 6.批量删除指定_id商品
         * 7.删除某个商品的信息 根据_ID
         * 8.更新物品的信息
         * 9.分页的功能
         * 10.获取令牌的功能 *
         * 11.获取集合中的元素数量    *
         */

    //TODO: 查询操作

    /**
     * 批量查询器
     * @param $collection_name
     * @param int $skip
     * @param int $limit
     * @param string $where
     * @return array
     * @throws Exception
     */
        public static function batchesQuery($collection_name, $where = '{}' ,$order_key = 'addtime',$order_type = 'desc',  $skip = 0, $limit = 80, $isdecode = true){
            $url = config('wx.baseUrl').'/tcb/databasequery?access_token='.self::getAccessToken();
            $where = self::checkWhere($where);
            !($order_key&&$order_type)&&( ($order_key='addtime') | ($order_type='desc') );
            $skip||($skip=0);
            $limit||($limit=80);
            $query = 'db.collection("'.$collection_name.'").where('.$where.').orderBy("'.$order_key.'","'.
                $order_type.'").limit('.$limit.').skip('.$skip.').get()';
            $result = my_curl_post($url, $query);
            $isdecode&&self::decodeData($result);
            return $result;
        }

    /**
     * 单记录(ID)查询
     * @param $collection_name
     * @param $doc_id
     * @return array
     * @throws Exception
     */
        public static function singleQuery($collection_name, $doc_id){
            $url = 'https://api.weixin.qq.com/tcb/databasequery?access_token='.self::getAccessToken();
            $query = 'db.collection("'.$collection_name.'").doc("'.$doc_id.'").get()';
            $result = my_curl_post($url, $query);
            self::decodeData($result);
            return $result;
        }

    /**
     * 分页请求记录
     * @param $collection_name
     * @param $page_number
     * @param $page_size
     * @param $where
     * @param $order_key
     * @param $order_type
     * @return array
     * @throws BaseException
     * @throws Exception
     */
        public static function queryByPaginate($collection_name, $page_number, $page_size, $where, $order_key, $order_type){
            $result_c = (self::getCount($collection_name));
            $count = $result_c['count'] + 0;
            if($count<=0){
                throw new BaseException([
                    'msg' => $collection_name.'为空集合',
                    'error_code' => 404,
                    'code' => 404
                ]);
            }else{
                $total_pages = ceil($count/$page_size);
                if( ($total_pages+0) < ($page_number+0) ){
                    throw new BaseException([
                        'msg' => "当前请求页:".$page_number." 不存在",
                        'code' => 404,
                        'error_code' => 404
                    ]);
                }
                $skip = ($page_number-1) * $page_size;
                $limit = $page_size;
                $surplus_record = ( $total_pages+0 == $page_number+0 ) ? 0 : ($count - $skip -$limit);
                $result =  self::batchesQuery($collection_name,$where,$order_key,$order_type,$skip,$limit,false);
                self::decodeData($result);
                $pager = [
                    'skip' => $skip,
                    'limit' => $limit,
                    'total_pages'=> $total_pages,
                    'current_page'=> $page_number,
                    'surplus_record'=> $surplus_record,
                    'total' => $count
                ];
                $result['pager'] = $pager;
                return $result;
            }
        }

    /**
     * 获得记录数量
     * @param $collection_name
     * @return array
     * @throws Exception
     */
    public static function getCount($collection_name){
        $url = 'https://api.weixin.qq.com/tcb/databasecount?access_token='.self::getAccessToken();
        $query = "db.collection(\"".$collection_name."\").count()";
        return my_curl_post($url,$query);
    }

    //TODO:: 删除操作

    /**
     * 批量条件删除器
     * @param $collection_name
     * @param $where
     * @return array
     * @throws Exception
     */
        public static function batchDeleter($collection_name, $where){
            if(empty($where)) throw new BaseException(['msg' => 'where不能为空']);
            if($where&&((!(strpos($where,'{')+1)||!strpos($where,'}')))){
                throw new BaseException([
                    'msg'=>'传入的where格式必须为 { key:value }',
                    'code'=>403
                ]);
            }
            $where = self::checkWhere($where);
            $url = 'https://api.weixin.qq.com/tcb/databasedelete?access_token='.self::getAccessToken();
            $query = 'db.collection(\"'.$collection_name.'\").where('.$where.').remove()';
            return my_curl_post($url,$query);
        }

    /**
     * 单条(ID)记录删除
     * @param $collection_name
     * @param $doc_id
     * @return array
     * @throws Exception
     */
        public static function singleDeleter($collection_name, $doc_id){
            if(empty($doc_id)) throw new ParameterErrorException(['msg'=>'_id不能为空']);
            $url = 'https://api.weixin.qq.com/tcb/databasedelete?access_token='.self::getAccessToken();
            $query = 'db.collection("'.$collection_name.'").doc("'.$doc_id.'").remove()';
            return my_curl_post($url,$query);
        }

    //TODO: 更新操作

    /**
     * 单记录(ID)更新
     * @param $collection_name
     * @param $doc_id
     * @param $update_content
     * @return array
     * @throws BaseException
     * @throws Exception
     */
        public static function singleUpdate($collection_name, $doc_id, $update_content){
            $update_content = self::checkWhere($update_content,'upt_content内容格式要求为{key: value}');
            $url = 'https://api.weixin.qq.com/tcb/databaseupdate?access_token='.self::getAccessToken();
            $query = 'db.collection("'.$collection_name.'").doc("'.$doc_id.'").update({data:'.$update_content.'})';
            return my_curl_post($url,$query);
        }

    /**
     * 多记录更新
     * @param $collection_name
     * @param $where
     * @param $update_content
     * @return array
     * @throws BaseException
     * @throws Exception
     */
        public static function batchUpdate($collection_name, $where, $update_content){
            $where = self::checkWhere($where);
            $update_content = self::checkWhere($update_content,'upt_content内容格式要求为{key: value}');
            $url = 'https://api.weixin.qq.com/tcb/databaseupdate?access_token='.self::getAccessToken();
            $query = 'db.collection("'.$collection_name.'").where('.$where.').update({data:'.$update_content.'})';
            return my_curl_post($url,$query);
        }

     //TODO：增加操作

    /**
     * 批量增加记录
     * @param $collection_name
     * @param $records
     * @return array
     * @throws Exception
     */
        public static function batchAdd($collection_name, $records){
            $url = 'https://api.weixin.qq.com/tcb/databaseadd?access_token='.self::getAccessToken();
            $query = 'db.collection("'.$collection_name.'").add({data: '.$records.'})';
            return my_curl_post($url, $query);
        }

    //TODO 获取令牌操作

    /**
     * 获得access_token
     * @return mixed
     * @throws Exception
     */
    public static function getAccessToken(){
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
        $url = sprintf($url,config('wx.appid'),config('wx.secret'));
        $result= json_decode(curl_get($url), true);
        if(array_key_exists('access_token',$result)){
            return $result['access_token'];
        }
        else{
            throw new Exception("access_token获取失败");
        }
    }

    //TODO:文件操作

    /**
         * 文件批量删除
         * @param $fileList
         * @return array
         * @throws Exception
         */
        public static function batchFilesDel($fileIDList){
            $url = 'https://api.weixin.qq.com/tcb/batchdeletefile?access_token='.self::getAccessToken();
            $fileIDList = json_decode($fileIDList); //转成数组才能用啊
            return curl_post($url, ['fileid_list' => $fileIDList]);
        }

    /**
         * 获取上传文件的URL
         * @param $path
         * @return array
         * @throws Exception
         */
        public static function getUpLoadFileUrl($path){
            $url = 'https://api.weixin.qq.com/tcb/uploadfile?access_token='.self::getAccessToken();
            return curl_post($url, ['path' => $path]);
        }

    /**
         * 根据(ID)获取文件的下载地址
         * @param $file_id
         * @return array
         * @throws Exception
         */
        public static function getDownloadFileUrl($file_id)
        {
            $url = 'https://api.weixin.qq.com/tcb/batchdownloadfile?access_token=' . self::getAccessToken();
            $file_list = '[
                    {"fileid":"'.$file_id.'", "max_age":7200}
                ]';
            $file_list = json_decode($file_list);
            return curl_post($url, ['file_list' => $file_list]);
        }

    //TODO: 其他

    /**
     * 校验where格式是否符合要求
     * @param string $where
     * @param string $msg
     * @return string
     * @throws BaseException
     */
        private static function checkWhere($where='', $msg=''){
            if($where&&((!(strpos($where,'{')+1)||!strpos($where,'}')))){
                throw new BaseException([
                    'msg' => $msg ? $msg : '传入的where格式必须为 { key:value }',
                    'code' => 403
                ]);
            }
             $where||($where='{}');
            return $where;
        }

    /**
     * 将json字符串变为json对象
     * @param $result
     */
        public static function decodeData(&$result)
        {
            if (array_key_exists('data', $result) && !empty($result['data'])) {
                $length = count($result['data']);
                $data = $result['data'];
                for ($i = 0; $i < $length; $i++) {
                    $data[$i] = json_decode($data[$i]);
                }
                $result['data'] = $data;
            }
        }
}