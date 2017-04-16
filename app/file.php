<?php
/***************************
*		setction 2 core tech
*			1,缓存技术
				1.1,生成缓存 file_get_content 
				1.2,获取缓存 file_put_content
				1.3,删除
*			2,定时任务
*			file.php
****************************/

class File{
	const EXT = '.txt';
	private $_dir;
	public function __construct(){
		$this->_dir = dirname(__FILE__).'/files/';
	}
	public function cacheData($key,$value='',$path=''){
		$filename = $this->_dir.$path.$key.self::EXT;
		/****删除缓存****/
		if(is_null($value)){
			return @unlink($filename);
		}
		/****写缓存****/
		if($value !== ''){
			//将value值写入缓存
			$dir = dirname($filename);
			if(!is_dir($dir)){
				mkdir($dir,0755);
			}
			//返回写入字节数
			return file_put_contents($filename, json_encode($value));
		
		}
		/****读缓存****/
		if(!is_file($filename)){
			return FALSE;
		}else{
			return json_decode(file_get_contents($filename));
		}

		
	}
}