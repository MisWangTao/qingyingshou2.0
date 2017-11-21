<?php
//财务确认正常
require_once(__DIR__ . "/../common/common.php");

$userinfo  = $GLOBALS['userinfo'];

$user_id    = $userinfo['id'];

$company_id = $userinfo['company_id'];

$customAdministrator = $userinfo['custom_administrators'];

if($user_id=='')EchoJsonData(1,'userId不能为空!');

$nowtime = time();

$is_caiwu = $userinfo['is_caiwu'];

if($is_caiwu!=1) EchoJsonData(2,'你不是财务!');

$id = I('post.id','i',0);
// $id = 13;
if($id<=0) EchoJsonData(3,'回款的id不为空!');

$sql = "update receivables set states=2 where id=$id and company_id=$company_id";

$res = Mysql::run_alter($sql);

if($res)
	EchoJsonData(0,'恢复成功');
else
	EchoJsonData(4,'删除失败');





?>