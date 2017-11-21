<?php
//PC变更财务审核接口（通过接口）
require_once(__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");


$userInfo = $GLOBALS['userinfo'];

$userId  = $userInfo['id'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

$companyId = $userInfo['company_id'];

$nowtime = time();

$nowDate = date("Y-m-d");

$changeId = I('post.change_id','i','',true);

if($changeId=='')EchoJsonData(2,'变更单Id不存在!');

$newsId = I('post.news_id','i','',true);

if($newsId=='')EchoJsonData(3,'消息Id不存在!');
//结算方式
$paymentMethod = I('post.payment_method','i','',true);

if($paymentMethod=='')EchoJsonData(4,'结算方式不能为空!');

$number = I('post.number','s','',true);

$remark = I('post.remark','s','',true);

$sendFollowMessage = I('post.message','s','',true);

// $mysqli =new mysqli($DB_IP,$DB_Username,$DB_Password,$DB_Name);

// mysqli_query($mysqli ,"set names utf8");

// $mysqli->autocommit(false);

$sql = "update news set state=1 where id=$newsId";
$newsStatus = Mysql::run_alter($sql);
//查询变更信息
$sql1 = "select * from contract_change where id=$changeId";

$changeInfo = Mysql::run_select($sql1);

$contractId = $changeInfo[0]['contract_id'];

$sendUserid = $changeInfo[0]['user_id'];
//变更类型
$changeType = $changeInfo[0]['change_type'];
//退款金额
$refundMoney = $changeInfo[0]['refund_money'];

//查询合同信息
$sql2 = "select * from contract_list where id=$contractId and company_id=$companyId";

$contractInfo = Mysql::run_select($sql2);

$contractType = $contractInfo[0]['contract_type'];

$customId = $contractInfo[0]['custom_id'];

$firstDate = $contractInfo[0]['first_date_payment']; 
//周期合同收款方式
$paymentCycle = $contractInfo[0]['payment_cycle'];

$maturityDate = $changeInfo[0]['maturity_date'];
//合同金额
$contractMoney = $contractInfo[0]['contract_money'];

if($changeType=='')EchoJsonData(5,'变更类型不能为空!');
//变更金额
$changeMoney = $changeInfo[0]['change_money'];

// if($newsStatus<=0)EchoJsonData(5,'修改news失败!');

$sql1= "
insert into news (company_id,send_userid,accept_userid,type,message,state,style,relation_id,add_time,update_time)
	values($companyId,$userId,$sendUserid,1,'".$sendFollowMessage."',1,8,$changeId,$nowtime,$nowtime)";

$newsId = Mysql::run_insert($sql1);

if($newsId<=0)EchoJsonData(6,'插入news失败!');

//查询变更回款计划关联表里的回款计划
$sql3 = 
"select * from contract_payment_plan_change where contract_change_id=$changeId and contract_id=$contractId and delete_time is null order by payment_plan_date desc";

$returnPlan = Mysql::run_select($sql3);

//查询游离核销
$sql5 = "select ifnull(sum(returning_money),0) as daozhang from verification_paymentplan where contract_id=$contractId and return_plan_id is null and delete_time is null ";

$youliMoney = Mysql::run_select($sql5)[0]['daozhang'];

//如果是周期合同变更金额需要计算

if($contractType==2)
{	
	$sumChangeContractMoney = 0;
	foreach($returnPlan as $k=>$v)
	{
		$sumChangeContractMoney += $v['change_plan_money'];
	}
	$changeMoney = $sumChangeContractMoney-$contractMoney;
}

//仅变更
if($changeType==1)
{
	$sql2 = "update contract_list set contract_money=contract_money+".$changeMoney." where id=".$contractId;
	
	$fetch_row1 = Mysql::run_alter($sql2);

	if($fetch_row1<=0)EchoJsonData(10,'更新contract_list表失败!');
	
	// //普通
	if($returnPlan)
	{
		foreach($returnPlan as $k=>$v)
		{
			if($v['type']==4)continue;
			if($v['type']==1)
			{
			$sql4 = "insert into contract_payment_plans(contract_id,company_id,plan_date,plan_money,plan_type,plan_remark,add_time,update_time)
			values($contractId,$companyId,'".$v['change_plan_date']."',".$v['change_plan_money'].",".$v['change_plan_type'].",'".$v['change_plan_date']."',$nowtime,$nowtime)";
			
				$fetch_row2 = Mysql::run_insert($sql4);

			}else if($v['type']==2)
			{
				if($v['payment_plan_money'] != $v['change_plan_money'])
				{
					$sql5 = "update contract_payment_plans set plan_date='".$v['change_plan_date']."',plan_money=".$v['change_plan_money'].",plan_type=".$v['change_plan_type'].",plan_remark='".$v['change_plan_remark']."' where id=".$v['payment_plan_id'];
					
					$fetch_row2 =  Mysql::run_alter($sql5);
				}

			}else if($v['type']==3)
			{
				$sql3 = "update contract_payment_plans set delete_time=$nowtime where id=".$v['payment_plan_id'];

				$fetch_row2 =  Mysql::run_alter($sql3);
			}

		}
		if($v['type']!=4 && $fetch_row2<=0)EchoJsonData(7,'更新contract_payment_plans表失败!');
	}
		
}else if($changeType==2) //变更并退款
{
	// echo 33;
	// $updateContractMoneySql = "update contract_list set contract_money=contract_money+".$changeMoney.",contracted_money=contracted_money+".-$refundMoney." where id=".$contractId;
	// $fetch_row1 = Mysql::run_alter($updateContractMoneySql);
	// var_dump($updateContractMoneySql);
	// if($fetch_row1<=0)EchoJsonData(10,'更新contract_list表失败!');
	
	// $insertVerificationContractSql = "insert into verification_contract(custom_id,company_id,caozuoren_id,contract_id,returning_money,arrival_amount,returning_time,add_time,update_time)
	//   values($customId,$companyId,$userId,$contractId,-$refundMoney,-$refundMoney,'".$nowDate."',$nowtime,$nowtime)";
    
 //    $VerificationContractId = Mysql::run_insert($insertVerificationContractSql);
 //    var_dump($insertVerificationContractSql);
   
 //    if($VerificationContractId<=0)EchoJsonData(11,'插入verification_contract表失败!');
    
    

 // //   //    if($youliMoney!=0)
	// //   // {
	// //   // 	$insertVerificationPaymentPlanSql = "insert into verification_paymentplan(custom_id,company_id,caozuoren_id,contract_id,vercon_id,returning_money,arrival_amount,returning_time,add_time,update_time)
	// //   //   values($customId,$companyId,$userId,$contractId,$VerificationContractId,-$youliMoney,-$youliMoney,'".$nowDate."',$nowtime,$nowtime)";
	// //   //   $mysqli->query($insertVerificationPaymentPlanSql);
	// //   //   var_dump($insertVerificationPaymentPlanSql);	
	// //   //   $VerificationPaymentPlanId = mysqli_insert_id($mysqli);

	// //   //   if($VerificationPaymentPlanId<=0)
	// //   //   {
	// //   //   	$mysqli->rollback();
	// //   //   	EchoJsonData(8,'插入verification_paymentplan失败!');
	// //   //   }
	// //   // }

	//   //剩余退款金额	
 //      $saveRefund = $refundMoney - $youliMoney;

 //      if($returnPlan)
 //      {
 //      	foreach($returnPlan as $k=>$v)
 //      	{
 //      		// if($saveRefund<=0)break;
 //      		// var_dump($saveRefund);
 //      		if($v['type']==1)
 //      		{	
 //      			$insertContractPaymentPlansSql = "insert into contract_payment_plans(contract_id,company_id,plan_date,plan_money,planed_money,plan_type,plan_remark,add_time,update_time)
 //      			values($contractId,$companyId,'".$v['change_plan_date']."',".$v['change_plan_money'].",".$v['changed_plan_money'].",".$v['change_plan_type'].",'".$v['change_plan_remark']."',$nowtime,$nowtime)";
      			
 //      			var_dump($insertContractPaymentPlansSql);
 //      			$contractPaymentPlanId = Mysql::run_insert($insertContractPaymentPlansSql);
 //      			if($contractPaymentPlanId<=0)EchoJsonData(12,'插入contract_payment_plans失败!');
      			

 //      		}else if($v['type']==2)
 //      		{
 //      			$updateContractPaymentPlanSql = "update contract_payment_plans set plan_date='".$v['change_plan_date']."',plan_money=".$v['change_plan_money'].",plan_type=".$v['change_plan_type'].",plan_remark='".$v['change_plan_remark']."',planed_money=".$v['changed_plan_money']." where id=".$v['payment_plan_id'];
 //      			$fetch_row5 = Mysql::run_alter($updateContractPaymentPlanSql);
 //      			var_dump($updateContractPaymentPlanSql);
 //      			if($fetch_row5<=0)EchoJsonData(15,'更新contract_payment_plans表失败!');
      			
 //      		}else if($v['type']==3)
 //      		{
 //      			$deleteContractPaymentPlanSql = "update contract_payment_plans set delete_time=$nowtime where id=".$v['payment_plan_id'];
 //      			$fetch_row4 = Mysql::run_alter($deleteContractPaymentPlanSql)
 //      			var_dump($deleteContractPaymentPlanSql);	
 //      			if($fetch_row4<=0)EchoJsonData(14,'更新contract_payment_plans表失败!');
      			
 //      		}
 //      	}
      	
 //      }

}else if($changeType==3) //仅退款(不可以直接修改回款计划)
{	

	  // $insertVerificationContractSql = "insert into verification_contract(custom_id,company_id,caozuoren_id,contract_id,returning_money,arrival_amount,returning_time,add_time,update_time)
	  // values($customId,$companyId,$userId,$contractId,-$refundMoney,-$refundMoney,'".$nowDate."',$nowtime,$nowtime)";

	  // $VerificationContractId = Mysql::run_insert($insertVerificationContractSql);

	  //  if($VerificationContractId<=0)EchoJsonData(11,'插入verification_contract表失败!');
       

	  // // if($youliMoney!=0)
	  // // {
	  // // 	$insertVerificationPaymentPlanSql = "insert into verification_paymentplan(custom_id,company_id,caozuoren_id,contract_id,vercon_id,returning_money,arrival_amount,returning_time,add_time,update_time)
	  // //   values($customId,$companyId,$userId,$contractId,$VerificationContractId,-$youliMoney,-$youliMoney,$nowDate,$nowtime,$nowtime)";
	  // //   $mysqli->query($insertVerificationPaymentPlanSql);

	  // //   $VerificationPaymentPlanId = mysqli_insert_id($mysqli);

	  // //   if($VerificationPaymentPlanId<=0)
	  // //   {
	  // //   	$mysqli->rollback();
	  // //   	EchoJsonData(8,'插入verification_paymentplan失败!');
	  // //   }
	  // // }
}
exit;
if($changeType!=1)
{
	WriteOffContract($contractId);
}
	
EchoJsonData(0,'变更申请已通过!',$contractId);

?>