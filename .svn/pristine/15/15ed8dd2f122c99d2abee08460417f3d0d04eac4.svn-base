<?php
//新建联系人
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

if($company_id==0)EchoJsonData(2,'companyId不能为空!');

$is_caiwu = $userinfo['is_caiwu'];

$now_time = time();

// $_POST = array(
// 		'custom_id'=>2,
// 		'linkname'=>'小明22',
// 		'phone'=>'13838385438',
// 		'depart'=>'销售',
// 		'email'=>'405833618@qq.com',
// 		'link_duty'=>'职工',
// 		'address'=>'吉祥',
// 		'remark'=>'数量的开发'
// 	);

$custom_id = I('post.custom_id','i',0);
if($custom_id<=0)EchoJsonData(2,'客户id不为空!');

$linkname  = trim(I('post.linkname','s','','true')) ;  //联系人名字
if($linkname=='') EchoJsonData(2,'联系人名称不为空!');

$phone = trim(I('post.phone','s','','true')) ; //联系人电话
if($phone=='') EchoJsonData(2,'联系人电话不为空!');

$depart = trim(I('post.depart','s','','true'));  //联系人部门

$email = trim(I('post.email','s','','true'));   //联系人邮箱

$link_duty = trim(I('post.link_duty','s','','true'));  //联系人职务

$address = trim(I('post.address','s','','true'));  //联系人地址

$remark = trim(I('post.remark','s','','true'));   //联系人说明

$sql_insert = "insert into linkman(company_id,custom_id,linkname,user_id,email,phone,depart,link_duty,address,remark,add_time,update_time)
				values($company_id,$custom_id,'".$linkname."',$user_id,'".$email."','".$phone."','".$depart."','".$link_duty."','".$address."','".$remark."',$now_time,$now_time)";

$insert_id = Mysql::run_insert($sql_insert);

if($insert_id>0)
	EchoJsonData(0,'联系人添加成功!');
else
	EchoJsonData(1,'联系人添加失败!');

?>