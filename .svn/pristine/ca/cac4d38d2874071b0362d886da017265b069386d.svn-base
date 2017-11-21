<?php
//手机获取客户列表
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

if($userId==0)EchoJsonData(1,'userId不能为空!');

$companyId = $userinfo['company_id'];

if($companyId==0)EchoJsonData(2,'companyId不能为空!');

$is_caiwu = $userinfo['is_caiwu'];

$custom_administrators = $userinfo['custom_administrators'];

$where = '';
if($is_caiwu!=1||$custom_administrators!=1){
	$where = " and customer_leader.user_id=$userId";
}else{
	$where = '';
}

$sql = "select custom_list.id,custom_name,custom_number,
custom_nature,custom_industry.`industry_name`,
ifnull((select sum(contract_money) from contract_list where contract_list.custom_id = custom_list.id),0) as sum_contract_money,
ifnull((select sum(returning_money) from verification_contract where verification_contract.custom_id=custom_list.id),0) as sum_verification_money,
logo,from_unixtime(custom_list.add_time,'%Y-%m-%d') as add_time
from custom_list
left join custom_industry on custom_list.`industry_id` =`custom_industry`.id
left join customer_leader on customer_leader.custom_id = custom_list.id
where custom_list.company_id=$companyId and customer_leader.company_id=$companyId and custom_list.delete_time is null and customer_leader.delete_time is null".$where." group by custom_list.id order by custom_list.update_time desc";

$res = Mysql::run_select($sql);

$res = count($res)?$res:array();

// print_r($res);

if($res)
	EchoJsonData(0,'客户列表获取成功!',$res);
else
	EchoJsonData(0,'没数据!',$res);
?>