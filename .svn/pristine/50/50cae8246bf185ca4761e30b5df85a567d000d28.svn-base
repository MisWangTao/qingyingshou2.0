<?php

require_once(__DIR__ . "/../common/common.php");

// $userId = !empty($_POST['user_id'])?intval($_POST['user_id']):0;

// $userId = 6072;

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];



if($userId==0)echo EchoJsonData(1,'userId不能为空!');

$res = Mysql::run_select("select * from custom_industry");

// print_r($res);exit;

if($res>0)
	echo EchoJsonData(0,'所属行业获取成功!',$res);
else
	echo EchoJsonData(2,'所属行业获取失败!');

?>