<?php
//获取客户的合同列表   更具客户获取客户的合同列表
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0) EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$is_caiwu = $userinfo['is_caiwu'];

$where = '';

if($is_caiwu!=1){
		$where = " and followup_id=$user_id";
}

$custom_id = I('get.custom_id','i',0);
// $custom_id = 2;
if($custom_id==0)EchoJsonData(1,'custom_id不为空!');

$sql_custom_contract_list = "select id,contract_name,contract_number,contract_date,contract_money,(contract_money-ifnull(`contracted_money`, 0)) as yuer
FROM `contract_list` where `custom_id` = $custom_id and `delete_time` IS NULL and company_id=$company_id and contract_money>contracted_money ".$where." order by contract_list.update_time desc";


$res = Mysql::run_select($sql_custom_contract_list);

// print_r($res);

if($res)
  EchoJsonData(0,'客户合同列表获取成功!',$res);
else
  EchoJsonData(0,'无数据!');











?>