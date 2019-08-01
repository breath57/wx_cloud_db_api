<?php


namespace app\api\controller;


use app\api\service\Token as TokenService;
use think\Controller;

class BaseController extends Controller
{
    public function checkPrimaryScope(){
        TokenService::needPrimaryScope();
    }

    public function checkElusiveScope(){
        TokenService::needElusiveScope();
    }

    public function checkCMSScope(){
        TokenService::needCMSScope();
    }

    public function checkMostScope() {
        TokenService::needMostScope();
    }

}