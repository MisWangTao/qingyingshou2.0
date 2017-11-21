<?php
//修改回款方式
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0) EchoJsonData(1,'userId不能为空!');

$now_time = time();

$id = I('post.id','i',0);  //获取收款方式的id
if($id==0)EchoJsonData(1,'回款id不为空!');
$payment_method = I('post.payment','s','',true);
if($payment_method=='')EchoJsonData(1,'回款方式不为空!');
$value = I('post.value','s','',true);
// if($value=='')$value='321';
$edit_sql = "update payment_method set payment_method='".$payment_method."',`values`='".$value."',update_time=$now_time,update_userid=$user_id where id=$id and company_id=$company_id";

$res = Mysql::run_alter($edit_sql);

if($res)
  EchoJsonData(0,'回款方式修改成功!',$res);
else
  EchoJsonData(-1,'回款方式修改失败!');


?>