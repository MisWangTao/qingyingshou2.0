<?php
//获取全部联系人列表
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

if($company_id==0)EchoJsonData(2,'companyId不能为空!');

$is_caiwu = $userinfo['is_caiwu'];

$custom_administrators = $userinfo['custom_administrators'];

$where = '';

if($custom_administrators!=1){
	$where = " and user_id=$user_id";
}

$sql = "select * from linkman where company_id=$company_id and delete_time is null".$where;

$res = Mysql::run_select($sql);

if($res)
	EchoJsonData(0,'联系人列表获取成功!',$res);
else
	EchoJsonData(0,'没数据!',$res);







?>