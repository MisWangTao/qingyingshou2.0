<?php
//财务删除核销纪录 并重新指派业务员
require_once(__DIR__ . "/../common/common.php");

$userinfo  = $GLOBALS['userinfo'];

$user_id    = $userinfo['id'];

$company_id = $userinfo['company_id'];

$customAdministrator = $userinfo['custom_administrators'];

if($user_id=='')EchoJsonData(1,'userId不能为空!');

$nowtime = time();

$is_caiwu = $userinfo['is_caiwu'];

if($is_caiwu!=1) EchoJsonData(2,'你不是财务!');

$id = I('post.id','i',0);//回款表的id
//$id = 1;
if($id<=0) EchoJsonData(3,'回款id不为空!');

//删除核销表的数据
$sql_del = "update verification_contract set delete_time=$nowtime where receivable_id=$id and company_id=$company_id";

$res = Mysql::run_alter($sql_del);

$sql_del_plan = "update verification_paymentplan set delete_time=$nowtime where receivable_id=$id and company_id=$company_id";

$res1 = Mysql::run_alter($sql_del_plan);

//如果存在回款计划
$sql_plan_id = "select return_plan_id,returning_money from verification_paymentplan where receivable_id=$id and company_id=$company_id";

$res_plan = Mysql::run_select($sql_plan_id);

if(count($res_plan)>0){
	foreach($res_plan as $k=>$v){
		if($v['return_plan_id']){
			$sql = "update contract_payment_plans set planed_money=planed_money-".$v['returning_money']." where delete_time is null id=".$v['return_plan_id'];
			$res = Mysql::run_alter($sql);
		}
	}
}
//修改contract_list 的contracted_money 的值
$sql_contract = "select returning_money,contract_id from verification_contract where receivable_id=$id and delete_time is null";

$res_contract = Mysql::run_select($sql_contract);
foreach($res_contract as $k=>$v){
	$sql = "update contract_list set contracted_money=contracted_money-".$v['returning_money']." where delete_time is null and id=".$v['contract_id'];
	$res = Mysql::run_alter($sql);
}

$sql = "update receivable set states=1,assign_id=null,assist_id=null,assist_time=null,contract_ids=null where id=$id and company_id=$company_id";

$res = Mysql::run_alter($sql);

if($res)
	EchoJsonData(0,'撤销成功');
else
	EchoJsonData(4,'删除失败');




?>