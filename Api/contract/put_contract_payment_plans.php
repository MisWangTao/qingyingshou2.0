<?php 
//编辑回款计划接口
require_once(__DIR__ . "/../common/common.php");

$userInfo = $GLOBALS['userinfo'];

$userId = $userInfo['id'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

$companyId = $userInfo['company_id'];

//回款计划
$sql1 = "select id,plan_date,plan_money,plan_type,plan_remark from contract_payment_plans where contract_id=$contractId and delete_time is null";

$res1 = Mysql::run_select($sql1);


$diffentArr = returnTwoDimensionalDiffentData($olds_contract['returnPlan'],$news_contract['returnPlan']);

$returnPlanDate = I('post.returnPlanDate','s','',true);
//回款计划(日期,金额,类型,备注)
//
//	
//			
		//对比回款计划
		foreach($diffentArr as $k=>$v)
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
				
				// $res1 = Mysql::run_insert($sql1);

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

				// $res1 = Mysql::run_alter($sql1);
				$editObj[] = $str;
			}else if($v['type']==3)
			{
				$sql1 = "update contract_payment_plans set delete_time=$nowtime where id=".$v['id'];

				// $res1 = Mysql::run_alter($sql1);

				if($v['plan_remark']){
					$editObj[] = "删除了时间为:".$v['plan_date'].",金额为:".number_format($v['plan_money'],2).",备注为:".$v['plan_remark'].",类型为:".$leixing_str."的回款计划";
				}else{
					$editObj[] = "删除了时间为:".$v['time'].",金额为:".number_format($v['plan_money'],2).",类型为:".$leixing_str."的回款计划";
				}

			}
			
		}


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