<?php
//获取客户负责人
require_once (__DIR__ . "/../common/common.php");

$userInfo = $GLOBALS['userinfo'];

$user_id = $userInfo['id'];

if ($user_id == '')
	EchoJsonData(1, 'userId不能为空!');

$company_id = $userInfo['company_id'];

$now_time = time();

$custom_id = I('post.custom_id','i',0);
// $custom_id = 1;
if($custom_id<=0) EchoJsonData(1, '客户不为空!');

$sql = "select user_id,(select realname from company_user where company_user.id=customer_leader.user_id and company_user.is_delete=0) as realname from customer_leader where custom_id=$custom_id and company_id=$company_id and delete_time is null";

$res = Mysql::run_select($sql);

$res = count($res)?$res:array();

// print_r($res);
if($res)
	EchoJsonData(0,'获取成功',$res);
else
	EchoJsonData(0,'没数据',$res);







?>