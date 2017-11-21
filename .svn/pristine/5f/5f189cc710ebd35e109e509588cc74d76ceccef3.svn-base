<?php
//添加回款方式
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0) EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];
// print_r($userinfo);

$now_time = time();

$payment_method = I('post.payment','s','',true);
if ($payment_method=='') EchoJsonData(1,'回款方式不为空!');
$value = I('post.values','s','',true);
// if($value=='')$value = '123';
$sql = "insert into payment_method (company_id,payment_method,`values`,add_time,add_userid,update_time,update_userid)
		values($company_id,'".$payment_method."','".$value."',$now_time,$user_id,$now_time,$user_id)";

$payment_id = Mysql::run_insert($sql);
if($payment_id)
		EchoJsonData(0,'回款方式添加成功!');
	else
	  EchoJsonData(-1,'回款方式添加失败!');
?>