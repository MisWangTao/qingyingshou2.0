<?php
//添加普通回款计划的接口
require_once(__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

$companyId = $userinfo['company_id'];

$contractId = I('post.contract_id','i','',true);

if($userId=='')EchoJsonData(1,'userId不能为空!');

if($contractId=='')EchoJsonData(2,'合同单id不能为空!');

$sql = "select * from contract_list where id=$contractId";

$res = Mysql::run_select($sql);

if($res[0]['contract_type']==2)EchoJsonData(3,'合同类型有误!');
//合同金额
$contractMoney = $res[0]['contract_money'];
//合同时间
$contractDate = $res[0]['contract_date'];

//到期时间
$maturityDate = $res[0]['maturity_date'];

$customId = $res[0]['custom_id'];

$returnPlan = !empty($_POST['returnPlan'])?json_decode($_POST['returnPlan'],true):'';

$currencyId = I('post.currentcy_id','i','NULL',true);

$expiration_reminder = I('post.expiration_reminder','i',0,true);

$advance_remind = I('post.advance_remind','i','NULL',true);

$nowtime= time();

$sumMoney = "";
//普通合同

if($res[0]['contract_type']==1)
{	
	foreach($returnPlan as $k=>$v)
	{	

		$sumMoney += $v['plan_money'];

		if($sumMoney>$contractMoney)EchoJsonData(4,'回款计划金额大于合同金额');

		if($v['plan_date']=='')EchoJsonData(5,'计划日期不能为空!');
		
		if($v['plan_money']=='')EchoJsonData(6,'回款金额不能为空!');

		if($v['plan_type']=='')EchoJsonData(7,'计划类型不能为空!');
		
		if(strtotime($v['plan_date']) < strtotime($contractDate))EchoJsonData(8,'计划日期不能早于合同日期!');
	
		if($maturityDate && strtotime($v['plan_date']) > strtotime($maturityDate))EchoJsonData(9,'计划日期不能晚于到期日期!');
		
		$sql = "insert into contract_payment_plans(contract_id,company_id,plan_date,plan_money,plan_type,plan_remark,expiration_reminder,advance_remind,add_time,update_time)
			values($contractId,$companyId,'".$v['plan_date']."',".$v['plan_money'].",'".$v['plan_type']."','".$v['plan_remark']."','".$expiration_reminder."','".$advance_remind."',$nowtime,$nowtime)";

		$res = Mysql::run_insert($sql);	
		
	}

	if($res>0)	
	{
		$sql1 = "update contract_list set expiration_reminder='".$expiration_reminder."',advance_remind='".$advance_remind."' where id=".$contractId;
		// var_dump($sql1);
		$res1 = Mysql::run_alter($sql1);
	}
}else if($res[0]['contract_type']==3) //框架合同
{
	if($returnPlan[0]['plan_money']=='')EchoJsonData(6,'回款金额不能为空!');
	if($returnPlan[0]['plan_date']=='')EchoJsonData(5,'计划日期不能为空!');
	
	$sql = "insert into contract_payment_plans(contract_id,company_id,plan_date,plan_money,plan_remark,expiration_reminder,advance_remind,add_time,update_time)
			values($contractId,$companyId,'".$returnPlan[0]['plan_date']."',".$returnPlan[0]['plan_money'].",'".$returnPlan[0]['plan_remark']."','".$expiration_reminder."','".$advance_remind."',$nowtime,$nowtime)";
	
	$res = Mysql::run_insert($sql);	

	if($res>0)
	{
		$sql1 = "update contract_list set contract_money=contract_money+".$returnPlan[0]['plan_money'].",expiration_reminder=".$expiration_reminder.",advance_remind=".$advance_remind.",currency_id=".$currencyId."
		     where id=".$contractId;
		     
		$res1 = Mysql::run_alter($sql1);      
	}	
}

if( ($res>0 || ($res1 && $res1>0)) && count($_FILES)>0)
{
	foreach($_FILES as $k=>$v)
	{
		uploadFile($v['name'],$v['type'],$v['tmp_name'],$v['error'],$v['size']);
	}
}



WriteOffContract($contractId);
if($res>0 || ($res>0 && $res1!==false) )
	EchoJsonData(0,'添加回款计划成功!');
else 
	EchoJsonData(10,'添加回款计划失败!');


function uploadFile($fileName,$fileType,$fileTmpName,$fileError,$fileSize)
{
	global $customId,$companyId,$userId,$contractId,$nowtime;

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
			values($companyId,$customId,$contractId,1,'".$old_name."','".$src."','".$ext."','".$mimetype."','".$fileSize."',".$nowtime.",$userId,".$nowtime.")";

	    $filesId = Mysql::run_insert($sql);
	}



	return $filesId;
}
?>