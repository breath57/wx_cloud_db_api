<?php


namespace app\api\service;


use app\api\model\User;
use app\api\model\User as UserModel;
use app\lib\exception\WeChatException;
use app\lib\ScopeEnum;
use think\Exception;

class UserToken extends Token
{
        protected $code;
        protected $wxAppID;
        protected $wxAppSecret;
        protected $wxLoginUrl;
        function __construct($code)
        {
            $this->code=$code;
            $this->wxAppID=config('wx.app_id');
            $this->wxAppSecret=config('wx.app_secret');
            $this->wxLoginUrl = sprintf(config('wx.login_url'),
                $this->wxAppID,$this->wxAppSecret,$this->code);
        }
        public function testGet(){
            $result =  curl_get($this->wxLoginUrl);
            return $result;
        }

//   这个service 主要用于 获取令牌
        public  function get(){
           $result =  curl_get($this->wxLoginUrl);
           //结果用数组比较好
            $wxResult = json_decode($result,true);
            if(empty($wxResult)){
                throw new Exception('获取session_key及open_id时异常,微信内部错误');
            }else{
                    $loginFail = array_key_exists('errcode',$wxResult);
                    if($loginFail){
                        //有错误码需要具体返回给客户
                        $this->processLoginError($wxResult);
                    }
                    else{
                        //没有问题,就将结果返回  这里只是测试
                        //具体应该是授权令牌
                        $token =  $this->grantToken($wxResult);
                        return $token;
                    }
            }
        }


        private  function prepareCached($uid){
            $cachedValue = [];
            $cachedValue['uid'] = $uid;
            $cachedValue["scope"] = ScopeEnum::User;  //数值越大 权限越高
            return $cachedValue;
        }

        private  function newUser($openid){
                $user = UserModel::create([
                    "openid"=>$openid
                ]);
                //创建成功后  返回一个模型
                return $user;
        }
        //令牌的异常处理   封装成函数,因为,其他类型的请求错误,也可以复用
        private  function processLoginError($wxResult){
            throw new WeChatException([
                "msg"=>$wxResult["errmsg"],
                "errorCode"=> $wxResult["errcode"]
            ]);
        }

}