<?php
//获取产品列表
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

$sql = "select * from product_info where company_id=$company_id and delete_time is null";

$res = Mysql::run_select($sql);

$res = count($res)?$res:array();
// print_r($res);
if($res)
	EchoJsonData(0,'产品信息获取成功!',$res);
else
	EchoJsonData(0,'没数据!',$res);

?>