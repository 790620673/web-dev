<?php

$arr = array(
	'id' => 1,
	'name' => 'koffuxu'
);

/*
 * Test Module
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

class Response {
	/**
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
}
