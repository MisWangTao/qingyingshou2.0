<?php
//产品信息删除
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$now_time = time();
// print_r($userinfo);exit;
// $sql = "select * from company_user where id=$userId";

// $res = Mysql::run_select($sql);

// $companyId = $res[0]['company_id'];

$company_id = $userinfo['company_id'];

$id = I('post.id','i',0);

if($id<=0) EchoJsonData(1,'产品id不为零!');

$sql = "update product_info set delete_time=$now_time where id=$id and company_id=$company_id";

$res = Mysql::run_alter($sql);

if($res)
	EchoJsonData(0,'产品信息删除成功!');
else
	EchoJsonData(1,'失败!');











?>