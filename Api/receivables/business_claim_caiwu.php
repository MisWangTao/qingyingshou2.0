<?php
//财务核销
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0) EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$nowtime = time();

$is_caiwu = $userinfo['is_caiwu'];

if($is_caiwu != 1) EchoJsonData(1,'您不是财务无法操作');

$contract= json_decode($_POST['contract'],true);

if(count($contract)<=0) EchoJsonData(1,'没有选合同,不能核销');


   // $contract = array(
   //    				array(
   //    						'contract_id'=>6,
   //    						'returning_money'=>3
   //    					),
   //    				array(
   // 						'contract_id'=>7,
   //    						'returning_money'=>3
   // 				)
   //    			);

$id = I('post.id','i',0);

   // $id=29;
if($id==0)EchoJsonData(1,'回款单的id不能为空!');

$sql_caiwu = "select custom_id,operate_id,arrival_amount,arrival_date,states from receivables where id=$id and company_id=$company_id and delete_time is null";

$res = Mysql::run_select($sql_caiwu)[0];

if($res['states']!=1)EchoJsonData(3,'该回款单已核销!');

$operateId = $res['operate_id'];

if($operateId != $user_id)EchoJsonData(3,'建单子的不是你,不能操作!');


$arrival_amount =	$res['arrival_amount'];

$returning_time = $res['arrival_date'];

$customId = $res['custom_id'];



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




$insert_news = "insert into news (company_id,send_userid,accept_userid,type,state,style,relation_id,add_time,update_time)
				values($company_id,$user_id,$operateId,0,0,1,$id,$nowtime,$nowtime)";
$new_id = Mysql::run_insert($insert_news);





//修改回款表的内容   添加认领人 和 认领的时间
$sql3 = "update receivables set assist_id=$user_id,assist_time=$nowtime,verification_amount=$money,advance_payment_amount=$yush_money,states=2,contract_ids='".$contract_ids."' where id=$id and company_id=$company_id and delete_time is null";
// echo $sql3;exit;




$res3 = Mysql::run_alter($sql3);
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

if(count($_FILES)>0)
{
	foreach($_FILES as $k=>$v)
	{
		uploadFile($v['name'],$v['type'],$v['tmp_name'],$v['error'],$v['size']);
	}
}






if($res3)
	 EchoJsonData(0,'核销成功了!');
else
	EchoJsonData(1,'失败!');


function uploadFile($fileName,$fileType,$fileTmpName,$fileError,$fileSize)
{
	global $customId,$company_id,$user_id,$contractId,$nowtime;

	$root     = dirname(dirname(dirname(__FILE__)));

	$path     = "/upload/contract/".date("Y")."/".date("m")."/";

	$dir      = $root.$path;

	if (!file_exists($dir)){
	    if (!make_dir($dir))
	    {
	        /* 创建目录失败 */
	    }
	}


	$old_name =  substr($fileName,0,strrpos($fileName,'.'));

    $img_name = unique_name($dir);

    $ext      = ".".substr($fileType, strrpos($fileType,'/')+1);

	$filename = $dir.$img_name.$ext;

	$res      = move_uploaded_file($fileTmpName, $filename);

	if($res)
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);

	    $mimetype = finfo_file($finfo, $filename);

	    finfo_close($finfo);

	    $src      = $path.$img_name.$ext;

	    $t_filesize = filesize($filename);

	    $sql = "insert into files(company_id,custom_id,relation_id,relation_type,old_name,src,ext,mime,filesize,add_time,add_userid,update_time)
			values($companyId,$customId,$contractId,1,'".$old_name."','".$src."','".$ext."','".$mimetype."','".$fileSize."',".$nowtime.",$user_id,".$nowtime.")";

	    $filesId = Mysql::run_insert($sql);
	}



	return $filesId;
}





?>