<?php 
//编辑回款计划的接口
require_once(__DIR__."/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

$companyId = $userinfo['company_id'];

$contractId = I('post.contract_id','i','',true);
$contractId = 21;
if($contractId=='')EchoJsonData(1,'合同单id不能为空!');

$planId = I('post.plan_id','i','',true);
$planId = 68;
$planDate = I('post.plan_date','s','',true);
$planDate = '2017-08-19';
if($planDate=='')EchoJsonData(2,'回款计划时间不能为空!');

$planMoney = I('post.plan_money','f','',true);
$planMoney = '6000';
if($planMoney=='')EchoJsonData(3,'回款计划金额不能为空!');

$planType = I('post.plan_type','i','',true);
$planType = 1;
$planRemark = I('post.plan_remark','s','',true);
$planRemark = '4';

//查询的回款计划列表
$sql = "select id,plan_date,plan_money,plan_type,plan_remark,planed_money from contract_payment_plans where company_id=$companyId and contract_id=$contractId and delete_time is null order by plan_date asc";

$returnPlanList = Mysql::run_select($sql);

//查询回款计划
$sql = "select id,plan_date,plan_money,plan_type,plan_remark,planed_money from contract_payment_plans where company_id=$companyId and id=$planId";
$returnPlan = Mysql::run_select($sql)[0];

// //查询总到账
// $sql = "select sum(returning_money) as hexiao from verification_paymentplan where company_id=$companyId and contract_id=$contractId and delete_time is null";
// $sumVerifiMoney = Mysql::run_select($sql)[0]['hexiao'];

$NewReturnPlan = array();

$NewReturnPlan['id'] = $planId;
$NewReturnPlan['plan_date'] = $planDate;
$NewReturnPlan['plan_money'] = $planMoney;
$NewReturnPlan['plan_type'] = $planType;
$NewReturnPlan['plan_remark'] = $planRemark;

$OldReturnPlan['id'] = $returnPlan['id'];
$OldReturnPlan['plan_date'] = $returnPlan['plan_date'];
$OldReturnPlan['plan_money'] = $returnPlan['plan_money'];
$OldReturnPlan['plan_type'] = $returnPlan['plan_type'];
$OldReturnPlan['plan_remark'] = $returnPlan['plan_remark'];

$result = array_diff_assoc($NewReturnPlan,$OldReturnPlan);

$nowtime = time();

// //查询核销记录
// $sql = "select returning_money,returning_time from verification_contract where company_id=$companyId and contract_id=$contractId and delete_time is null order by returning_time asc";

// $verificationInfo = Mysql::run_select($sql);

var_dump($NewReturnPlan);

$result = array_diff_assoc($NewReturnPlan,$OldReturnPlan);
var_dump($result);
// returnNewPlanVerificationStatus($contractId,$verificationInfo,$NewReturnPlan);
//
// exit;
//对比回款计划
// foreach($result as $k=>$v)
// {	
// 	$leixing_str = "";
	
// 	switch ($v['plan_type']) {

// 		case 1:
// 			$leixing_str = '常规';
// 			break;
// 		case 2:
// 			$leixing_str = '预收款';
// 			break;
// 		case 3:
// 			$leixing_str = '质保金';
// 			break;
// 		case 4:
// 			$leixing_str = '尾款';
// 			break;
// 	}   
// 		$where = "";
// 		$str = "";
// 		$sql = "select * from contract_payment_plans where delete_time is null and contract_id=$contractId and company_id=$companyId and id=".$v['id'];
// 		$res = Mysql::run_select($sql)[0];

// 		switch ($res['plan_type']) {

// 		case 1:
// 			$leixing = '常规';
// 			break;
// 		case 2:
// 			$leixing = '预收款';
// 			break;
// 		case 3:
// 			$leixing = '质保金';
// 			break;
// 		case 4:
// 			$leixing = '尾款';
// 			break;
// 		}

// 		$str = "将时间为:".$res['plan_date'].",金额为:".number_format($res['plan_money'],2).",备注为:".$res['plan_remark'].",类型为:".$leixing."的回款计划 修改为:";

// 		if($v['plan_date']!='')
// 		{
// 			$where.="plan_date='".$v['plan_date']."',";
// 			$str.= "时间为:".$v['plan_date'].",";
// 		}else{
// 			$str.= "时间为:".$res['plan_date'].",";
// 		}	
// 		if($v['plan_money']!='')
// 		{
// 			$where.="plan_money='".$v['plan_money']."',";
// 			$str.="金额为:".number_format($v['plan_money'],2).",";
// 		}else{
// 			$str.= "时间为:".number_format($res['plan_money'],2).",";
// 		}
// 		if($v['plan_remark']!='')
// 		{
// 			$where.="plan_remark='".$v['plan_remark']."',";
// 			$str.="备注为:".$v['plan_remark'].",";
// 		}else{
// 			$str.= "备注为:".$res['plan_remark'].",";
// 		}	
// 		if($v['plan_type']!='')
// 		{
// 			$where.="plan_type='".$v['plan_type']."',";
// 			$str.="类型为".$leixing_str."的回款计划";
// 		}else{
// 			$str.= "类型为:".$leixing."的回款计划";
// 		}
		

// 		$sql1 = "update contract_payment_plans set $where update_time=$nowtime where delete_time is null and contract_id=$contractId and company_id=$companyId and id=".$v['id'];

// 		$res1 = Mysql::run_alter($sql1);

// 		$editObj[] = $str;

// 	$desc = addslashes(json_encode($editObj,JSON_UNESCAPED_SLASHES));
// 	// var_dump($desc);
// 	if($res1>0)
// 	{
// 		$sql2 = "insert into timeaxis(company_id,contract_id,des,user_id,type,relation_id,add_time,update_time)
// 			values(".$companyId.",".$contractId.",'".$desc."',$userId,4,".$contractId.",$nowtime,$nowtime)";
// 		// var_dump($sql2);

// 		$res2 = Mysql::run_insert($sql2);

// 		if($res2<=0)EchoJsonData(4,'插入时间轴表失败!');
// 	}
	
// }

// EchoJsonData(0,"插入成功!");

//返回新的回款计划状态
function returnNewPlanVerificationStatus($contractId,$refundMoney=0)
{
	global $companyId;

	$nowtime = time();

	$sql = "update verification_paymentplan set delet_time=$nowtime where contract_id=$contractId and company_id=$companyId and delete_time is null";
	// $result = Mysql::run_alter($sql);
	var_dump($sql);
	$result=1;
	if($result>0)
	{
		// foreach($eachVerificationMoney as $k=>$v)
		// {
		// 	foreach($returnPlanList as $k1=>$v1)
		// 	{
		// 		if($v['returning_money'] >= $v1['plan_money'])
		// 		{
		// 			$insertVerificationPaymentSql = "insert into verification_paymentplan(receivable_id,custom_id,company_id,caozuoren_id,contract_id,vercon_id,return_plan_id,returning_money,arrival_amount,discount_amount,returning_time,add_time,update_time)
		// 			values(receivableId,$customId,$companyId,$userId,$contractId,)"
		// 		}

		// 	}
		// }
	}
}
?>