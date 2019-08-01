<?php


namespace app\api\model;



class AppUser extends BaseModel
{
        protected static $collection_name='AppUser';
        public static $scope = 0;
    /**
     * 校验用户是否存在
     * @param $uid
     * @param $pw
     * @return bool
     * @throws \think\Exception
     */
    public static function checkUser($uid,$pw){
        $where = '{uid:"'.$uid.'",pw:"'.$pw.'"}';
        $result = BaseModel::batchesQuery(self::$collection_name,$where);
        if(array_key_exists('data',$result) && count($result['data'])==1 ){
            $data = $result['data'];
            self::$scope = ( $data[0]->scope + 0);
            return true;
        }else{
            return false;
        }
    }

}