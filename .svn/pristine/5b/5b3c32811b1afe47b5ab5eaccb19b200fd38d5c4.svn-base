<?php
//获取客户信息列表   新建回款的选择客户列表
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$sql = "select * from currency_list where import=1";

$res = Mysql::run_select($sql);

// print_r($res);

if($res)
  EchoJsonData(0,'币种列表获取成功!',$res);
else
  EchoJsonData(0,'无数据!');


?>