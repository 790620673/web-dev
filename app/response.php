<?php 


/*
 * Test Module:Json只能转换utf-8编码的数据
 */
 /*
$data = "输出json数据";
//from utf-8 to gbk
$data_gbk = iconv('UTF-8', 'GBK', $data);
echo json_encode($arr);
echo '<br>';
echo json_encode($data);
echo '<br>';
echo $data_gbk;
echo '<br>';
//json只能转换utf-8编码的数据
echo json_encode($data_gbk);*/

/***************************
*		setction 1 base
*			1,json
*			2,xml
****************************/

class Response {
	/**
	*1
	*按json方法输出通信数据
	*@param integer $code 状态码
	*@param string $message 提示信息
	*@param array $data 数据
	*/
	public static function json($code, $message, $data){
		if(!is_numeric($code)){
			return '';
		}
		$result = array(
			'code' => $code,
			'message' => $message,
			'data' => $data
		);
		echo json_encode($result);
	}
	/**
	*2
	*按xml静态方法输出通信数据
	*/
	public static function xml_stat(){
		//转换头部信息
		header("Content-Type:text/xml");
		$xml="<?xml version='1.0' encoding='UTF-8'?>\n";
		$xml.="<root>\n";
		$xml.="<code>200</code>\n";
		$xml.="<message>数据返回成功From XML static method</message>\n";
		$xml.="<data>\n";
		$xml.="<id>1</id>\n";
		$xml.="<name>koffuxu</name>\n";
		$xml.="</data>\n";
		$xml.="</root>";
		echo $xml;
	}
	
	/**
	*3
	*按xmlEncode方法输出通信数据
	*@param integer $code 状态码
	*@param string $message 提示信息
	*@param array $data 数据
	*/
	public static function xml_encode($code, $message, $data) {
		if(!is_numeric($code)){
			return '';	
		}
		$result = array(
			'code' => $code,
			'message' => $message,
			'data' => $data
		);
		header("Content-Type:text/xml");
		$xml="<?xml version='1.0' encoding='UTF-8'?>\n";
		$xml.="<root>\n";
		$xml.=self::xmlToEncode($result);
		$xml.="</root>\n";
		echo $xml;
	}
	public static function xmlToEncode($data){
		$xml=$attr="";
		foreach($data as $key => $value){
			if(is_numeric($key)){
				$attr="id='{$key}'";
				$key = "item";
			}
			$xml.="<{$key} {$attr}>\n";
			$xml.=is_array($value)?self::xmlToEncode($value):$value;
			$xml.="</{$key}>\n";
		}
		return $xml;
	}
	
	/*
	*4,综合Json和XML的方式
	*@param integer $code 状态码
	*@param string $message 提示信息
	*@param array $data 数据
	*@param string $type 数据
	*/
	const JSON = "json";
	public static function show($code, $message, $data, $type=self::JSON){
		if(!is_numeric($code)){
			return '';	
		}
		//localhost.com/response.php?format=php
		$type = isset($_GET['format'])?$_GET['format']:self::JSON;
		$result = array(
			'code' => $code,
			'message' => $message,
			'data' => $data
		);
		if($type == 'json'){
			self::json($code, $message, $data);
			exit;
		}else if($type =='array'){
			var_dump($result);
		}else if($type == 'xml'){
			self::xml_encode($code, $message, $data);
			exit;
		}else{
			//TODO other type logic;	
		}
	}
}
$arr = array(
	'id' => 1,
	'name' => 'koffuxu',
	'type' => array(4, 5, 6)
);
//1,使用json方式
//Response::json(200, '数据返回成功succussul', $arr);

//2,使用静态方法调用xml
//Response::xml_stat();

//3,使用xmlEncode方式
//Response::xml_encode(200, '数据返回成功succussul', $arr);

//4,使用type参数的方式
Response::show(200, '数据返回成功succussul', $arr);

/***************************
*		setction 2 core tech
*			1,缓存技术
*				1.1,读，写，删除缓存file.php
*				1.2,redis与memcache技术
*			2,定时任务
*			
****************************/

/*
* php操作readis
* 1,安装phpreids扩展
* 2,php连接redis服务 connect(127.0.0.1,6379);
* 3,set/get 缓存
* redis = new Redis();
* redis->connect('127.0.0.1',6379);
* redis->set('kfredis', 'aaaaaaa');
* redis->get('kfredis'');
* redis->setex('kfredis2', 15, 'aaaaaaa');
*/