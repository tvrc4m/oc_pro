<?php

function C($key,$value=''){
	if(is_null($value)) setcookie($key,'',time()-3600,'/',COOKIE_DOMAIN);
	elseif(empty($value)) return $_COOKIE[$key];
	else setcookie($key,$value,time()+COOKIE_TIMEOUT,'/',COOKIE_DOMAIN);
}

/**
*	存储或提取会话数据----当value为空时，为提取数据。不为空，则进行保存。
*	@param key string 键
*	@param value 字符串或数字等简单类型
*/
function S($key,$value=''){
	if(is_null($value)) unset($_SESSION[$key]);
	elseif(empty($value)) return $_SESSION[$key];
	else $_SESSION[$key]=$value;
}
/**
*	调用插件	
**/
function P($class,$data=array()){
	$classname=ucfirst($class).'Plugin';
	$file=PLUGIN.$class.'.plugin.php';
	!is_file($file) && exit('文件不存在.请检查路径');
	include_once($file);
	$instance=new $classname;
	return $instance->run($data);
}

function M($path,$action,$data=array()){

	static $medium_instances=array();

	list($dir,$name)=explode("/",$path);

	$name=strtolower($name);

	$instance=null;

	if(isset($medium_instances[$name])){

		$instance= $medium_instances[$name];
	}else{

		include_once MEDIUM.strtolower($path).'.php';

		$cls=ucfirst($name);

		$instance=new $cls();

		$medium_instances[$name]=$instance;
	}

	return $instance->run($action,$data);
}

function D($path){

	static $model_instances=array();

	list($dir,$name)=explode("/",$path);

	$name=strtolower($name);

	if(isset($model_instances[$name])) return $model_instances[$name];

	include_once MODEL.strtolower($path).'.model.php';

	$cls=ucfirst($name).'Mysql';

	$instance=new $cls();

	return $model_instances[$name]=$instance;
}


function isLogged(){
	return !!getLoggedID();
}

function getLoggedID(){
	return defined('IS_ADMIN')?S('AID'):S('UID');
}