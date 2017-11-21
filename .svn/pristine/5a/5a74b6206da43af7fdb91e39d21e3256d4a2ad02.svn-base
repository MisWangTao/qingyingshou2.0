<?php

require_once(__DIR__ . "/../../common/config/debug.cof.php");
define("DEBUG",H5_DEBUG);

if(!$_SERVER['HTTP_HOST'] && DEBUG){
	require_once(__DIR__ . "/../debug/Mysql.test.php");
}else{
	require_once(__DIR__ . "/../../common/classes/Mysql.class.php");
}

require_once(__DIR__ . "/../../common/function/com.fun.php");
require_once(__DIR__ . "/../../common/function/third.fun.php");




header("Content-type:text/html; charset=UTF-8");
if(DEBUG){
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Authorization");
}

if(!in_array(getCurrentFileName(), array('auth','isvConfig'))){
	$r = validateToken();
	if($r==false){
		if(DEBUG){
			$sql  = "SELECT * FROM company_user WHERE id=1 ";
		    $res  = Mysql::run_select($sql);
		    $GLOBALS['userinfo'] = $res[0];
		}else{
			EchoJsonData(-1,'请登录后重试!');
		}
	}
}else{
	if(DEBUG && getCurrentFileName()==''){
		$sql  = "SELECT * FROM company_user WHERE id=1 ";
	    $res  = Mysql::run_select($sql);
	    $GLOBALS['userinfo'] = $res[0];
	}
}


