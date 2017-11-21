<?php

require_once(__DIR__ . "/../common/common.php");

// $userId = !empty($_POST['user_id'])?intval($_POST['user_id']):0;

// $userId = 6072;

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

if($userId==0)EchoJsonData(1,'userId不能为空!');

// $sql = "select * from company_user where id=$userId";

// $res = Mysql::run_select($sql);

// $companyId = $res[0]['company_id'];

$companyId = $userinfo['company_id'];

$sql = "select * from contract_label where company_id=$companyId and delete_time is null";

$res = Mysql::run_select($sql);

// print_r($res);

if($res)
	EchoJsonData(0,'获取合同标签成功!',$res);
else
	EchoJsonData(-1,'获取合同标签失败!');


?>