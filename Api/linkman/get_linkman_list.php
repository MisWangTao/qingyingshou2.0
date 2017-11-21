<?php
//获取对应客户的联系人列表
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

if($company_id==0)EchoJsonData(2,'companyId不能为空!');

$is_caiwu = $userinfo['is_caiwu'];

$custom_administrators = $userinfo['custom_administrators'];
// print_r($userinfo);exit;
$where = '';
if($custom_administrators != 1){
	$where = " and user_id=$user_id";
}

$now_time = time();
$_POST = array('custom_id'=>2);

$custom_id = I('post.custom_id','i',0);
if($custom_id<=0) EchoJsonData(3,'客户id不为空!');

$sql = "select * from linkman where custom_id=$custom_id and company_id=$company_id".$where;

$res = Mysql::run_select($sql);

// print_r($res);

if($res)
	EchoJsonData(0,'客户联系人获取成功!',$res);
else
	EchoJsonData(0,'没数据!',$res);


?>