<?php
//修改联系人
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

if($company_id==0)EchoJsonData(2,'companyId不能为空!');

$is_caiwu = $userinfo['is_caiwu'];

$custom_administrators = $userinfo['custom_administrators'];

$now_time = time();

$_POST = array(
		'id'=>3,
		'linkname'=>'sdf',
		'phone'=>'2123222'
	);

$id = I('post.id','i',0);
if($id<=0) EchoJsonData(2,'联系人id不能为空!');
$linkname = I('post.linkname','s','',TRUE);
if($linkname=='') EchoJsonData(2,'联系人名称不能为空!');
$phone = I('post.phone','s','',TRUE);
if($phone=='') EchoJsonData(2,'联系人号码不为空!');
$email = I('post.email','s','',TRUE);
$depart = I('post.depart','s','',TRUE);
$link_duty = I('post.link_duty','s','',TRUE);
$address = I('post.address','s','',TRUE);
$remark = I('post.remark','s','',TRUE);

if ($custom_administrators!=1) {
	$sql1 = "select * from linkman where id=$id and company_id=$company_id and delete_time is null";
	$res_user = Mysql::run_select($sql1)[0]['user_id'];
	if($res_user!=$user_id) EchoJsonData(4,'联系人不是自己建的!');
}

$sql = "update linkman set update_time=$now_time,linkname='".$linkname."',phone='".$phone."',email='".$email."',depart='".$depart."',link_duty='".$link_duty."',address='".$address."',remark='".$remark."' where id=$id and company_id=$company_id and delete_time is null";

// echo $sql;exit;
$res = Mysql::run_alter($sql);

if($res)
	EchoJsonData(0,'修改成功!');
else
	EchoJsonData(4,'失败!');













?>