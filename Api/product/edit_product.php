<?php
//产品信息修改
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$now_time = time();
// print_r($userinfo);exit;
// $sql = "select * from company_user where id=$userId";

// $res = Mysql::run_select($sql);

// $companyId = $res[0]['company_id'];

$company_id = $userinfo['company_id'];

$_POST = array(
	'id'=>1,
	'product_name'=>'过',
	'price'=>'20',
	'number'=>20
);

$id = I('post.id','i',0);
if($id==0)EchoJsonData(1,'产品id不能小于等于0!');
$product_name = I('post.product_name','s','',true);
if($product_name=='') EchoJsonData(1,'产品名称不为空!');
$price = I('post.price','f',0);
if($price<=0) EchoJsonData(1,'价格能小于等于0!');
$number = I('post.number','i',0);
if($number<=0) EchoJsonData(1,'数量不能小于等于0!');

$sql = "update product_info set product_name='".$product_name."',price=$price,number=$number,update_time=$now_time where id=$id and company_id=$company_id";

$res = Mysql::run_alter($sql);

if($res)
	EchoJsonData(0,'产品信息修改成功!');
else
	EchoJsonData(1,'修改失败!');





?>