<?php
//业务人员认领的接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0) EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$nowtime = time();

$is_caiwu = $userinfo['is_caiwu'];

if($is_caiwu != 0) EchoJsonData(1,'业务员做的!');

   // $_POST = array(
   // 		'id'=>24,
   // 		'contract'=>array(
   // 				array(
   // 						'contract_id'=>1,
   // 						'returning_money'=>11
   // 					),
   // 				array(
			// 			'contract_id'=>2,
   // 						'returning_money'=>3
			// 	)
   // 			)
   // 	);




$contract= json_decode($_POST['contract'],true);
if(count($contract)<=0)EchoJsonData(1,'没有选合同!');

//$contract = $_POST['contract'];
$newsid = I('post.newsid','i',0);
if($newsid==0)EchoJsonData(1,'news的id不能为空!');

$edit_news = "update news set state=1 where id=$newsid and company_id=$company_id ";

$res_news = Mysql::run_alter($edit_news);

$red_relation = Mysql::run_select("select relation_id from news where id=$newsid and delete_time is null and company_id=$company_id");

if(!$red_relation)EchoJsonData(1,'参数错误!');

// var_dump($id);exit;
$id =$red_relation[0]['relation_id'];   //回款表的id值

$sql_caiwu = "select custom_id,operate_id,arrival_amount,arrival_date,assist_id,states from receivables where id=$id and company_id=$company_id and delete_time is null";

$res = Mysql::run_select($sql_caiwu)[0];

$assist_id = $res['assist_id'];

$states = $res['states'];

if($assist_id||$states!=1)EchoJsonData(1,'被人家抢了,下次下手快点啊!');

$operateId = $res['operate_id'];

$arrival_amount =	$res['arrival_amount'];

$returning_time = $res['arrival_date'];

$customId = $res['custom_id'];

$insert_news = "insert into news (company_id,send_userid,accept_userid,type,state,style,relation_id,add_time,update_time)
				values($company_id,$user_id,$operateId,0,0,1,$id,$nowtime,$nowtime)";
$new_id = Mysql::run_insert($insert_news);







$money = 0;
$contract_ids = '';
foreach($contract as $key=>$value){
	$money += $value['returning_money'];
	$contract_ids .= $value['contract_id'].',';
	$sql = "select (contract_money-ifnull(contracted_money,0)) as ysye from contract_list where id='".$value['contract_id']."' and delete_time is null and company_id=$company_id";
	// echo $sql;
	$res2 = Mysql::run_select($sql)[0]['ysye'];

	if($res2<$value['returning_money']) EchoJsonData(1,'核销金额不能大于该合同的应收余额!');

}

// echo $money;
if($money>$arrival_amount)  EchoJsonData(1,'总核销金额不能大于预计回款金额!');

$yush_money = $arrival_amount - $money;

$contract_ids = substr($contract_ids, 0,-1);



//修改回款表的内容   添加认领人 和 认领的时间
$sql = "update receivables set assist_id=$user_id,assist_time=$nowtime,verification_amount='".$money."',advance_payment_amount='".$yush_money."',states=2,contract_ids='".$contract_ids."' where id=$id and company_id=$company_id and delete_time is null";
//echo $sql;exit;
$res1 = Mysql::run_alter($sql);





$verification_contractId = array();
foreach($contract as $k=>$v)
	{
		$sql_contract = "update contract_list set contracted_money=contracted_money+".$v['returning_money']." where id=".$v['contract_id']." and company_id=$company_id";
		$res_contract = Mysql::run_alter($sql_contract);
		$sql2 = "insert into verification_contract(receivable_id,custom_id,company_id,contract_id,returning_money,arrival_amount,returning_time,add_time,update_time,caozuoren_id)
		values($id,$customId,$company_id,".$v['contract_id'].",".$v['returning_money'].",".$v['returning_money'].",'".$returning_time."',$nowtime,$nowtime,$user_id)";
		// var_dump($sql2);
		$insert_id = Mysql::run_insert($sql2);
		$verification_contractId[] = $insert_id;


		$insert_timeaxis = "insert into timeaxis (company_id,contract_id,user_id,type,relation_id,add_time,update_time)
							values($company_id,".$v['contract_id'].",$user_id,3,$insert_id,$nowtime,$nowtime)";
		$res_hexiao = Mysql::run_insert($insert_timeaxis);
	}

// print_r($verification_contractId);
// exit;



foreach($contract as $k=>$v)
	{
		$sql3 = "select id,plan_money,planed_money from contract_payment_plans where contract_id=".$v['contract_id']." and plan_money>planed_money and delete_time is null and company_id=".$company_id;
		$returnPlan = Mysql::run_select($sql3);
		//剩余核销金额
		$saveReturningMoney = $v['returning_money'];
		if(count($returnPlan)){
			foreach($returnPlan as $k1=>$v1)
				{
					if($saveReturningMoney<=0)break;
					// if($v1['plan_money']==$v1['planed_money'])continue;
					//核销金额跟回款计划对比
					if(($v1['planed_money']+$saveReturningMoney)>=$v1['plan_money'])
					{

						$cha = $v1['plan_money'] - $v1['planed_money'];
						$sql4 = "update contract_payment_plans set planed_money=planed_money+".$cha." where id=".$v1['id'];
					 	// var_dump($sql4);
					 	$res4 = Mysql::run_alter($sql4);

					 	$sql5 = "insert into verification_paymentplan(receivable_id,custom_id,company_id,contract_id,vercon_id,return_plan_id,returning_money,arrival_amount,discount_amount,returning_time,add_time,update_time,caozuoren_id)
					 	values($id,$customId,$company_id,".$v['contract_id'].",".$verification_contractId[$k].",".$v1['id'].",".$cha.",".$cha.",0,'".$res['arrival_date']."',$nowtime,$nowtime,$user_id)";

					 	$res5 = Mysql::run_insert($sql5);

						$saveReturningMoney-=$cha;

					}else{
						$sql4 = "update contract_payment_plans set planed_money=planed_money+".$saveReturningMoney." where id=".$v1['id'];
						$res4 = Mysql::run_alter($sql4);
						// var_dump($sql4);

						$sql5 = "insert into verification_paymentplan(receivable_id,custom_id,company_id,contract_id,vercon_id,return_plan_id,returning_money,arrival_amount,discount_amount,returning_time,add_time,update_time,caozuoren_id)
					 	values($id,$customId,$company_id,".$v['contract_id'].",".$verification_contractId[$k].",".$v1['id'].",".$saveReturningMoney.",".$saveReturningMoney.",0,'".$res['arrival_date']."',$nowtime,$nowtime,$user_id)";

					 	$res5 = Mysql::run_insert($sql5);

						$saveReturningMoney = 0;
					}
				}
				
				
				
				
				
		}
				if($saveReturningMoney > 0){
					$insert_child = "insert into verification_paymentplan(receivable_id,custom_id,company_id,contract_id,vercon_id,returning_money,arrival_amount,discount_amount,returning_time,add_time,update_time,caozuoren_id)
					 	values($id,$customId,$company_id,".$v['contract_id'].",".$verification_contractId[$k].",".$saveReturningMoney.",".$saveReturningMoney.",0,'".$res['arrival_date']."',$nowtime,$nowtime,$user_id)";
					$res1 = Mysql::run_insert($insert_child);
					$saveReturningMoney = 0;
				}
		

	}


if($new_id)
	 EchoJsonData(0,'认领成功!');
else
	EchoJsonData(1,'失败!');








?>