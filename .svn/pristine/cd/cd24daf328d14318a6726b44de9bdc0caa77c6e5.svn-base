<?php
//业务人员提出异议的接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$now_time = time();




$newsid = I('post.newsid','i',0);//news 表的id
if($newsid==0) EchoJsonData(1,'news的id不为空!');

$res_new = Mysql::run_select("select relation_id from news where id=$newsid and company_id=$company_id");

if(!$res_new)EchoJsonData(1,'参数错误!');

$sql = "update news set state=1 where id=$newsid and company_id=$company_id";

$res = Mysql::run_alter($sql);

$id = $res_new[0]['relation_id'];

$reason = I('post.reason','s','',true);

//修改回款单的状态
$edit_sql = "update receivables set states=3,update_time=$now_time where id=$id and company_id=$company_id";
// echo $edit_sql;exit;
$res_rece = Mysql::run_alter($edit_sql);

//向receivable_dissent表添加数据
$insert_dissent_sql = "insert into receivable_dissent(receivable_id,dissent_id,reason,add_time,update_time)
					values($id,$user_id,'".$reason."',$now_time,$now_time)";
$dissent_id = Mysql::run_insert($insert_dissent_sql);

//向news 表中添加数据

$sql_caiwu = "select operate_id from receivables where id=$id and company_id=$company_id";

$res_caiwu_id = Mysql::run_select($sql_caiwu)[0]['operate_id'];

$insert_new_sql = "insert into news(company_id,send_userid,accept_userid,type,state,style,relation_id,add_time,update_time)
					values($company_id,$user_id,$res_caiwu_id,1,0,2,$dissent_id,$now_time,$now_time)";
$new_id = Mysql::run_insert($insert_new_sql);

if($new_id)
	EchoJsonData(0,'异议成功!');
else
	EchoJsonData(1,'失败!');



?>