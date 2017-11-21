<?php
//业务人员回退回款单子接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

//$is_caiwu = $userinfo['is_caiwu'];

$company_id = $userinfo['company_id'];

$now_time = time();

// $_POST = array(
// 		'newid'=>20
// 	);
$is_caiwu = $userinfo['is_caiwu'];

if($is_caiwu!=0)EchoJsonData(1,'业务员做的!');

$id = I('post.newid','i',0);

if($id==0)EchoJsonData(1,'new 消息id不能为空!');

$sql = "update news set state=3,update_time=$now_time where id=$id and company_id=$company_id";

$res = Mysql::run_alter($sql);

if($res)
	EchoJsonData(0,'回退成功!');
else
	EchoJsonData(1,'失败!');








?>