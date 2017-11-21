<?php
require_once (__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");

$userInfo = $GLOBALS['userinfo'];

$user_id = $userInfo['id'];

if ($user_id == '')
	EchoJsonData(1, 'userId不能为空!');

$company_id = $userInfo['company_id'];

$now_time = time();

//$_POST = array(
//	'change_id'=>397,
//	'send_userid'=>1,
//	'custom_id'=>1,
//	'contract_id'=>1,
//	'change_type'=>2,
//	'refund_reason'=>'3213',
//	'change_money'=>30,
//	'change_date'=>'2017-08-16',
//	'refund_money'=>'30',
//	'biangeng_eachMoney'=>30,
//	'maturity_dates'=>'2018-02-09',
//	'remark'=>'32432122',
//	'oldArr'=>'[]',
//	'planData'=>'[{"plan_date":"2017-08-17","plan_money":"1000.00","plan_remark":null,"plan_type":"1","planed_money":"1000.00","id":"32","plan_detail":[{"returning_money":"1000.00","returning_time":"2017-08-18"}]},{"plan_date":"2017-09-17","plan_money":"1000.00","plan_remark":null,"plan_type":"1","planed_money":690,"id":"33","plan_detail":[{"returning_money":"1000.00","returning_time":"2017-08-18"}]},{"plan_date":"2017-10-17","plan_money":"2000","plan_remark":null,"plan_type":"1","planed_money":"0.00","id":"34","plan_detail":[{"returning_money":"830.00","returning_time":"2017-08-18"}]},{"plan_date":"2017-11-17","plan_money":"2000","plan_remark":null,"plan_type":"1","planed_money":"0.00","id":"35","plan_detail":[]},{"plan_date":"2017-12-17","plan_detail":[],"plan_money":"2000","plan_remark":"","plan_type":"","planed_money":"0.00"}]'
//);

//变更Id
$change_id = I('post.change_id', 'i', '', true);

if ($change_id == '')
	EchoJsonData(2, '变更单Id不能为空!');
//发送给哪个财务id
$send_userid = I('post.send_userid', 'i', 0, true);

if ($send_userid == 0)
	EchoJsonData(3, '发送财务不为空!');
//客户名称
$custom_id = I('post.custom_id', 'i', 'NULL', true);
//合同Id
$contract_id = Mysql::run_select("select contract_id from contract_change where id=$change_id and company_id=$company_id")[0]['contract_id'];

//变更业务类型
$change_type = I('post.change_type', 'i', 'NULL', true);

if ($change_type == 'NULL')
	EchoJsonData(2, '变更业务类型不能为空!');
$contract_type = I('post.contract_type','i',0);

//原因
$change_reason = I('post.refund_reason', 's', '', true);

if ($change_reason == '')
	EchoJsonData(3, '变更原因不能为空!');

//变更金额
$change_money = I('post.change_money', 'f', '0.00', true);
//日期
$change_date = I('post.change_date', 's', '');
//退款金额
$refund_money = I('post.refund_money', 'f', 0);

//每期金额
$each_money = I('post.biangeng_eachMoney', 'f', '0.00', true);
//到期时间
$maturity_date = I('post.maturity_dates', 's', '', true);
//备注
$remark = I('post.remark', 's', '', true);

$message = I('post.message', 's', '', true);
//回款计划
$res_new = !empty($_POST['planData']) ? json_decode($_POST['planData'], true) : array();



//所有的图片
$old_file = !empty($_POST['oldArr']) ? json_decode($_POST['oldArr'], true) : array();
//查询图片
$searchFilesSql = "select id from files where company_id=$company_id and relation_id=$change_id and relation_type=3
and delete_time is null";
$files = Mysql::run_select($searchFilesSql);

$old_id = array();
foreach ($old_file as $k => $v) {
	$old_id[] = $v['id'];
}

foreach ($files as $k => $v) {
	if (!in_array($v['id'], $old_id)) {
		deleteFiles($v['id']);
	}
}

$Change = UpdateRecordChange($custom_id, $contract_id, $change_money, $change_date, $change_reason, $change_type, $refund_money, $remark, $change_id, $each_money, $maturity_date,$contract_type);

$sql = "insert into news (company_id,send_userid,accept_userid,type,message,state,style,relation_id,add_time,update_time)
			values($company_id,$user_id,$send_userid,1,'$message',0,6,$change_id,$now_time,$now_time)";
$res_new_id = Mysql::run_insert($sql);

$res_old_sql = "select id,change_plan_money,changed_plan_money,change_plan_type,change_plan_date,change_plan_remark from contract_payment_plan_change where
				contract_id=$contract_id and contract_change_id=$change_id and delete_time is null and type<>3";

$res_old = Mysql::run_select($res_old_sql);

search_diff($res_old, $res_new);

if ($_FILES) {
	foreach ($_FILES as $k => $v) {
		$filesId = insertFiles($v['name'], $v['type'], $v['tmp_name'], $v['error'], $v['size']);
	}
}

if ($Change)
	EchoJsonData(0, '成功!');
else
	EchoJsonData(3, '失败');

//更新contract_change表插数据
function UpdateRecordChange($customId, $contract_id, $changeMoney, $changeDate, $changeReason, $changeType, $refundMoney, $remark, $change_id, $eachMoney, $maturityDate,$contract_type) {
	global $now_time, $company_id, $user_id;

	if ($changeType == 1) {
		//合同金额变更
		$sql = "update contract_change set change_type=$changeType,change_reason='$changeReason',change_date='$changeDate',change_money=$changeMoney,each_money=$eachMoney,maturity_date=$maturityDate,update_time=$now_time,remark='$remark' where id=$change_id";
	} else if ($changeType == 2) {
		//合同金额变更和退款
		if($contract_type==2){
			$sql = "update contract_change set change_type=$changeType,change_reason='$changeReason',change_date='$changeDate',change_money=$changeMoney,refund_money=$refundMoney,each_money=$eachMoney,maturity_date='$maturityDate',update_time=$now_time,remark='$remark' where id=$change_id";
			
		}else{
			$sql = "update contract_change set change_type=$changeType,change_reason='$changeReason',change_date='$changeDate',change_money=$changeMoney,refund_money=$refundMoney,update_time=$now_time,remark='$remark' where id=$change_id";
		}


//		echo $sql;
	} else if ($changeType == 3) {
		//仅退款
		$sql = "update contract_change set change_type=$changeType,change_reason='$changeReason',change_date='$changeDate',change_money=$changeMoney,each_money=$eachMoney,maturity_date='$maturityDate',update_time=$now_time,remark='$remark' where id=$change_id";
	}

	$fetchRow1 = Mysql::run_alter($sql);

	return $fetchRow1;
}

function insertFiles($fileName, $fileType, $fileTmpName, $fileError, $fileSize) {
	global $custom_id, $company_id, $user_id, $change_id, $now_time;

	$root = dirname(dirname(dirname(__FILE__)));

	$path = "/upload/change/" . date("Y") . "/" . date("m") . "/";

	$dir = $root . $path;

	if (!file_exists($dir)) {
		if (!make_dir($dir)) {
			/* 创建目录失败 */
		}
	}

	$old_name = substr($fileName, 0, strrpos($fileName, '.'));

	$img_name = unique_name($dir);

	$ext = "." . substr($fileType, strrpos($fileType, '/') + 1);

	$filename = $dir . $img_name . $ext;

	$res = move_uploaded_file($fileTmpName, $filename);

	if ($res) {
		$finfo = finfo_open(FILEINFO_MIME_TYPE);

		$mimetype = finfo_file($finfo, $filename);

		finfo_close($finfo);

		$src = $path . $img_name . $ext;

		$t_filesize = filesize($filename);

		$sql = "insert into files(company_id,custom_id,relation_id,relation_type,old_name,src,ext,mime,filesize,add_time,add_userid,update_time)
			values($company_id,$custom_id,$change_id,3,'" . $old_name . "','" . $src . "','" . $ext . "','" . $mimetype . "','" . $fileSize . "'," . $nowtime . ",$user_id," . $now_time . ")";

		$filesId = Mysql::run_insert($sql);
	}

	return $filesId;
}

function deleteFiles($fileId) {
	global $user_id, $now_time;

	$sql = "update files set delete_time=$now_time,delete_userid=$user_id where id=$fileId";
	$res = Mysql::run_alter($sql);
	return $res;
}

function search_diff($res_old, $res_new) {
	global $change_id,$contract_id,$now_time,$user_id;
	//查找编辑过得
	foreach ($res_old as $k => $v) {
		foreach ($res_new as $k1 => $v1) {
			if ($v['id'] == $v1['id']) {
				$sql = "update contract_payment_plan_change set change_plan_money=" . $v1['plan_money'] . ",changed_plan_money=" . $v1['plan_money'] . ",change_plan_type=" . $v1['plan_type'] . ",change_plan_date='".$v1['plan_date'] ."',change_plan_remark='". $v1['plan_remark']."',update_time=$now_time where id=" . $v1['id'];
				$res = Mysql::run_alter($sql);
				unset($res_old[$k]);
			}

		}
	}
	//查找新增的
	foreach ($res_new as $k => $v) {
		if (!$v['id']) {
			$sql = "insert into contract_payment_plan_change(contract_change_id,contract_id,type,change_plan_money,changed_plan_money,change_plan_type,change_plan_date,change_plan_remark,add_time,update_time)
			values($change_id,$contract_id,1," . $v['plan_money'] . "," . $v['planed_money'] . ",'".$v['plan_type']."','".$v['plan_date']."','". $v['plan_remark']."',$now_time,$now_time)";
			$res_id = Mysql::run_insert($sql);
		}
	}
	
//	print_r($res_old);
	//删除的
	foreach ($res_old as $k => $v) {
		$sql = "update contract_payment_plan_change set delete_time=$now_time,cancel_time=$now_time,cancel_id=$user_id where id=".$v['id'];
		$res = Mysql::run_alter($sql);
	}

}
?>
