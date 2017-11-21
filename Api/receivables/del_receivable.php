<?php
//删除回款单子接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0) EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$is_caiwu = $userinfo['is_caiwu'];

if($is_caiwu!=1)EchoJsonData(1,'不是财务!');

$nowtime = time();

// $_POST = array('id'=>1090);

$id = I('post.id','i',0);

if($id==0)EchoJsonData(1,'汇款单子id不为空!');

$operate_id = Mysql::run_select("select operate_id from receivables where id=$id and company_id=$company_id");

if($operate_id!=$user_id)EchoJsonData(1,'不是本人建的单子,不允许操作!');

$sql = "update receivables set delete_time=$nowtime where id=$id and company_id=$company_id";

$res = Mysql::run_alter($sql);

if($res)
	EchoJsonData(0,'删除成功!');
else
	EchoJsonData(1,'失败!');







?>