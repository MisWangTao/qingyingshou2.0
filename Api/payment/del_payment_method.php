<?php
//删除回款方式
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

$company_id = $userinfo['company_id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$now_time = time();

$id = I('post.id','i',0);  //获取收款方式要删除数据的id
if($id==0)EchoJsonData(1,'回款id不为空!');
$del_sql = "update payment_method set delete_time=$now_time,delete_userid=$user_id where id=$id and company_id=$company_id";

$res = Mysql::run_alter($del_sql);

if($res)
		EchoJsonData(0,'回款方式删除成功!');
	else
	  EchoJsonData(-1,'回款方式删除失败!');



?>