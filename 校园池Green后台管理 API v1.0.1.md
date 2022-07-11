**目录**

[TOC]

校园池Green后台管理 API v1.0.1  
===

---
```
      作者:何志伟             
      e-mail:1498408920@qq.com
      发布日期: 2019-8-01
      更新日期: 2020-1-25 改动: doc_id 改成 _id

      ${domain}: https://www.breath57.cn
```
---
# 查询操作 #

## 单记录查询 ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/get/sig 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
collection_name|string||是|操作的集合名称
_id|string||是|需要请求的记录_id
token|string||是|接口调用凭证

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
data|Array|记录组成的JS对象数组

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0    |请求成功
47001|POST BODY 格式错误
403|缺少有效的token
500|服务器内部错误
HTML|请求地址错误
msg|错误信息

---


## 多记录查询 ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/get/bat 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
collection_name|string||是|操作的集合名称
where|string|{ }||查询条件
order_key|string|addtime||排序关键字
order_type|string|desc||默认降序,升序为asc
skip|number|0||符合条件记录的偏移量
limit|number|80||每次取得记录得最大数量
token|string||是|接口调用凭证

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
msg|string|错误信息
HTML|HTML页面|请求地址错误
data|Array|记录组成的JS对象数组

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0    |请求成功
47001|POST BODY 格式错误
403|缺少有效的token
500|服务器内部错误



---


## 记录分页查询 ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/get/pagin 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
collection_name|string||是|操作的集合名称
p_number|number||是|页号
p_size|number||是|每页的记录数
where|string|{ }||查询条件
order_key|string|addtime||排序关键字
order_type|string|desc||默认降序,升序为asc
token|string||是|接口调用凭证

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
msg|string|错误信息
HTML|HTML页面|请求地址错误
data|Array|记录组成的JS对象数组

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0    |请求成功
47001|POST BODY 格式错误
403|缺少有效的token
500|服务器内部错误

---

## 获得集合记录数 ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/get/count 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
collection_name|string||是|操作的集合名称
where|string|{}||查询条件格式: {key: value}
token|string||是|接口调用凭证

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
msg|string|错误信息
HTML|HTML页面|请求地址错误
count|number|请求查询集合的记录数


**error_code的合法值**

  值   |   说明            
-------- |-------------
  0    |请求成功
47001|POST BODY 格式错误
403|缺少有效的token
500|服务器内部错误

---

# 获取TOKEN令牌 #

## 请求token ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/get/token 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
uid|string||是|用户名
pw|string||是|用户的密码

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
HTML|HTML页面|请求地址错误
msg|string|错误信息
token|string|令牌

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0    |请求成功
47001|POST BODY 格式错误
403|缺少有效的token
500|服务器内部错误

---

# 删除操作 #

## 单记录删除 ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/del/sig 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
collection_name|string||是|需要操作的集合名
_id|string||是|记录_id

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
HTML|HTML页面|请求地址错误
msg|string|错误信息
deleted|number|删除记录数量

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0    |请求成功
47001|POST BODY 格式错误
403|缺少有效的token
500|服务器内部错误

---

## 多记录删除 ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/del/bat 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
collection_name|string||是|需要操作的集合名
where|string||是|查询条件:格式{key:value}
token|string||是|接口调用凭证

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
HTML|HTML页面|请求地址错误
msg|string|错误信息
deleted|number|删除记录数量

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0    |请求成功
47001|POST BODY 格式错误
403|缺少有效的token
500|服务器内部错误

---

# 更新操作 #

## 单记录更新 ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/upt/sig 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
collection_name|string||是|需要操作的集合名
_id|string||是|记录_id
upt_content|string||是|修改的字段值格式:{key:value,key2:value2}
token|string||是|接口调用凭证

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
HTML|HTML页面|请求地址错误
msg|string|错误信息
matched|number|更新条件匹配到的结果数
modify|number|修改的记录数

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0    |请求成功
47001|POST BODY 格式错误
403|缺少有效的token
500|服务器内部错误

---

## 多记录更新 ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/upt/bat 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
collection_name|string||是|需要操作的集合名
where|string||是|查询条件:格式{key:value}
upt_content|string||是|修改的字段值格式:{key:value,key2:value2}
token|string||是|接口调用凭证

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
HTML|HTML页面|请求地址错误
msg|string|错误信息
matched|number|更新条件匹配到的结果数
modify|number|修改的记录数

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0    |请求成功
47001|POST BODY 格式错误
403|缺少有效的token
500|服务器内部错误

---

# 添加操作 #

## 增加一条记录或多条记录 ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/add 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
collection_name|string||是|需要操作的集合名
records|string||是|格式:[{key:value,key2:value}, {...}, ...]
token|string||是|接口调用凭证

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
HTML|HTML页面|请求地址错误
msg|string|错误信息
id_list|Array.< string >|插入成功的数据集合主键_id

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0    |请求成功
47001|POST BODY 格式错误
403|缺少有效的token
500|服务器内部错误

---

# 文件操作 #

## 获取文件上传链接 ##

 **请求地址**
```http
  POST ${domain}/api/v1/com/get/upurl 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
path|string||是|上传路径
token|string||是|接口调用凭证

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
HTML|HTML页面|请求地址错误
msg|string|错误信息
url|string|上传url
token|string|token
authorization|string|authorization
file_id|string|文件的ID,用于下载文件,和使用文件
cos_file_id|string|cos文件ID

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0    |请求成功
47001|POST BODY 格式错误
403|缺少有效的token
500|服务器内部错误

**上传链接使用说明**

用户获取到返回数据后, 需拼装一个HTTP POST请求，其中url 为返回包中的url字段, Body部分格式为 mutipart/form-data, 具体内容如下

key|value|说明
---|---|---|
key|this/is/a/example/file.path|请求包中的path字段
Signature||返回数据中authorization字段
x-cos-security-token||返回数据中的token字段
x-cos-meta-fileid||文件的二进制内容

---

## 获取文件的下载链接 ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/get/dwurl 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
file_id|string||是|file_id
token|string||是|接口调用凭证

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
HTML|HTML页面|请求地址错误
msg|string|错误信息
fileid|string|文件id
download_url|string|下载链接
status|number|状态码:0(成功)

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0  |请求成功
47001|POST BODY 格式错误
403  |缺少有效的token
500  |服务器内部错误

---

## 多文件删除 ##
 **请求地址**
```http
  POST ${domain}/api/v1/com/del/file 
```
**请求参数**

  属性   |   类型      |      默认值     |      必填    |     说明
-------- |-------------|----------------|-------------|-----------
fileid_list|string||是|格式:`["file_id","file_id2",...]`
token|string||是|接口调用凭证

#### **返回值** ####

**Object**
返回的JSON数据包

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
HTML|HTML页面|请求地址错误
msg|string|错误信息
delete_list|Array.< json对象 >|文件列表

**delete_list 的结构**

  属性   |   类型      |       说明
-------- |-------------|-----------
error_code|number|错误码
msg|string|错误信息
fileid|string|文件id
status|number|状态码:0(成功)

**error_code的合法值**

  值   |   说明            
-------- |-------------
  0  |请求成功
47001|POST BODY 格式错误
403  |缺少有效的token
500  |服务器内部错误

---

# *End*