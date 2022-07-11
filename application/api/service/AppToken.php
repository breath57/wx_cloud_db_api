<?php


namespace app\api\service;


use app\api\model\AppUser;
use app\api\model\BaseModel;
use app\lib\exception\TokenException;

class AppToken extends Token
{
    protected static $collection_name='AppUser';
    protected static $scope = 0;
    /**
     * 颁发令牌
     * @param $uid
     * @param $pw
     * @return array
     * @throws TokenException
     * @throws \think\Exception
     */
    public  static function grantToken($uid,$pw){
        $exist = AppUser::checkUser($uid,$pw);
        if($exist){
            $token = self::saveToCache([
                "uid" => $uid,
                'pw' => $pw,
                'scope' => AppUser::$scope
            ]);
            return [
                'token'=>$token
            ];
        }else{
            throw new TokenException([
                'msg' => "账号或密码错误",
                'code' => 200,
                'error_code' => 404
            ]);
        }
    }
}