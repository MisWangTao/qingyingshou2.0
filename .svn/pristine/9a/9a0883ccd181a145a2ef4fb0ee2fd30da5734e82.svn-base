<?php
//删除联系人
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

if($company_id==0)EchoJsonData(2,'companyId不能为空!');

$is_caiwu = $userinfo['is_caiwu'];

$now_time = time();

$custom_administrators = $userinfo['custom_administrators'];

$id = I('post.id','i',0);
// $id = 3;
if($id<=0)EchoJsonData(2,'联系人id不为空!');

if ($custom_administrators!=1) {
	$sql1 = "select * from linkman where id=$id and company_id=$company_id and delete_time is null";
	$res_user = Mysql::run_select($sql1)[0]['user_id'];
	if($res_user!=$user_id) EchoJsonData(4,'联系人不是自己建的!');
}


$sql = "update linkman set delete_time=$now_time where id=$id and company_id=$company_id";

$res = Mysql::run_alter($sql);

if($res)
	EchoJsonData(0,'删除成功!');
else
	EchoJsonData(1,'参数错误!');

?>