<?php
//修改显示消息状态的接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$id = I('post.id','i',0);

$edit_sql = "update news set state=1 where id=$id and company_id=$company_id";

// echo $edit_sql;
$res = Mysql::run_select($edit_sql);

if($res)
	EchoJsonData(0,'已查看!');
else
	EchoJsonData(1,'查看失败!');















?>