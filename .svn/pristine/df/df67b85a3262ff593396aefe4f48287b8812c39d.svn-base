<?php
//删除客户信息接口
require_once(__DIR__ . "/../common/common.php");

$userinfo  = $GLOBALS['userinfo'];

$userId    = $userinfo['id'];

$companyId = $userinfo['company_id'];

$customAdministrator = $userinfo['custom_administrators'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

if(!$customAdministrator)EchoJsonData(2,'非客户管理员不能删除客户!');

$customIdArr = !empty($_POST['custom_id'])?json_decode($_POST['custom_id'],true):array();
if(count($customIdArr)<=0) EchoJsonData(2,'要删除的不为空!');

$nowtime = time();

//echo $userId;
//var_dump($_POST);
//var_dump($customIdArr);exit;
$is_caiwu = $userinfo['is_caiwu'];

$str = implode($customIdArr, ',');

$sql_contract = "select * from contract_list where custom_id in(".$str.") and delete_time is null";

$res_contract = Mysql::run_select($sql_contract);

if(count($res_contract)>0) EchoJsonData(3,'有存在合同的客户,不能删除!');



$sql = " UPDATE custom_list set delete_time = $nowtime,delete_userid=$userId WHERE id in (".$str.") AND company_id=$companyId ";
$res = Mysql::run_alter($sql);

//exit;
$where = '';
if($is_caiwu!=1){
	$where = " and customer_leader.user_id=$userId";
}else{
	$where = '';
}

$sql1 = "select custom_list.id,custom_name,
custom_nature,custom_industry.`industry_name`,logo,from_unixtime(custom_list.add_time,'%Y-%m-%d') as add_time
from custom_list
left join custom_industry on custom_list.`industry_id` =`custom_industry`.id
left join customer_leader on customer_leader.custom_id = custom_list.id
where custom_list.company_id=$companyId and customer_leader.company_id=$companyId and custom_list.delete_time is null and customer_leader.delete_time is null".$where." group by custom_list.id order by custom_list.update_time desc";

$res1 = Mysql::run_select($sql1);

$res1 = count($res1)?$res1:array();



if($res)
	EchoJsonData(0,'删除成功',$res1);
else
	EchoJsonData(4,'删除失败');
?>