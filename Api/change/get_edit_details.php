<?php
//PC变更编辑获取数据接口
require_once(__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");
$userInfo = $GLOBALS['userinfo'];

$userId  = $userInfo['id'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

$companyId = $userInfo['company_id'];

$nowtime = time();

$new_id = I('post.news_id','i',0);

$sql = "select * from news where id=$new_id and company_id=$companyId";

$message = Mysql::run_select($sql)[0]['message'];

$changeId = I('post.change_id','i','',true);

if($changeId=='')EchoJsonData(2,'变更单Id不能为空!');

//查询变更信息
$searchChangeInfoSql = "select id,contract_id,change_type,change_reason,change_money,change_date,refund_money,remark,send_userid,each_money,maturity_date,change_status,
(select realname from company_user where contract_change.send_userid=company_user.id) as send_realname
 from contract_change where id=".$changeId;
$ChangeInfo = Mysql::run_select($searchChangeInfoSql);
$contractId = $ChangeInfo[0]['contract_id'];
//查询合同信息
$searchContractInfoSql = "select id,contract_name,(select custom_name from custom_list where contract_list.custom_id=custom_list.id) as custom_name,contract_number,contract_date,contract_money,contract_type,first_date_payment,payment_cycle,
(select sum(returning_money) from verification_contract where contract_list.id=verification_contract.`contract_id` and contract_list.`custom_id` =`verification_contract`.`custom_id` ) as huikuan_money,
(select realname from company_user where contract_list.followup_id=company_user.id) as genjinren
from contract_list where id=$contractId"; 
$ContractInfo = Mysql::run_select($searchContractInfoSql);

//产品信息


//回款计划
$searchReturnPlanSql = "select id,payment_plan_id,payment_plan_money,paymented_plan_money,payment_plan_date,payment_plan_remark,change_plan_money,changed_plan_money,change_plan_type,change_plan_date,change_plan_remark from contract_payment_plan_change where contract_id=$contractId and contract_change_id=$changeId and type!=3";
$ReturnPlan = Mysql::run_select($searchReturnPlanSql);
$ReturnPlan = $ReturnPlan?$ReturnPlan:array();
//查看附件
// $serachFilesSql = "select old_name as name,src,ext,mime,filesize as size where relation_id=$.. ";

// $Files = Mysql::run_select($serachFilesSql);
$Files = $Files?$Files:array();
$data = array();

$data['contract_info'] = $ContractInfo[0];
$data['change_info'] = $ChangeInfo[0];
$data['returnPlan'] = $ReturnPlan;
$data['files'] = $Files;
$data['message'] = $message;
EchoJsonData(0,'信息获取成功!',$data);

?>