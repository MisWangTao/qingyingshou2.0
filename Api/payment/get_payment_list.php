<?php
//获取回款方式列表接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0) EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$now_time = time();

$sql = "select * from payment_method where company_id=$company_id and delete_time is null";

$res = Mysql::run_select($sql);

$res = count($res)>0?$res:array();
// print_r($res);

if($res)
  EchoJsonData(0,'收款方式列表获取成功!',$res);
else
  EchoJsonData(0,'无数据!');






?>