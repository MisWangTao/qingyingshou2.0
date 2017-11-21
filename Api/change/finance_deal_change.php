<?php
require_once(__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");


$userInfo = $GLOBALS['userinfo'];

$user_id  = $userInfo['id'];

if($user_id=='')EchoJsonData(1,'userId不能为空!');

$company_id = $userInfo['company_id'];

$now_time = time();
//$_POST = array(
//	'id'=>379,
//	'news_id'=>161,
//	'mes'=>'322'
//);
$is_caiwu = $userInfo['is_caiwu'];

//if($is_caiwu!=1)EchoJsonData(3,'你不是财务!');


$change_id = I('post.id','i',0);
if($change_id==0)EchoJsonData(2,'变更id不为空!');

$new_id = I('post.news_id','i',0);
if($new_id==0)EchoJsonData(2,'消息id不为空!');

$mes = I('post.message','s','',true);

$new_sql = "update news set state=1 where id=$new_id and company_id=$company_id";

$res_new = Mysql::run_alter($new_sql);

$sql_bian_sql = "select * from contract_change where id=$change_id and company_id=$company_id";

$accept_id = Mysql::run_select($sql_bian_sql)[0]['user_id'];

$sql = "update contract_change set change_status=1 where id=$change_id and company_id=$company_id";

$res = Mysql::run_alter($sql);

$new_sql = "insert into news(company_id,send_userid,accept_userid,type,message,state,style,relation_id,add_time,update_time)
			values($company_id,$user_id,$accept_id,1,'".$mes."',0,7,$change_id,$now_time,$now_time)";
$res_id = Mysql::run_insert($new_sql);
if($res_id)
	EchoJsonData(0,'成功!');
else
	EchoJsonData(1,'失败');





?>