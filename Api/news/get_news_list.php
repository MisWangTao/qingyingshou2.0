<?php
//获取待处理消息列表
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)echo EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$sql = "SELECT (SELECT realname FROM `company_user` WHERE `company_user` .id=`news` .send_userid and `company_user` .is_delete=0) AS send_user,id,type,style,state,relation_id,send_userid,accept_userid,from_unixtime(add_time,'%Y-%m-%d %H:%i') AS add_time FROM `news` WHERE (accept_userid = $user_id OR send_userid = $user_id) and delete_time is null order by update_time desc";

$res = Mysql::run_select($sql);

foreach($res as $k=>$v){
	if($v['style']==6){
		$change_id = $v['relation_id'];
		$contract_sql = "select (select contract_name from contract_list where contract_list.id=contract_change.contract_id and contract_list.delete_time is null) as contract_name from contract_change where id=$change_id";
		$res[$k]['contract_name'] = Mysql::run_select($contract_sql)[0]['contract_name'];
	}
}

// print_r($res);

EchoJsonData(0,'消息列表获取成功!',$res);
