<?php


namespace app\lib\Exception;


use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
        private $code;
        private $msg;
        private $error_code;
        public function render(Exception $e)
        {
            if($e instanceof BaseException){
                $this->code = $e->code;
                $this->msg = $e->msg;
                $this->error_code = $e->error_code;
            }else{
                //这种错误的返回结果适合生产环境中, 不适合开发环境中
                if(config('app_debug')){
                    return parent::render($e);
                }else{
                    $this->code = 500;
                    $this->msg = "服务器内部错误";
                    $this->error_code = 999;
                    $this->recordLog($e);
                }

            }
            return json([
                'msg' => $this->msg,
                'error_code' => $this->error_code,
                'request_url' => Request::instance()->url()
            ], $this->code);
        }

        public function recordLog(Exception $exception){
            //自定义日志系统的初始化
            Log::init([
                'type' => 'File',
                'path' => LOG_PATH,
                'level' => ['error']    //日志错误等级在 error之上的错误才会被记录
                //作用:   让开发者, 记录日志更佳的灵活, 拦截器, 过滤器是一样的
                //过滤器的思想, 拦截器的思想, 校验器的思想, 是一样的, 就是多加一层东西
                //从操作系统的角度来看, 这就是一个小型的分层, 分级的思想,
                //校验器, 对比操作系统中的, 模块化, 将某个功能分离, 专一化, 提高处理的效率, 前提是, 专一化占用的资源是新加进来
            ]);
            //记录日志
            Log::record($exception->getMessage(),'error');

        }
}