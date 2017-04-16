<?php

//require_once('./response.php');
require_once('./file.php');

$arr = array(
	'id' => 1,
	'name' => 'koffuxu'
);

//1使用json方式
//Response::json(200, '数据返回成功succussul', $arr);

//3使用xmlEncode方式
//Response::xml_encode(200, '数据返回成功succussul', $arr);

//
$file = new File();
//写缓存
//if($file->cacheData('index_kf_cache',$arr)){
//删除缓存
if($file->cacheData('index_kf_cache',null)){
//读缓存
//if($file->cacheData('index_kf_cache')){
//	var_dump($file->cacheData('index_kf_cache'));
	echo "success";
}else{
	echo "fail";	
}