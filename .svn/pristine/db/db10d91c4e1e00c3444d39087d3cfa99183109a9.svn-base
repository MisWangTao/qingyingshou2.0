<?php
require_once(__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");
require_once ("../../common/config/db.cof.php");

$userInfo = $GLOBALS['userinfo'];

$userId  = $userInfo['id'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

$companyId = $userInfo['company_id'];

$nowtime = time();

$nowdate = date('Y-m-d',time());

//发送给哪个财务id
$send_userid = I('post.send_userid','i',0);
if($send_userid<=0) EchoJsonData(1,'发送财务不为空!');
//客户名称
$customId = I('post.custom_id','i','NULL',true);
//合同Id
$contractId = I('post.contractId','i','NULL',true);
//变更业务类型
$change_type = I('post.change_type','i','NULL',true);

if($change_type=='NULL')EchoJsonData(2,'变更业务类型不能为空!');
//原因
$change_reason = I('post.refund_reason','s','',true);

if($change_reason=='')EchoJsonData(3,'变更原因不能为空!');
//变更金额
$change_money = I('post.change_money','f','0.00',true);
//日期
//$change_date = !empty($_POST['refund_date']) ? request_clean($_POST['refund_date']):'';
$change_date = I('post.refund_date','s','');
//退款金额
$refund_money = I('post.refund_money','f',0);
//$refund_money = !empty($_POST['refund_money']) ? floatval($_POST['refund_money']):'0.00';
//是否退款
//$change_type = intval($_POST['refunds']);
$change_type = I('post.change_type','i');
// $paymentMethodId = !empty($_POST['paymentMethodId']) ? intval($_POST['paymentMethodId']):0;
//编号
//$number = !empty($_POST['number']) ? request_clean($_POST['number']):'';
$number = I('post.number','s','');
//备注
//$remark = !empty($_POST['remark']) ? request_clean($_POST['remark']):'';
$remark = I('post.remark','s','',true);

$returnPlan = !empty($_POST['returnPlan'])?json_decode($_POST['returnPlan'],true):"";

$mysqli =new mysqli($DB_IP,$DB_Username,$DB_Password,$DB_Name);

mysqli_query($mysqli ,"set names utf8");

$mysqli->autocommit(false);

//防止多次提交
$sqll ="select * from contract_change where custom_id=$customId and company_id=$companyId and contract_id=$contract_id and user_id=$userId order by
add_time desc";

$ress = Mysql::run_select($sqll);
//上次添加时间戳
$addTime = $ress[0]['add_time']?$ress[0]['add_time']:0;

//查询业务金额
$sql = "select contract_money from contract_list where id=$contract_id";

$res = Mysql::run_select($sql);

$yewuje = $res[0]['money'];

//查询到账
$sql = "select ifnull(sum(returning_money),0) as daozhang,ifnull(sum(arrival_amount),0) as daozhang1 from verification_contract where contract_id=$contract_id and delete_time is null";

$res = Mysql::run_select($sql);

$daozhang = $res[0]['daozhang'];

$daozhang1 = $res[0]['daozhang1'];

if(($nowtime - $addTime) > 2)
{
	$recordChangeId = insertRecordChange($customId,$contract_id,$change_money,$change_date,$change_reason,$change_type,$refund_money,$paymentMethodId,$number,$remark);

	for($i=0;$i<count($_FILES['file']['name']);$i++)
	{
		if($_FILES['file']['name'][$i]!='')
		{
			$filesId = insertRecordChangeFiles($_FILES['file']['name'][$i],$_FILES['file']['type'][$i],$_FILES['file']['tmp_name'][$i],$_FILES['file']['error'][$i],$_FILES['file']['size'][$i],$customId,$recordChangeId);
			if($filesId<=0)
			{
				$mysqli->rollback();
			}
		}
	}

	if($recordChangeId>0)
	{
		$updateRecordSql = "update contract_list set contract_money=contract_money+$change_money where id=$contract_id";

		$updateRecordRows = mysqli_query($mysqli,$updateRecordSql);
	}


	if($returnPlan){

		$saveDaozhang = $daozhang - $refund_money;

		foreach($returnPlan as $k=>$v)
		{
			//改变returnPlan的数据
			$returnId = updateReturnPlan($v['type'],$contract_id,$v['id'],$v['returned_money'],$refund_money,$v['return_type'],$v['return_money'],$v['return_date'],$v['return_remark'],$v['change_type'],$v['change_money'],$v['change_date'],$v['change_remark']);

			if($returnId<=0)
			{
				$mysqli->rollback();

			}
			$recordOfReturnPlanId = insertRecordOfReturnPlan($v['type'],$recordChangeId,$contract_id,$returnId,$v['returned_money'],$v['return_type'],$v['return_money'],$v['return_date'],$v['return_remark']);

			// var_dump($recordOfReturnPlanId);
			// echo "<br/>";

			if($recordOfReturnPlanId<=0)
			{
				$mysqli->rollback();

			}
		}
	}
	if($recordChangeId>=0)
	{
		$returnLogId = updateReturnLog($contract_id,$recordChangeId,$refund_money,$change_date,$number,$paymentMethodId);

		updatePlanRecord($contract_id,$returnLogId,$recordChangeId,$refund_money,$change_date,$number,$paymentMethodId);
	}
}












if(!$mysqli->errno && $recordChangeId >0 && $updateRecordRows)
{
	$mysqli->commit();

	echo "<div></div><script language='javascript'>
			layer_alert(1,'添加变更成功!','biangeng.php?id=".$contract_id."');
		</script>";


}else
{
	$mysqli->rollback();

	echo "<div></div><script language='javascript'>layer_alert(2,'请勿连续添加!','biangeng.php?id=".$contract_id."');</script>";

}

$mysqli->autocommit(true); //设置为非自动提交——事务处理

$mysqli->close();

//插入record_change表  contract_change表插数据
function insertRecordChange($customId,$contract_id,$changeMoney,$changeDate,$changeReason,$changeType,$refundMoney,$style,$number,$remark)
{
	global $mysqli,$nowtime,$companyId,$userId,$yewuje,$daozhang,$daozhang1;

	if($changeType==1)
	{
		//合同金额变更
		$sql = "insert into contract_change(send_userid,custom_id,company_id,contract_id,user_id,change_money,change_date,change_reason,change_type,remark,original_ywje,original_ysye,original_dz,add_time,update_time)
			values($send_userid,$customId,$companyId,$contract_id,$userId,$changeMoney,'".$changeDate."','".$changeReason."',$changeType,'".$remark."',$yewuje,($yewuje-$daozhang),$daozhang1,".$nowtime.",".$nowtime.")";
	}else if($changeType==2)
	{
		//合同金额变更和退款
		$sql = "insert into contract_change(send_userid,custom_id,company_id,contract_id,user_id,change_money,change_date,change_reason,change_type,refund_money,remark,original_ywje,original_ysye,original_dz,add_time,update_time)
			values($send_userid,$customId,$companyId,$contract_id,$userId,$changeMoney,'".$changeDate."','".$changeReason."',$changeType,$refundMoney,'".$remark."',$yewuje,($yewuje-$daozhang),$daozhang1,".$nowtime.",".$nowtime.")";
	}else if($changeType==3){
		//仅退款
		$sql = "insert into contract_change(send_userid,custom_id,company_id,contract_id,user_id,change_date,change_type,refund_money,remark,original_ywje,original_ysye,original_dz,add_time,update_time)
			values($send_userid,$customId,$companyId,$contract_id,$userId,'".$changeDate."',$changeType,$refundMoney,'".$remark."',$yewuje,($yewuje-$daozhang),$daozhang1,".$nowtime.",".$nowtime.")";
	}

	$mysqli->query($sql);

	$recordChangeId = mysqli_insert_id($mysqli);

	return $recordChangeId;
}















//插入record_change_files表
function insertRecordChangeFiles($fileName,$fileType,$fileTMPName,$fileError,$fileSize,$customId,$changeId)
{
	global $mysqli,$nowtime,$companyId,$userId;

	$root     = dirname(dirname(dirname(__FILE__)));

	$path     = "/upload/biangeng/".date("Y")."/".date("m")."/";

	$dir      = $root.$path;

	$now_time = time();

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

	$res      = move_uploaded_file($fileTMPName, $filename);

	if($res)
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);

	    $mimetype = finfo_file($finfo, $filename);

	    finfo_close($finfo);

	    $src      = $path.$img_name.$ext;

	    $t_filesize = filesize($filename);

	    $sql = "insert into files(relation_type,custom_id,company_id,user_id,relation_id,src,ext,mime,filesize,add_time,update_time,old_name)
			values(3,$customId,$companyId,$userId,$changeId,'".$src."','".$ext."','".$mimetype."','".$fileSize."',".$nowtime.",".$nowtime.",'".$old_name."')";

	    $mysqli->query($sql);

		$filesId = mysqli_insert_id($mysqli);
	}
	return $filesId;
}

//改变returnPlan表
function updateReturnPlan($type,$contract_id,$returnPlanId,$returnedMoney,$refundMoney,$returnPlanType,$returnPlanMoney,$returnPlanDate,$returnPlanRemark,$changeType,$changeMoney,$changeDate,$changeRemark)
{
	global $mysqli,$nowtime,$companyId,$userId,$returnPlan,$falge,$saveDaozhang;  //$refundMoney退款金额需要传进来来计算关系
	//新增
	if($type==1)
	{
		$sql = "insert into contract_payment_plans(company_id,contract_id,plan_type,return_money,return_date,remark,add_time,update_time)
				values($companyId,$contract_id,$changeType,$changeMoney,".$changeDate.",'".$changeRemark."',$nowtime,$nowtime)";

		$mysqli->query($sql);

		$returnPlanId = mysqli_insert_id($mysqli);


	}else if($type==2) //修改
	{

		if($saveDaozhang>$returnedMoney)
		{

			$sql = "update contract_payment_plans set plan_type=".$changeType.",return_money=".$changeMoney.",return_date=".$changeDate.",returned_money=".$returnedMoney.",remark='".$changeRemark."' where id=$returnPlanId";
			// echo "大于的回款的:<br/>";
			// var_dump($sql);
			// echo "<br/>";
			$res = mysqli_query($mysqli,$sql);

			$saveDaozhang = $saveDaozhang - $returnedMoney;

			if($saveDaozhang<=0)$saveDaozhang=0;


		}else
		{
			$sql = "update contract_payment_plans set plan_type=".$changeType.",return_money=".$changeMoney.",return_date=".$changeDate.",returned_money=".$saveDaozhang.",remark='".$changeRemark."' where id=$returnPlanId";
			// echo "小于的回款的:<br/>";
			// var_dump($sql);
			// echo "<br/>";
			$res = mysqli_query($mysqli,$sql);

			$saveDaozhang = 0;
		}

	}else if($type==3) //删除
	{
		$sql = "update contract_payment_plans set delete_time=$nowtime where id=$returnPlanId";

		// var_dump($sql);

		$res = mysqli_query($mysqli,$sql);
	}
	// var_dump($sql);
	 return $returnPlanId;

}
//插入contract_payment_plan_change关联表
function insertRecordOfReturnPlan($type,$changeId,$contract_id,$returnPlanId,$returnedMoney,$returnPlanType,$returnPlanMoney,$returnPlanDate,$returnPlanRemark)
{
	global $nowtime,$returnPlan,$mysqli;
	//添加
	if($type==1)
	{
		$sql="insert into contract_payment_plan_change(contract_change_id,contract_id,type,payment_plan_id,add_time,update_time)
		values($changeId,$contract_id,$type,$returnPlanId,$nowtime,$nowtime)";

		// var_dump($sql);

	}else if($type==2) //编辑
	{

		$sql="insert into contract_payment_plan_change(contract_change_id,contract_id,type,payment_plan_id,return_plan_money,returned_plan_money,return_plan_type,return_plan_date,return_plan_remark,add_time,update_time)
		values($changeId,$contract_id,$type,$returnPlanId,$returnPlanMoney,$returnedMoney,$returnPlanType,'".$returnPlanDate."','".$returnPlanRemark."',$nowtime,$nowtime)";

		// var_dump($sql);


	}else if($type==3) //删除
	{
		$sql="insert into contract_payment_plan_change(contract_change_id,contract_id,type,payment_plan_id,add_time,update_time)
		values($changeId,$contract_id,$type,$returnPlanId,$nowtime,$nowtime)";

		// var_dump($sql);
	}
	// var_dump($sql);
	$mysqli->query($sql);

	$recordOfReturnPlanId = mysqli_insert_id($mysqli);

	return $recordOfReturnPlanId;
}
//插入到账Log
function updateReturnLog($contract_id,$recordChangeId,$refundMoney,$changeDate,$number,$paymentMethodId)
{
	global $mysqli,$nowtime,$companyId,$userId,$change_type;

	if($refundMoney!=0 && $change_type=='1')
	{
		$sql = "insert into verification_contract(company_id,caozuoren_id,contract_id,returning_money,returning_time,arrival_amount,add_time,update_time)
			values($companyId,$userId,$contract_id,".-$refundMoney.",".$changeDate.",".-$refundMoney.",$nowtime,$nowtime)";
	}

	$mysqli->query($sql);

	$recordChangeId = mysqli_insert_id($mysqli);

	return $recordChangeId;
}
//插入到账
function updatePlanRecord($contract_id,$logId,$recordChangeId,$refundMoney,$changeDate,$number,$paymentMethodId)
{
	global $mysqli,$nowtime,$companyId,$userId,$change_type;

	if($refundMoney!=0 && $change_type=='1')
	{
		$sql = "insert into verification_paymentplan(company_id,caozuoren_id,contract_id,vercon_id,returning_money,arrival_amount,returning_time,add_time,update_time)
		values($companyId,$userId,$contract_id,$logId,".-$refundMoney.",".-$refundMoney.",".$changeDate.",$nowtime,$nowtime)";
	}


	$mysqli->query($sql);

	$recordChangeId = mysqli_insert_id($mysqli);

	return $recordChangeId;
}

function response($codeNumber,$msg,$data){
	$response['code'] = $codeNumber;
	$response['msg'] = $msg;
	$response['data'] = count($data)>0?$data:array();
	echo json_encode($response,JSON_UNESCAPED_SLASHES);
	exit;
}

?>
