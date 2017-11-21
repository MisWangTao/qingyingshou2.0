<?php 
//编辑回款计划的接口
require_once(__DIR__."/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

$companyId = $userinfo['company_id'];

$contractId = I('post.id','i','',true);

$returnPlan = !empty($_POST['returnPlan'])?json_decode($_POST['returnPlan'],true):'';

$expiration_reminder = I('post.expiration_reminder','i',0);

if($expiration_reminder==1){
	$advance_remind = I('post.advance_remind','i',0);
	
	if($advance_remind<=0) EchoJsonData(1,'提醒时间不能为空!');
	
	$update_contract_sql = "update contract_list set expiration_reminder=$expiration_reminder,advance_remind=$advance_remind where id=$contractId and company_id=$companyId and delete_time is null";

	$res22 = Mysql::run_alter($update_contract_sql);
	
}
//查询的回款计划
$sql = "select id,plan_date,plan_money,plan_type,plan_remark from contract_payment_plans where contract_id=$contractId and company_id=$companyId and delete_time is null";

$res = Mysql::run_select($sql);
//去除总核销金额和核销详情
foreach($returnPlan  as $k=>$v)
{
	unset($returnPlan[$k]['planed_money']);
	unset($returnPlan[$k]['plan_detail']);
}
$result = returnTwoDimensionalDiffentData($res,$returnPlan);

$nowtime = time();
// exit;
//对比回款计划
foreach($result as $k=>$v)
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

	if($v['type']==1)
	{
		$sql1 = "insert into contract_payment_plans(contract_id,company_id,plan_date,plan_money,plan_type,plan_remark,add_time,update_time)
			values($contractId,$companyId,'".$v['plan_date']."',".$v['plan_money'].",".$v['plan_type'].",'".$v['plan_remark']."',$nowtime,$nowtime)";
		
		$res1 = Mysql::run_insert($sql1);

		if($v['plan_remark']){

			$editObj[] = "添加了时间为:".$v['plan_date'].",金额为:".number_format($v['plan_money'],2).",备注为:".$v['plan_remark'].",类型为:".$leixing_str."的回款计划";
		}else{

			$editObj[] = "添加了时间为:".$v['time'].",金额为:".number_format($v['plan_money'],2).",类型为:".$leixing_str."的回款计划";
		}
	}else if($v['type']==2)
	{   
		$where = "";
		$str = "";
		$sql = "select * from contract_payment_plans where delete_time is null and contract_id=$contractId and company_id=$companyId and id=".$v['id'];
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
		

		$sql1 = "update contract_payment_plans set $where update_time=$nowtime where delete_time is null and contract_id=$contractId and company_id=$companyId and id=".$v['id'];

		$res1 = Mysql::run_alter($sql1);

		$editObj[] = $str;

	}else if($v['type']==3)
	{
		//首先判断是否有核销金额
		$hexiaoJin_sql = "select sum(returing_money) from verification_paymentplan where return_plan_id=".$v['id']." and delete_time is null";
		$hexiaoJin = Mysql::run_select($hexiaoJin_sql);

				
		$sql1 = "update contract_payment_plans set delete_time=$nowtime where id=".$v['id'];

		$res1 = Mysql::run_alter($sql1);

		if($v['plan_remark']){
			$editObj[] = "删除了时间为:".$v['plan_date'].",金额为:".number_format($v['plan_money'],2).",备注为:".$v['plan_remark'].",类型为:".$leixing_str."的回款计划";
		}else{
			$editObj[] = "删除了时间为:".$v['time'].",金额为:".number_format($v['plan_money'],2).",类型为:".$leixing_str."的回款计划";
		}

	}
	$desc = addslashes(json_encode($editObj,JSON_UNESCAPED_SLASHES));
	// var_dump($desc);
	if($res1>0)
	{
		$sql2 = "insert into timeaxis(company_id,contract_id,des,user_id,type,relation_id,add_time,update_time)
			values(".$companyId.",".$contractId.",'".$desc."',$userId,4,".$contractId.",$nowtime,$nowtime)";
		// var_dump($sql2);

		$res2 = Mysql::run_insert($sql2);

		if($res2<=0)EchoJsonData(4,'插入时间轴表失败!');
	}
	
}

EchoJsonData(0,"插入成功!");

//返回二维数组的差异数据
function returnTwoDimensionalDiffentData($oldArr,$newArr)
{
	$editPlanId = array();
	$returnArr = array();	
	//type==1新增,type==2修改,type==3删除
	foreach($oldArr as $k=>$v)
	{	
		foreach($newArr as $k1=>$v1)
		{	
			if($v1['id']!=''){

				$editPlanId[] = $v1['id'];
			}

			if($v['id']==$v1['id'])
			{	

				$rs = array_diff_assoc($v1,$v);
				// var_dump($rs);
				if(count($rs)>0){
					$rs['id'] = $v['id'];
					$rs['type'] = 2;
					$returnArr[] = $rs;	
				}
				
			}
		}
	}
	
	foreach($newArr as $k=>$v)
	{
		if($v['id']=='')
		{
			$returnArr[]=$v;
		}
	}
	
	$editPlanId = array_unique($editPlanId);
	// var_dump($returnArr);
	foreach($oldArr as $k=>$v)
	{
		if(!in_array($v['id'],$editPlanId))
		{
			$returnArr[] = $v;
		}
	}

	foreach($returnArr as $k=>$v)
	{
		if($v['id']=='')
		{
			$returnArr[$k]['type'] = 1;

		}else if($v['id']!='' && $v['type']=='')
		{	
			$returnArr[$k]['type'] = 3;
		}
	}
	return $returnArr;	
}


?>