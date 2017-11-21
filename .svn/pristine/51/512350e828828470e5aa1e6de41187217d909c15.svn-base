<?php
//合同添加接口
require_once(__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");
require_once ("../../common/config/db.cof.php");

$userInfo = $GLOBALS['userinfo'];

$userId = $userInfo['id'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

$companyId = $userInfo['company_id'];

$contractName = I('post.contract_name','s','',true);

if(!$contractName)EchoJsonData(2,'合同名称不能为空!');

$contractNumber = I('post.contract_number','s','',true);

$customId = I('post.custom_id','i','NULL',true);

if(!$customId)EchoJsonData(3,'客户名称不能为空!');

$labelId = I('post.label_id','s','',true);
//合同类型1:一般合同,2:周期合同,3:框架合同..
$contractType = I('post.contract_type','i','NULL',true);
//合同日期
$contractDate = I('post.contract_date','s','',true);

if(!$contractDate)EchoJsonData(4,'合同日期不能为空!');

//到期日期
$maturityDate = I('post.maturity_date','s','',true);
//合同备注
$remark = I('post.remark','s','',true);
//货币id
$currencyId = I('post.currency_id','i','NULL',true);

$linkMan = I('post.linkman','s','',true);

$tel = I('post.tel','s','',true);
//跟进人
$followupId = I('post.followup','i',NULL,true);
//部门id
$departId = I('post.depart_id','i',NULL,true);

if(!$followupId)EchoJsonData(5,'跟进人不能为空!');

if(!$departId)EchoJsonData(6,'部门id不能为空!');

/*---------------产品信息---------------*/
$productObj = !empty($_POST['product_obj'])?json_decode($_POST['product_obj'],true):'';

$nowtime = time();

$mysqli =new mysqli($DB_IP,$DB_Username,$DB_Password,$DB_Name);

mysqli_query($mysqli ,"set names utf8");

$mysqli->autocommit(false);
// var_dump($_FILES);
// exit;
if($contractType=='1')
{
	//合同金额
	$contractMoney = I('post.contract_money','f',NULL,true);

	$sql = "insert into contract_list(contract_name,contract_number,custom_id,company_id,label_id,linkman,tel,contract_type,contract_date,maturity_date,contract_money,currency_id,remark,user_id,followup_id,followup_depart,add_time,update_time)
	values('".$contractName."','".$contractNumber."',$customId,$companyId,'".$labelId."','".$linkMan."','".$tel."',$contractType,'".$contractDate."','".$maturityDate."',$contractMoney,$currencyId,'".$remark."',$userId,$followupId,$departId,$nowtime,$nowtime)";

	$mysqli->query($sql);

	$contractId = mysqli_insert_id($mysqli);

	if($contractId<=0)$mysqli->rollback();

}else if($contractType=='2')
{

	//回款周期1:每月,2:每季度,3:每年
	$paymentType = I('post.payment_cycle','i',NULL,true);
	//首次收款日期
	$firstPayment = I('post.firstPayment','s',NULL,true);
	//每期金额
	$each_money = I('post.each_money','i',NULL,true);
	//计算周期
	$dates = HandleDate($paymentType,$firstPayment,$maturityDate);
	// var_dump($dates);
	//周期数
	$cycle = count($dates);
	//回款金额
	$contractMoney = $each_money * $cycle ;
	//是否提醒
	$is_reminder = I('post.reminder','i',NULL,true);
	//提前几天提醒
	$advance_remind = I('post.advance_remind','i','',true);

	$sql = "insert into contract_list(contract_name,contract_number,custom_id,company_id,label_id,linkman,tel,contract_type,contract_date,maturity_date,payment_cycle,first_date_payment,each_money,cycle,expiration_reminder,advance_remind,contract_money,currency_id,remark,user_id,followup_id,followup_depart,add_time,update_time,update_userid)
	values('".$contractName."','".$contractNumber."',$customId,$companyId,'".$labelId."','".$linkMan."','".$tel."',$contractType,'".$contractDate."','".$maturityDate."',$paymentType,'".$firstPayment."',$each_money,$cycle,$is_reminder,'".$advance_remind."',$contractMoney,$currencyId,'".$remark."',$userId,".$followupId.",$departId,$nowtime,$nowtime,$userId)";
	// var_dump($sql);
	$mysqli->query($sql);

	$contractId = mysqli_insert_id($mysqli);
	// var_dump($contractId);
	if($contractId<=0){

		$mysqli->rollback();

	}else
	{
		foreach($dates as $k=>$v)
		{
			$sql1 = "insert into contract_payment_plans(contract_id,company_id,plan_date,plan_money,plan_type,add_time,update_time)
				 values($contractId,$companyId,'".$v."',$each_money,1,$nowtime,$nowtime)"; 
			$mysqli->query($sql1);

			$paymentId = mysqli_insert_id($mysqli);
		}
		if($paymentId<=0)$mysqli->rollback();

	}
}else if($contractType=='3')
{
	//预收款
	$advanceMoney = I('post.advance_money','f',NULL,true);
	//
	$payment_type = I('post.payment_type','i',NULL,true);
	//月
	$eachMonth = I('post.each_month','i',NULL,true);
	//日
	$eachDay = I('post.each_day'.'i',NULL,true);

	$sql ="insert into contract_list(contract_name,contract_number,custom_id,company_id,label_id,linkman,tel,contract_type,contract_date,maturity_date,payment_cycle,remark,payment_type,each_month,each_day,user_id,followup_id,followup_depart,add_time,update_time)
	values('".$contractName."','".$contractNumber."',$customId,$companyId,'".$labelId."','".$linkMan."','".$tel."',$contractType,'".$contractDate."','".$maturityDate."',$payment_type,'".$remark."',$payment_type,$eachMonth,$eachDay,$userId,".$followupId.",".$departId.",$nowtime,$nowtime)";

	$mysqli->query($sql);

	$contractId = mysqli_insert_id($mysqli);

	if($contractId<=0)$mysqli->rollback();
}
//插入附件
if( $contractId>0 && count($_FILES)>0)
{	
	foreach($_FILES as $k=>$v)
	{
		uploadFile($v['name'],$v['type'],$v['tmp_name'],$v['error'],$v['size']);
	}
}

if($contractId>0)
{

	$desc = addslashes(json_encode($contractName,JSON_UNESCAPED_SLASHES));

	$sql2 = "insert into timeaxis(company_id,contract_id,des,user_id,type,add_time,update_time)
			values($companyId,$contractId,'".$desc."',$userId,1,$nowtime,$nowtime)";
	// var_dump($sql2);		
	$mysqli->query($sql2);

	$timeaxisId = mysqli_insert_id($mysqli);
}
/*-------------查询最新的合同列表----------------*/
$is_caiwu = $userinfo['is_caiwu'];

$where = '';

if($is_caiwu!=1){

  $where = " and followup_id=$userId ";
}

$sql = "select contract_list.`id`,
       contract_list.`contract_name`,
      b.`custom_name` ,
       contract_list.`contract_money`,
       contract_list.`contract_date`,
       contract_list.`contract_type`,
     contract_list.`label_id`,
     contracted_money as verification_money,
     ifnull((select SUM(arrival_amount) from verification_contract where contract_list.`id`=verification_contract.contract_id and verification_contract.delete_time is null),0) as arrival_amount
  from contract_list
  left join custom_list as b on contract_list.custom_id= b .id
   and b.delete_time is null
 where contract_list.company_id=$companyId
   and contract_list.delete_time is null".$where."
   order by contract_list.update_time desc";

$res = Mysql::run_select($sql);
$result = array();

  foreach($res as $k=>$v)
  {
    $labels_name = array();
		$result['htje'] += $v['contract_money'];
		$result['hxje'] += $v['verification_money'];
		$result['arrival_amount'] += $v['arrival_amount'];
    if($v['label_id']!='')
    {
       $sql = "select label_name from contract_label where id in (".$v['label_id'].")";
       // var_dump($sql);
      $rs = Mysql::run_select($sql);

      $labels_name = $rs;

      $res[$k]['label_name'] = $labels_name;

    }else{
      $res[$k]['label_name'] = array();
    }
  }
$result['ysye'] = $result['htje'] - $result['hxje']; 
/*-------------查询最新的合同列表----------------*/
$contract_list = count($res)>0?$res:array();

$response = array();

if( !$mysqli->errno && $contractId>0 && $timeaxisId>0)
{	
	$mysqli->commit();

	$response['code'] = 0;
	$response['msg']   = '添加成功!';
	$response['data']  = $contract_list;
	$response['result']  = $result;
	$response['contract_id']  = $contractId;

}else{

	$mysqli->rollback();

	$response['code'] = 0;
	$response['msg']   = '添加失败!';
	$response['data']  = array();

}
echo json_encode($response,JSON_UNESCAPED_SLASHES);

$mysqli->autocommit(true); //设置为非自动提交——事务处理

$mysqli->close();


function uploadFile($fileName,$fileType,$fileTmpName,$fileError,$fileSize)
{
	global $mysqli,$customId,$companyId,$userId,$contractId,$nowtime;

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

		$mysqli->query($sql);

		$filesId = mysqli_insert_id($mysqli);
	}
	return $filesId;
}
?>