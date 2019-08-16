<?php


namespace app\api\service;


use app\api\model\Order;
use app\api\model\User as UserModel;
use app\lib\exception\OrderException;
use app\lib\exception\ScopeLimitException;
use app\lib\exception\TokenException;
use app\lib\OrderStatusEnum;
use app\lib\ScopeEnum;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    //TODO: 令牌的相关操作

    /**
     * 生成令牌
     * @return string
     */
    public static function generateToken(){
        $randChars = getRandChar(32);
        //用三组字符串加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //获取盐
        $salt = config('secure.token_salt');
        //md5 的方法传入变量
        return md5($randChars.$timestamp.$salt);
    }

    /**
     * 获取缓存中key为token , value的数组中,key=$key的值
     * @param $key
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
    public static function getTokenVar($key){
        //获取token  2 根据token 获取uid
        $token = Request::instance()
            ->header('token');
        if(empty($token)){
            throw new TokenException([
                'msg' => "请在header中携带token,再请求接口",
                'code' => 200 ,
                'error_code' => 403
            ]);
        }
        $vars =  Cache::get($token);
        if(!$vars){
            throw new TokenException();
        }else{
            if(!is_array($vars)){
                $vars = json_decode($vars,true);
            }
            if(array_key_exists($key,$vars)) {  //判断 传入的 key 是否存在
                return $vars[$key];
            }else{
                throw new Exception('尝试获取的Token变量并不存在. ');
            }
        }
    }

    /**
     * 获取用户的uid
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
    public static function getCurrentUid(){
        $uid = self::getTokenVar('uid');
        return $uid;
    }

    /**
     * 获取用户的令牌权限
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
    public static function getTokenScope(){
        $scope = self::getTokenVar('scope');
        return $scope;
    }

    /**
     * 校验临牌是否存在, 也就是是否还是有效的
     * @param $token
     * @return bool
     */
    public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if($exist){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * 将数据以token为关键字,存入缓存
     * @param $cacheValue
     * @return string
     * @throws TokenException
     */
    public static function saveToCache($cacheValue){
        //伪方法  假设写入了缓存 , 并生成了 token  也就是 缓存的key  =  token
        $key  = self::generateToken();
        $value  = json_encode($cacheValue);   //将数组对象 转成 字符串 , 读取的时候,还需要反序列化
        //写入缓存
        $request =  cache($key,$value,config('setting.token_expire_in')); //不是用写死的值  来编写的
        if(!$request){
            //返回一个错误 ,给 用户
            throw new TokenException([
                'msg'=>'服务器缓存异常',
                'errorCode'=>10005
            ]);
        }
        return $key;
    }

    //TODO: 权限的访问控制

    /**
     * 用户和CMS都可访问的权限
     * @return bool
     * @throws Exception
     * @throws ScopeLimitException
     * @throws TokenException
     */
    public static function needPrimaryScope(){
        $scope = self::getTokenScope();
        if(!$scope){
            if ($scope<ScopeEnum::User){
                throw new ScopeLimitException();
            }else{
                return true;
            }
        }
    }

    /**
     * 只有用户才能访问的权限, 用户的私密空间
     * @return bool
     * @throws Exception
     * @throws ScopeLimitException
     * @throws TokenException
     */
    public static function needElusiveScope(){
        $scope = self::getTokenScope();
        if(!$scope){
            if ($scope!=ScopeEnum::User){
                throw new ScopeLimitException();
            }else{
                return true;
            }
        }
    }

    /**
     *  只有最高权限的用户才能访问
     * @return bool
     * @throws Exception
     * @throws ScopeLimitException
     * @throws TokenException
     */
    public static function needMostScope(){
        $scope = self::getTokenScope();
        if(!$scope){
            if ($scope!=ScopeEnum::MostUser){
                throw new ScopeLimitException();
            }else{
                return true;
            }
        }
    }

    /**
     * CMS和最高权限可以访问
     * @return bool
     * @throws Exception
     * @throws ScopeLimitException
     * @throws TokenException
     */
    public static function needCMSScope(){
        $scope = self::getTokenScope();
        if(!$scope){
            if ($scope<ScopeEnum::CMS){
                throw new ScopeLimitException();
            }else{
                return true;
            }
        }
    }
}