<?php
//新增产品接口
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

$is_caiwu = $userinfo['is_caiwu'];

$_POST = array(
		'project_name'=>'果皮',
		'unit'=>'台',
		'number'=>'100',
		'price'=>'10',
		'unit'=>2
	);


$project_name = I('post.project_name','s','',true);  //产品名称

if($project_name=='')EchoJsonData(1,'产品名称不能为空!');

$unit = I('post.unit','i',0); //计价单位

$number = I('post.number','i',0);   //数量
if($number<=0) EchoJsonData(1,'数量不小于0!');
$price = I('post.price','f',0);  //单价
if($price<=0) EchoJsonData(1,'单价不小于0!');


$sql = "insert into product_info (company_id,user_id,product_name,price,unit,number,add_time,update_time)
		values($company_id,$user_id,'".$project_name."',$price,$unit,$number,$now_time,$now_time)";
// var_dump($sql);exit;
$res = Mysql::run_insert($sql);

if($res)
	EchoJsonData(0,'新增产品信息成功!',$res);
else
	EchoJsonData(1,'失败!');

?>