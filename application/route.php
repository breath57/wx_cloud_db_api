<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

//Route::rule('路由表达式','路由地址','请求类型','路由参数(数组)','变量规则(数组)');
//三段式
//通用型
Route::group('api/:version/com',function (){
    //查询
    Route::post('/get/bat','api/:version.Common/batchGet');
    Route::post('/get/sig','api/:version.Common/singleGet');
    Route::post('/get/pagin','api/:version.Common/getByPaginate');
    Route::post('/get/token','api/:version.Common/getToken');
    //获得记录总数
    Route::post('get/count', 'api/:version.Common/getCount');
    //删除
    Route::post('/del/sig', 'api/:version.Common/singleDel');
    Route::post('/del/bat', 'api/:version.Common/batchDel');
    //更新
    Route::post('/upt/sig', 'api/:version.Common/singleUpt');
    Route::post('/upt/bat', 'api/:version.Common/batchUpt');
    //增加
    Route::post('/add', 'api/:version.Common/addRecords');
    //文件操作
    Route::post('/del/file', 'api/:version.Common/batchFilesDel');
    Route::post('/get/upurl', 'api/:version.Common/getUpLoadFileUrl');
    Route::post('/get/dwurl', 'api/:version.Common/getDownLoadFileUrl');
//    Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
});

//laf的
Route::post('api/:version/laf/count','api/:version.Laf/getCount');

Route::post('api/:version/sg/count','api/:version.Sg/getCount');