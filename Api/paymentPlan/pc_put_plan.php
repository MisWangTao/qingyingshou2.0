<?php 
//编辑回款计划的接口
require_once(__DIR__."/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

$companyId = $userinfo['company_id'];

$contractId = I('post.contract_id','i','',true);

if($contractId=='')EchoJsonData(1,'合同单id不能为空!');

$planId = I('post.plan_id','i','',true);

$planDate = I('post.plan_date','s','',true);

if($planDate=='')EchoJsonData(2,'回款计划时间不能为空!');

$planMoney = I('post.plan_money','f','',true);

if($planMoney=='')EchoJsonData(3,'回款计划金额不能为空!');

$planType = I('post.plan_type','i','',true);

$planRemark = I('post.plan_remark','s','',true);

//查询回款计划
$sql = "select id,plan_date,plan_money,plan_type,plan_remark,planed_money from contract_payment_plans where company_id=$companyId and id=$planId";
$returnPlan = Mysql::run_select($sql)[0];
//查询合同金额
$sql = "select contract_money from contract_list where id=$contractId";
$contractMoney = Mysql::run_select($sql)[0]['contract_money'];


//查询其他回款计划
$sql = "select sum(plan_money) as otherPlanMoney from contract_payment_plans where contract_id=$contractId and id!=$planId and delete_time is null";
$saveReturnPlanMoney = Mysql::run_select($sql)[0]['otherPlanMoney'];
$saveReturnPlanMoney = $saveReturnPlanMoney?$saveReturnPlanMoney:0;

$NewReturnPlan = array();

$NewReturnPlan['id'] = $planId;
$NewReturnPlan['plan_date'] = $planDate;
$NewReturnPlan['plan_money'] = floatval($planMoney);
$NewReturnPlan['plan_type'] = $planType;
$NewReturnPlan['plan_remark'] = $planRemark;

if($NewReturnPlan['plan_money'] < $planed_money)EchoJsonData(4,'回款计划金额不能小于核销金额!');

if($NewReturnPlan['plan_money'] > $contractMoney-$saveReturnPlanMoney)EchoJsonData(5,'回款计划金额不能超过合同总额!');

$OldReturnPlan['id'] = $returnPlan['id'];
$OldReturnPlan['plan_date'] = $returnPlan['plan_date'];
$OldReturnPlan['plan_money'] = floatval($returnPlan['plan_money']);
$OldReturnPlan['plan_type'] = $returnPlan['plan_type'];
$OldReturnPlan['plan_remark'] = $returnPlan['plan_remark'];

$result = array_diff_assoc($NewReturnPlan,$OldReturnPlan);

$nowtime = time();

$arr = array();

$arr[] = $result;
if($result)
{
	foreach($arr as $k=>$v)
	{	
		$leixing_str = "";
		
		switch ($v['plan_type']) {

			case 1:
				$leixing_str = '常规';
				break;
			case 2:
				$leixing_str = '预收款';
				break;
			case 3:
				$leixing_str = '质保金';
				break;
			case 4:
				$leixing_str = '尾款';
				break;
		}
	   
			$where = "";
			$str = "";

			$sql = "select * from contract_payment_plans where delete_time is null and contract_id=$contractId and company_id=$companyId and id=".$planId;
			$res = Mysql::run_select($sql)[0];

			switch ($res['plan_type']) {

			case 1:
				$leixing = '常规';
				break;
			case 2:
				$leixing = '预收款';
				break;
			case 3:
				$leixing = '质保金';
				break;
			case 4:
				$leixing = '尾款';
				break;
			}

			$str = "将时间为:".$res['plan_date'].",金额为:".number_format($res['plan_money'],2).",备注为:".$res['plan_remark'].",类型为:".$leixing."的回款计划 修改为:";

			if($v['plan_date']!='')
			{
				$where.="plan_date='".$v['plan_date']."',";
				$str.= "时间为:".$v['plan_date'].",";
			}else{
				$str.= "时间为:".$res['plan_date'].",";
			}

			if($v['plan_money']!='')
			{
				$where.="plan_money='".$v['plan_money']."',";
				$str.="金额为:".number_format($v['plan_money'],2).",";
			}else{
				$str.= "时间为:".number_format($res['plan_money'],2).",";
			}
			if($v['plan_remark']!='')
			{
				$where.="plan_remark='".$v['plan_remark']."',";
				$str.="备注为:".$v['plan_remark'].",";
			}else{
				$str.= "备注为:".$res['plan_remark'].",";
			}	
			if($v['plan_type']!='')
			{
				$where.="plan_type='".$v['plan_type']."',";
				$str.="类型为".$leixing_str."的回款计划";
			}else{
				$str.= "类型为:".$leixing."的回款计划";
			}
			
			$sql1 = "update contract_payment_plans set $where update_time=$nowtime where delete_time is null and contract_id=$contractId and company_id=$companyId and id=".$planId;

			$res1 = Mysql::run_alter($sql1);

			$editObj[] = $str;

	}
}

	$desc = addslashes(json_encode($editObj,JSON_UNESCAPED_SLASHES));
	
	if($res1>0)
	{
		$sql2 = "insert into timeaxis(company_id,contract_id,des,user_id,type,relation_id,add_time,update_time)
			values(".$companyId.",".$contractId.",'".$desc."',$userId,4,".$contractId.",$nowtime,$nowtime)";
			
		$res2 = Mysql::run_insert($sql2);

		if($res2<=0)EchoJsonData(6,'插入时间轴表失败!');
	}	
$sql = "select id,plan_date,plan_money,plan_remark,plan_type,planed_money from contract_payment_plans where company_id=$companyId and contract_id=$contractId and delete_time is null";

$returnPlan = Mysql::run_select($sql);

foreach($returnPlan as $k=>$v){
	$sql = "select returning_money,returning_time from `verification_paymentplan`  where return_plan_id=".$v['id']." and contract_id=$contractId";
	$res = Mysql::run_select($sql);
	$res = count($res)?$res:array();
	$returnPlan[$k]['plan_detail'] = $res;
}

WriteOffContract($contractId);
EchoJsonData(0,'编辑回款计划成功!',$returnPlan);
?>