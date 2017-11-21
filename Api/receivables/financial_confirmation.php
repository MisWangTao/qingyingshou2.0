<?php
//业务员发起财务确定的接口
require_once(__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

if($userId==0)EchoJsonData(1,'userId不能为空!');

$companyId = $userinfo['company_id'];
//预回款id
$id = I('post.forid','i',0);

if($id<=0)EchoJsonData(2,'预回款单id不能为空!');

//确定到帐
$is_arrival = I('post.is_arrival','i',0,true);

if($is_arrival==1)
{
	
	$sql = "select receivable_id from forecastreceivables where id=$id and company_id=$companyId";
	
	$res_fore_rece = Mysql::run_select($sql);
	
	if($res_fore_rece[0]['receivable_id'])EchoJsonData(2,'此与回款单子已经到账,不能再操作了!');
	
	$sql = "SELECT (SELECT custom_name FROM `custom_list` WHERE `custom_list` .id=`forecastreceivables` .custom_id and `custom_list` .delete_time is null) AS custom_name,
	arrival_date,arrival_amount,(SELECT realname FROM `company_user` WHERE `company_user` .id=`forecastreceivables` .operate_id AND is_delete=0) AS realname,custom_id,operate_id
	FROM `forecastreceivables` WHERE `id` = $id and company_id = $companyId and `delete_time` is null";
	// var_dump($sql);
	$res = Mysql::run_select($sql)[0];

	$customId = $res['custom_id'];

	$operateId = $res['operate_id'];

	$sql1 = "select contract_list.id,contract_list.contract_name,contract_list.contract_number,contract_money,forecastverification_contract.`returning_money`

		from contract_list

		left join forecastverification_contract on contract_list.id = forecastverification_contract.contract_id

		where contract_list.custom_id=$customId and contract_list.company_id=$companyId and contract_list.delete_time is null and

		forecastverification_contract.`willreceivable_id` =$id";

	$res1 = Mysql::run_select($sql1);
	//总核销金额
	$sumReturningMoney=0;
	$contractIds = array();

	foreach($res1 as $k=>$v)
	{
		$contractIds[] = $v['id'];
		$sumReturningMoney+= $v['returning_money'];
	}
	$contractIds = implode(",",$contractIds);

	if($sumReturningMoney>$res['arrival_amount'])EchoJsonData(3,'核销金额大于预计回款金额!');

	//结算方式
	$paymentId = I('post.payment_id','i',0,true);
//	$paymentId = 1;
	if($paymentId<=0)EchoJsonData(4,'结算方式不能为空!');
	//单据编号
	$number = I('post.number','s','',true);
	//备注
	$remark = I('post.remark','s','',true);
	
	$nowtime = time();
	
	$update_news_sql = "update news set state=1 where style=3 and relation_id=$id";
	
	$res_news = Mysql::run_alter($update_news_sql);
	
	
	$sql = "insert into receivables(origintype,custom_id,company_id,payment_method_id,operate_id,assist_id,assist_time,arrival_date,bill_number,contract_ids,arrival_amount,verification_amount,advance_payment_amount,remarks,add_time,update_time,states)
	values(2,$customId,$companyId,$paymentId,$operateId,$userId,$nowtime,'".$res['arrival_date']."','".$number."','".$contractIds."',".$res['arrival_amount'].",$sumReturningMoney,".($res['arrival_amount']-$sumReturningMoney).",'".$remark."',$nowtime,$nowtime,2)";
	// var_dump($sql);
	$receivableId = Mysql::run_insert($sql);
	
	$fore_rece_sql = "update forecastreceivables set receivable_id=$receivableId where id=$id";
	$re = Mysql::run_alter($fore_rece_sql);

	foreach($res1 as $k=>$v)
	{
		$sql_contract = "update contract_list set contracted_money=contracted_money+".$v['returning_money']." where id=".$v['id']." and company_id=$companyId";
		$res_contract = Mysql::run_alter($sql_contract);
		
		$sql2 = "insert into verification_contract(receivable_id,custom_id,company_id,caozuoren_id,contract_id,returning_money,arrival_amount,discount_amount,returning_time,add_time,update_time)
		values($receivableId,$customId,$companyId,$userId,".$v['id'].",".$v['returning_money'].",".$v['returning_money'].",0,'".$res['arrival_date']."',$nowtime,$nowtime)";
		// var_dump($sql2);
		$insert_id = Mysql::run_insert($sql2);
		$verification_contractId[] = $insert_id;


		$insert_timeaxis = "insert into timeaxis (company_id,contract_id,user_id,type,relation_id,add_time,update_time)
							values($companyId,".$v['id'].",$userId,3,$insert_id,$nowtime,$nowtime)";
		$res_hexiao = Mysql::run_insert($insert_timeaxis);
		
		
	}
	// var_dump($res1);
	//verfication_paymentplan
	foreach($res1 as $k=>$v)
	{
		$sql3 = "select id,plan_money,planed_money from contract_payment_plans where contract_id=".$v['id']." and plan_money>planed_money and delete_time is null and company_id=".$companyId;
		$returnPlan = Mysql::run_select($sql3);
		//剩余核销金额
		$saveReturningMoney = $v['returning_money'];

		if(count($returnPlan)){
			foreach($returnPlan as $k1=>$v1)
			{
				if($saveReturningMoney<=0)break;

				//核销金额跟回款计划对比
				if(($v1['planed_money']+$saveReturningMoney)>=$v1['plan_money'])
				{

					$cha = $v1['plan_money'] - $v1['planed_money'];
					$sql4 = "update contract_payment_plans set planed_money=planed_money+".$cha." where id=".$v1['id'];
				 	// var_dump($sql4);
				 	$res4 = Mysql::run_alter($sql4);

				 	$sql5 = "insert into verification_paymentplan(receivable_id,custom_id,company_id,caozuoren_id,contract_id,vercon_id,return_plan_id,returning_money,arrival_amount,discount_amount,returning_time,add_time,update_time)
				 	values($receivableId,$customId,$companyId,$userId,".$v['id'].",".$verification_contractId[$k].",".$v1['id'].",".$cha.",".$cha.",0,'".$res['arrival_date']."',$nowtime,$nowtime)";

				 	$res5 = Mysql::run_insert($sql5);

					$saveReturningMoney-=$cha;

				}else{
					$sql4 = "update contract_payment_plans set planed_money=planed_money+".$saveReturningMoney." where id=".$v1['id'];
					$res4 = Mysql::run_alter($sql4);
					// var_dump($sql4);

					$sql5 = "insert into verification_paymentplan(receivable_id,custom_id,company_id,caozuoren_id,contract_id,vercon_id,return_plan_id,returning_money,arrival_amount,discount_amount,returning_time,add_time,update_time)
				 	values($receivableId,$customId,$companyId,$userId,".$v['id'].",".$verification_contractId[$k].",".$v1['id'].",".$saveReturningMoney.",".$saveReturningMoney.",0,'".$res['arrival_date']."',$nowtime,$nowtime)";

				 	$res5 = Mysql::run_insert($sql5);

					$saveReturningMoney = 0;
				}
			}
			
		}
					
				
			if($saveReturningMoney > 0){
				$insert_child = "insert into verification_paymentplan(receivable_id,custom_id,company_id,contract_id,vercon_id,returning_money,arrival_amount,discount_amount,returning_time,add_time,update_time,caozuoren_id)
					 	values($receivableId,$customId,$companyId,".$v['id'].",".$verification_contractId[$k].",".$saveReturningMoney.",".$saveReturningMoney.",0,'".$res['arrival_date']."',$nowtime,$nowtime,$userId)";
				$res = Mysql::run_insert($insert_child);
				$saveReturningMoney = 0;
			}
		


	}
	$sql6 = "insert into news(company_id,send_userid,accept_userid,type,state,style,relation_id,add_time,update_time)
		values($companyId,$operateId,$userId,0,0,5,$id,$nowtime,$nowtime)";
	$res6 = Mysql::run_select($sql6);
}else if($is_arrival==0){
	
}
if(count($_FILES)>0){
//	var_dump($_FILES);
	foreach($_FILES as $k=>$v)
	{
		uploadFile($v['name'],$v['type'],$v['tmp_name'],$v['error'],$v['size']);
	}
}
EchoJsonData(0,'操作成功!');

//附件
//


function uploadFile($fileName,$fileType,$fileTmpName,$fileError,$fileSize)
{
	global $customId,$companyId,$userId,$receivableId,$nowtime;

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
			values($companyId,$customId,$receivableId,2,'".$old_name."','".$src."','".$ext."','".$mimetype."','".$fileSize."',".$nowtime.",$userId,".$nowtime.")";

	    $filesId = Mysql::run_insert($sql);
	}



	return $filesId;
}
?>