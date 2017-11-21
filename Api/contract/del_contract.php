<?php
//删除合同
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$now_time = time();

$company_id = $userinfo['company_id'];

$is_caiwu = $userinfo['is_caiwu'];

$contract_arr = !empty($_POST['contract_id'])?json_decode($_POST['contract_id'],true):array();

if(count($contract_arr)<=0) EchoJsonData(1,'要删除的选项不为空!');

$str_contract_ids = implode($contract_arr, ',');

$sql = "select sum(contracted_money) as total from contract_list where id in (".$str_contract_ids.") and company_id=$company_id and delete_time is null";

$total = Mysql::run_select($sql)[0]['total'];

if($total>0) EchoJsonData(3,'存在已回款合同,不能删除!!');

$sql_del = "update contract_list set delete_time=$now_time,delete_userid=$user_id where id in (".$str_contract_ids.") and company_id=$company_id";
// echo $sql_del;exit;
$res = Mysql::run_alter($sql_del);

if($res)
	EchoJsonData(0,'删除成功');
else
	EchoJsonData(4,'删除失败');











?>