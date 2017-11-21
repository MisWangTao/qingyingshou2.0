<?php
//移动添加回款接口   直接点击保存

require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$is_caiwu = $userinfo['is_caiwu'];

$company_id = $userinfo['company_id'];

$now_time = time();


$id = I('post.id','i',0);
// $id = 10;
if($id==0)EchoJsonData(1,'合同id不为空!');
$sql = "select contract_type from contract_list where id=$id and company_id=$company_id";

$res = Mysql::run_select($sql);

if($res[0]['contract_type']==3){
	$sql_contract = "SELECT payment_type,`currency_list` .id as currency_id,`currency_list` .ab,each_month,each_day,expiration_reminder,advance_remind
from `contract_list`
LEFT JOIN `currency_list` ON `contract_list` .`currency_id` =`currency_list` .id
WHERE `contract_list` .`id` = $id and company_id = $company_id and delete_time is null";
	$res_contracy = Mysql::run_select($sql_contract)[0];
	// print_r($res_contracy);
	if($res_contracy)
		EchoJsonData(0,'信息获取成功!',$res_contracy);
	else
		EchoJsonData(1,'参数错误!');
}else{
	EchoJsonData(1,'不是框架合同!');
}












?>