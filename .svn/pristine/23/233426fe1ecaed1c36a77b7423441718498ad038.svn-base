<?php
//获取预计回款详情接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];
//预回款id
//
$id = I('get.id','i',0);
// $id = 1;
// $id=1068;

if($id==0)EchoJsonData(2,'消息id不为空!');

$res = Mysql::run_select("select * from news where id=$id and company_id=$company_id and delete_time is null");

if(count($res)){
	$id=$res[0]['relation_id'];
}else{
	EchoJsonData(2,'参数错误!');
}

$sql = "SELECT (SELECT custom_name FROM `custom_list` WHERE `custom_list` .id=`forecastreceivables` .custom_id and `custom_list` .delete_time is null) AS custom_name,id,
arrival_date,arrival_amount,(SELECT realname FROM `company_user` WHERE `company_user` .id=`forecastreceivables` .operate_id AND is_delete=0) AS realname,custom_id
FROM `forecastreceivables` WHERE `id` = $id and company_id = $company_id and `delete_time` is null";

$res = Mysql::run_select($sql)[0];

$custom_id = $res['custom_id'];

$sql1 = "select contract_list.id,contract_list.contract_name,contract_list.contract_date,contract_list.contract_number,contract_money,forecastverification_contract.`returning_money`

	from contract_list

	left join forecastverification_contract on contract_list.id = forecastverification_contract.contract_id

	where contract_list.custom_id=$custom_id and contract_list.company_id=$company_id and contract_list.delete_time is null and

	forecastverification_contract.`willreceivable_id` =$id";

$res1 = Mysql::run_select($sql1);

$res['contract'] = $res1;

$res = count($res)>0?$res:array();
// var_dump($res);
if($res)
	EchoJsonData(0,'预回款信息获取成功!',$res);
else
	EchoJsonData(3,'预收款信息获取失败!');













?>