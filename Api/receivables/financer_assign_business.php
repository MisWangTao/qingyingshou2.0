<?php
//财务指定业务员的接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$is_caiwu = $userinfo['is_caiwu'];

$company_id = $userinfo['company_id'];

$now_time = time();

if($is_caiwu != 1)EchoJsonData(1,'你不是财务额!');

// $_POST = array(
// 		'id'=>'1068',
// 		'userids'=>array(1,6074)
// 	);

$id = I('post.id','i',0);
//$id = 63;

if($id<=0) EchoJsonData(1,'收款id不能为空!');


$sql_rece = "select assign_id,operate_id from receivables where id=$id and company_id=$company_id and delete_time is null";

$res = Mysql::run_select($sql_rece)[0];

if($res['assign_id']) EchoJsonData(1,'该回款单子已经被指派,不能继续指派!');

if($res['operate_id']!=$user_id) EchoJsonData(2,'这单子不是你建的,不能操作!');

//$user = '[{"userId":"6075","realname":"程远方","ding_avatar":""},{"userId":"6075","realname":"惠汹斌","ding_avatar":""}]';

$user= json_decode($_POST['userids'],true);

//$user = json_decode($user,true);

$str_user = array();
foreach($user as $k=>$v){
	$str_user[] = $v['userId'];
}


//$userids = substr($userids, 0,-1);

if(count($str_user)<=0)  EchoJsonData(1,'指定业务人员不能为空!');

$str_user = array_unique($str_user);

$userids = implode($str_user, ',');
//print_r($userids);
//print_r($str_user);
//exit;

//修改选中的回款单子的指派人的id

$edit_sql = "update receivables set assign_id='".$userids."' where id=$id and company_id=$company_id";

$res = Mysql::run_alter($edit_sql);

foreach($str_user as $k=>$v){
	$insert_sql = "insert into news(company_id,send_userid,accept_userid,type,state,style,relation_id,add_time,update_time)
					values($company_id,$user_id,$v,1,0,1,$id,$now_time,$now_time)";
	$new_id = Mysql::run_insert($insert_sql);
}
// print_r($res);
if($res)
	EchoJsonData(0,'指定成功!');
else
	EchoJsonData(1,'指定失败!');




?>
