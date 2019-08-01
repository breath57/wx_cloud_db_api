<?php

/**
 * @param string $url get请求地址
 * @param int $httpCode 返回状态码
 * @return mixed
 */
function curl_get($url, &$httpCode = 0)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //不做证书校验,部署在linux环境下请改为true
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $file_contents = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $file_contents;
}
/**
 * post 发送JSON 格式数据
 * @param $url string URL
 * @param array $post_data_arr string 请求的具体内容
 * @return array
 *   code 状态码
 *   result 返回结果
 */
function curl_post($url, $post_data_arr = []) {
    $post_data_arr['env'] = config('wx.env');
//    var_dump($post_data_arr);
    $data_string = json_encode($post_data_arr,true);
    //初始化
    $ch = curl_init();
    //设置post方式提交
    curl_setopt($ch, CURLOPT_POST, 1);
    //设置抓取的url
    curl_setopt($ch, CURLOPT_URL, $url);
    //设置post数据   post需要提交的数据,  就是body中需要的数据
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
    //设置头文件的信息作为数据流输出
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
    );
    ob_start();
    //执行命令
    curl_exec($ch);
    $return_content = ob_get_contents();
    ob_end_clean();
    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $return_content = json_decode($return_content,true);
    return $return_content;
}

/**
 * 专为微信数据库提供
 * @param $url
 * @param $query
 * @return array
 */
function my_curl_post($url, $query){
    return curl_post($url, ['query' => $query]);
}
