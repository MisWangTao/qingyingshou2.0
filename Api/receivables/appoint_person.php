<?php 
//指定负责人接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

$customId = I('post.custom_id','i',0);

if($userId=='')EchoJsonData(1,'userId不能为空!');
// $customId = 3;
if($customId==0)EchoJsonData(2,'customId不能为空!');

$companyId = $userinfo['company_id'];

if($companyId==0)EchoJsonData(3,'company_id不能为空!');

$sql = "select * from customer_leader where custom_id=$customId and company_id=$companyId and delete_time is null";

$result = Mysql::run_select($sql);
// var_dump($result);
$res = getDepartUser($result);

function getDepartUser($result)
{	
	$arr = array();

	foreach($result as $k=>$v)
	{
		$sql = "select company_depart.id as departId,company_depart.`dapart_name`,company_user.id as userId,company_user.`realname`,company_user.`ding_avatar`  
			from `company_user` 
			left join `company_depart`  on company_user.`department_id`  = `company_depart` .id and `company_depart` .`is_delete` =0 
			where company_user.id=".$v['user_id'];
		// var_dump($sql);	
		$res[] = Mysql::run_select($sql);

	}
	// var_dump($res);
	// echo json_encode($res);
	foreach($res as $k=>$v)
	{
		$arr[$v[0]['departId']]['departId'] = $v[0]['departId'];
		$arr[$v[0]['departId']]['depart_name'] = $v[0]['dapart_name'];
		$arr[$v[0]['departId']]['users'][$k]['userId'] = $v[0]['userId'];
		$arr[$v[0]['departId']]['users'][$k]['realname'] = $v[0]['realname'];
		$arr[$v[0]['departId']]['users'][$k]['ding_avatar'] = $v[0]['ding_avatar'];
	}
	sort($arr);
	return $arr;
}
if($res)
	EchoJsonData(0,'获取部门人员成功!',$res);
else
	EchoJsonData(0,'暂无数据!',array());
?>