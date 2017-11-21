<?php
//添加合同变更信息
require_once(__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");
require_once ("../../common/config/db.cof.php");
require_once ("../../common/function/third.fun.php");
$userInfo = $GLOBALS['userinfo'];

$userId  = $userInfo['id'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

$companyId = $userInfo['company_id'];

$nowtime = time();

$nowdate = date('Y-m-d',time());

//
//$_POST = array(
//	'send_userid'=>6071,
//	'custom_id'=>2,
//	'contract_id'=>1,
//	'change_type'=>2,
//	'refund_reason'=>'321',
//	'change_money'=>1,
//	'change_date'=>'2017-08-07',
//	'refund_money'=>50,
//	'contract_type'=>2,
//	'biangeng_eachMoney'=>120,
//	'maturity_dates'=>'2018-02-09',
//	'returnPlan'=>'[{"plan_date":"2017-08-17","plan_money":"1000.00","plan_remark":null,"plan_type":"1","planed_money":"1000.00","id":"32","plan_detail":[{"returning_money":"1000.00","returning_time":"2017-08-18"}]},{"plan_date":"2017-09-17","plan_money":"1000.00","plan_remark":null,"plan_type":"1","planed_money":690,"id":"33","plan_detail":[{"returning_money":"1000.00","returning_time":"2017-08-18"}]},{"plan_date":"2017-10-17","plan_money":"2000","plan_remark":null,"plan_type":"1","planed_money":"0.00","id":"34","plan_detail":[{"returning_money":"830.00","returning_time":"2017-08-18"}]},{"plan_date":"2017-11-17","plan_money":"2000","plan_remark":null,"plan_type":"1","planed_money":"0.00","id":"35","plan_detail":[]},{"plan_date":"2017-12-17","plan_detail":[],"plan_money":"2000","plan_remark":"","plan_type":"","planed_money":"0.00"}]'
//);


//发送给哪个财务id
$send_userid = I('post.send_userid','i',0);
if($send_userid<=0) EchoJsonData(1,'发送财务不为空!');
//客户名称
//$customId = I('post.custom_id','i','NULL',true);
//合同Id
$contract_id = I('post.contract_id','i','NULL',true);


//[{"plan_date":"2017-08-17","plan_money":"100.00","plan_remark":"逆魔","plan_type":"1","planed_money":"100.00","id":"11","plan_detail":[{"returning_money":"100.00","returning_time":"2017-08-19"}]},{"plan_date":"2017-08-17","plan_money":"60","plan_remark":"逆魔","plan_type":"1","planed_money":60,"id":"12","plan_detail":[{"returning_money":"80.00","returning_time":"2017-08-19"}]},{"plan_date":"2017-08-18","plan_money":"20","plan_remark":"","plan_type":"2","planed_money":"0.00","id":"13","plan_detail":[]}]



//[{"plan_date":"2017-08-08","plan_money":"100.00","plan_remark":null,"plan_type":1,"planed_money":"100.00","id":"1","plan_detail":[{"returning_money":"100.00","returning_time":"2017-08-15"}]},{"plan_date":"2017-09-08","plan_money":"120","plan_remark":null,"plan_type":1,"planed_money":"0.00","id":"2","plan_detail":[]},{"plan_date":"2017-10-08","plan_money":"120","plan_remark":null,"plan_type":1,"planed_money":"0.00","id":"3","plan_detail":[]}]



//[{"plan_date":"2017-08-08","plan_money":"100.00","plan_remark":null,"plan_type":null,"planed_money":"100","id":"1","plan_detail":[{"returning_money":"100.00","returning_time":"2017-08-15"}]},{"plan_date":"2017-09-08","plan_money":"100","plan_remark":null,"plan_type":null,"planed_money":"50.00","id":"2","plan_detail":[]},{"plan_date":"2017-10-08","plan_money":"10","plan_remark":null,"plan_type":null,"planed_money":"0.00","id":"3","plan_detail":[]},{"plan_date":"2017-11-08","plan_money":"10","plan_remark":null,"plan_type":null,"planed_money":"0.00","id":"4","plan_detail":[]},{"plan_date":"2017-12-08","plan_money":"10","plan_remark":null,"plan_type":null,"planed_money":"0.00","id":"5","plan_detail":[]},{"plan_date":"2018-01-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"},{"plan_date":"2018-02-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"},{"plan_date":"2018-03-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"},{"plan_date":"2018-04-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"},{"plan_date":"2018-05-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"},{"plan_date":"2018-06-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"},{"plan_date":"2018-07-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"},{"plan_date":"2018-08-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"},{"plan_date":"2018-09-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"},{"plan_date":"2018-10-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"},{"plan_date":"2018-11-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"},{"plan_date":"2018-12-08","plan_detail":[],"plan_money":"10","plan_remark":"","plan_type":"","planed_money":"0.00"}]




//变更业务类型
$change_type = I('post.change_type','i','NULL',true);

if($change_type=='NULL')EchoJsonData(2,'变更业务类型不能为空!');
//原因
$change_reason = I('post.refund_reason','s','',true);

//if($change_reason=='')EchoJsonData(3,'变更原因不能为空!');
//变更金额
$change_money = I('post.change_money','f','0.00',true);
//日期
//$change_date = !empty($_POST['refund_date']) ? request_clean($_POST['refund_date']):'';
$change_date = I('post.change_date','s','');
//退款金额
$refund_money = I('post.refund_money','f',0);
//每期金额
$each_money = I('post.biangeng_eachMoney','f',0);
//到期时间
$maturity_date = I('post.maturity_dates','s','');
//合同类型
$contract_type = I('post.contract_type','i',0);

if($contract_type<=0)EchoJsonData(3,'合同类型不为空!');



$returnPlan = !empty($_POST['planData'])?json_decode($_POST['planData'],true):array();


//foreach($returnPlan as $k=>$v){
//	unset($returnPlan[$k]['plan_detail']);
//}
//print_r($returnPlan);

//查询业务金额
$sql = "select * from contract_list where id=$contract_id";

$res = Mysql::run_select($sql);

$yewuje = $res[0]['contract_money'];    //合同业务金额

$first_date_payment = $res[0]['first_date_payment'];

//回款周期 1是每月 2是每季度 3是每年
$payment_cycle = $res[0]['payment_cycle'];

$customId = $res[0]['custom_id'];

// //防止多次提交
// $sqll ="select * from contract_change where custom_id=$customId and company_id=$companyId and contract_id=$contract_id and user_id=$userId order by
// add_time desc";

// $ress = Mysql::run_select($sqll);

// //上次添加时间戳
// $addTime = $ress[0]['add_time']?$ress[0]['add_time']:0;


//查询到账
$sql = "select ifnull(sum(returning_money),0) as daozhang,ifnull(sum(arrival_amount),0) as daozhang1 from verification_contract where contract_id=$contract_id and delete_time is null";

$res = Mysql::run_select($sql);

$daozhang = $res[0]['daozhang'];

$daozhang1 = $res[0]['daozhang1'];

// if(($nowtime - $addTime) > 2)
// {
	//合同变更表的id
	$recordChangeId = insertRecordChange($customId,$contract_id,$change_money,$change_date,$change_reason,$change_type,$refund_money,$remark,$each_money,$maturity_date);

	$insert_sql = "insert into news(company_id,send_userid,accept_userid,type,state,style,relation_id,add_time,update_time)
					values($companyId,$userId,$send_userid,1,0,6,$recordChangeId,$nowtime,$nowtime)";

	$res_new = Mysql::run_insert($insert_sql);


	for($i=0;$i<count($_FILES['file']['name']);$i++)
	{
		if($_FILES['file']['name'][$i]!='')
		{
			$filesId = insertRecordChangeFiles($_FILES['file']['name'][$i],$_FILES['file']['type'][$i],$_FILES['file']['tmp_name'][$i],$_FILES['file']['error'][$i],$_FILES['file']['size'][$i],$customId,$recordChangeId);

		}
	}

$sql_plan = "select id,plan_money,planed_money,plan_type,plan_date from contract_payment_plans where contract_id=$contract_id and delete_time is null";

$res_plan = Mysql::run_select($sql_plan);
//print_r($res_plan);
//print_r($returnPlan);exit;

if(count($returnPlan)<=0){
	$returnPlan = $res_plan;
	foreach($returnPlan as $k=>$v){
		if($refund_money<=0) break;
		if($refund_money>=$v['planed_money']){
			$refund_money = $refund_money-$v['planed_money'];
			$returnPlan[$k]['planed_money'] =  0;
		}else{
			$returnPlan[$k]['planed_money'] = $returnPlan[$k]['planed_money'] - $refund_money;
			$refund_money = 0;
		}
		
	}
}
//print_r($returnPlan);exit;
$arr = search_diff($res_plan, $returnPlan);
//print_r($arr);exit;
foreach($arr as $k=>$v){
		if($v['payment_plan_date']=='null'){


			$sql = "insert into contract_payment_plan_change (contract_change_id,contract_id,type,payment_plan_id,payment_plan_money,paymented_plan_money,payment_plan_type,payment_plan_date,payment_plan_remark,change_plan_money,changed_plan_money,change_plan_type,change_plan_date,change_plan_remark,add_time,update_time)
			values ($recordChangeId,$contract_id,".$v['type'].",".$v['payment_plan_id'].",".$v['payment_plan_money'].",".$v['paymented_plan_money'].",".$v['payment_plan_type'].",".$v['payment_plan_date'].",'".$v['payment_plan_remark']."',".$v['change_plan_money'].",".$v['changed_plan_money'].",'".$v['change_plan_type']."','".$v['change_plan_date']."','".$v['change_plan_remark']."',$nowtime,$nowtime)";
		}else if($v['change_plan_date']=='null'){
			$sql = "insert into contract_payment_plan_change (contract_change_id,contract_id,type,payment_plan_id,payment_plan_money,paymented_plan_money,payment_plan_type,payment_plan_date,payment_plan_remark,change_plan_money,changed_plan_money,change_plan_type,change_plan_date,change_plan_remark,add_time,update_time)
			values ($recordChangeId,$contract_id,".$v['type'].",".$v['payment_plan_id'].",".$v['payment_plan_money'].",".$v['paymented_plan_money'].",'".$v['payment_plan_type']."','".$v['payment_plan_date']."','".$v['payment_plan_remark']."',".$v['change_plan_money'].",".$v['changed_plan_money'].",'".$v['change_plan_type']."',".$v['change_plan_date'].",'".$v['change_plan_remark']."',$nowtime,$nowtime)";
		}else{
			$sql = "insert into contract_payment_plan_change (contract_change_id,contract_id,type,payment_plan_id,payment_plan_money,paymented_plan_money,payment_plan_type,payment_plan_date,payment_plan_remark,change_plan_money,changed_plan_money,change_plan_type,change_plan_date,change_plan_remark,add_time,update_time)
			values ($recordChangeId,$contract_id,".$v['type'].",".$v['payment_plan_id'].",".$v['payment_plan_money'].",".$v['paymented_plan_money'].",'".$v['payment_plan_type']."','".$v['payment_plan_date']."','".$v['payment_plan_remark']."',".$v['change_plan_money'].",".$v['changed_plan_money'].",'".$v['change_plan_type']."','".$v['change_plan_date']."','".$v['change_plan_remark']."',$nowtime,$nowtime)";
			 // var_dump($sql);
		}


			 $res = Mysql::run_insert($sql);
		}
if($recordChangeId)
	EchoJsonData(0,'添加成功!');
else
	EchoJsonData(3,'失败!');
// }






//插入record_change表  contract_change表插数据
function insertRecordChange($customId,$contract_id,$changeMoney,$changeDate,$changeReason,$changeType,$refundMoney,$remark,$each_money,$maturity_date)
{
	global $mysqli,$nowtime,$companyId,$userId,$yewuje,$daozhang,$daozhang1,$send_userid;

	if($changeType==1)
	{
		//合同金额变更
		$sql = "insert into contract_change(send_userid,custom_id,company_id,contract_id,user_id,change_money,change_date,change_reason,change_type,remark,original_ywje,original_ysye,original_dz,add_time,update_time,each_money,maturity_date)
			values($send_userid,$customId,$companyId,$contract_id,$userId,$changeMoney,'".$changeDate."','".$changeReason."',$changeType,'".$remark."',$yewuje,($yewuje-$daozhang),$daozhang1,".$nowtime.",".$nowtime.",$each_money,'".$maturity_date."')";
	}else if($changeType==2)
	{
		//合同金额变更和退款
		$sql = "insert into contract_change(send_userid,custom_id,company_id,contract_id,user_id,change_money,change_date,change_reason,change_type,refund_money,remark,original_ywje,original_ysye,original_dz,add_time,update_time,each_money,maturity_date)
			values($send_userid,$customId,$companyId,$contract_id,$userId,$changeMoney,'".$changeDate."','".$changeReason."',$changeType,$refundMoney,'".$remark."',$yewuje,($yewuje-$daozhang),$daozhang1,".$nowtime.",".$nowtime.",$each_money,'".$maturity_date."')";
	}else if($changeType==3){
		//仅退款
		$sql = "insert into contract_change(send_userid,custom_id,company_id,contract_id,user_id,change_date,change_type,refund_money,remark,original_ywje,original_ysye,original_dz,add_time,update_time,each_money,maturity_date)
			values($send_userid,$customId,$companyId,$contract_id,$userId,'".$changeDate."',$changeType,$refundMoney,'".$remark."',$yewuje,($yewuje-$daozhang),$daozhang1,".$nowtime.",".$nowtime.",$each_money,'".$maturity_date."')";
	}

//	$mysqli->query($sql);

	$recordChangeId = Mysql::run_insert($sql);

	return $recordChangeId;
}


//插入files表
function insertRecordChangeFiles($fileName,$fileType,$fileTMPName,$fileError,$fileSize,$customId,$changeId)
{
	global $nowtime,$companyId,$userId;

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

//	    $mysqli->query($sql);

		$filesId = Mysql::run_insert($sql);
	}
	return $filesId;
}


//组合新数组
function search_diff($old_arr,$new_arr){
	$arr = array();
	foreach($new_arr as $k=>$v){
		foreach($old_arr as $k1=>$v1){
			$rs = array();

			if($v1['id']==$v['id']){
				//判断两个数组是否有相同的id  如果都有  就是编辑或相同的
				if($v['plan_money']==$v1['plan_money']&&$v['planed_money']==$v1['planed_money']&&$v['plan_date']==$v1['plan_date']&&$v['id']==$v1['id']){
					//相同的
					$rs['payment_plan_id'] = $v['id'];
					$rs['type'] = 4;
					$rs['payment_plan_money'] = $v1['plan_money'];
					$rs['paymented_plan_money'] = $v1['planed_money'];
					$rs['payment_plan_type'] = $v1['plan_type'];
					$rs['payment_plan_date'] = $v1['plan_date'];
					$rs['change_plan_money'] = $v['plan_money'];
					$rs['changed_plan_money'] = $v['planed_money'];
					$rs['change_plan_type'] = $v['plan_type'];
					$rs['change_plan_date'] = $v['plan_date'];
					$arr[] = $rs;
				}else{
					//编辑的
					$rs['payment_plan_id'] = $v['id'];
					$rs['type'] = 2;
					$rs['payment_plan_money'] = $v1['plan_money'];
					$rs['paymented_plan_money'] = $v1['planed_money'];
					$rs['payment_plan_type'] = $v1['plan_type'];
					$rs['payment_plan_date'] = $v1['plan_date'];

					$rs['change_plan_money'] = $v['plan_money'];
					$rs['changed_plan_money'] = $v['planed_money'];
					$rs['change_plan_type'] = $v['plan_type'];
					$rs['change_plan_date'] = $v['plan_date'];
					$arr[] = $rs;
				}
				unset($old_arr[$k1]);
			}
		}
	}
	//新增的数据
	foreach($new_arr as $k=>$v){
			if($v['id']) continue;
			//新增的
			$rs['payment_plan_id'] = 'null';
			$rs['type'] = 1;

			$rs['payment_plan_money'] =0;
			$rs['paymented_plan_money'] = 0;
			$rs['payment_plan_type'] = 'null';
			$rs['payment_plan_date'] = 'null';

			$rs['change_plan_money'] = $v['plan_money'];
			$rs['changed_plan_money'] = $v['planed_money'];
			$rs['change_plan_type'] = $v['plan_type'];
			$rs['change_plan_date'] = $v['plan_date'];
			$arr[] = $rs;

	}

	//删除的
	if(count($old_arr)>0){
		foreach($old_arr as $k=>$v){
			$rs['payment_plan_id'] = $v['id'];
			$rs['type'] = 3;

			$rs['payment_plan_money'] = $v['plan_money'];
			$rs['paymented_plan_money'] = $v['planed_money'];
			$rs['payment_plan_type'] = $v['plan_type'];
			$rs['payment_plan_date'] = $v['plan_date'];

			$rs['change_plan_money'] = 0;
			$rs['changed_plan_money'] = 0;
			$rs['change_plan_type'] = 	'null';
			$rs['change_plan_date'] = 'null';
			$arr[] = $rs;
		}
	}
	return $arr;

}


?>