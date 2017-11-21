<?php
//添加客户信息接口
require_once(__DIR__ . "/../common/common.php");

$nowtime = time();

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

$companyId = $userinfo['company_id'];

if($companyId=='')EchoJsonData(2,'公司Id不能为空!');

$contractId = I('post.contract_id','i','NULL',true);
// $contractId = 1;
if($contractId=='NULL')EchoJsonData(3,'合同Id不能为空!');

$sql = "select timeaxis.id,des,company_user.realname,timeaxis.type,add_time from timeaxis 
left join company_user on timeaxis.user_id = company_user.id and `is_delete` =0
where timeaxis.company_id=$companyId and timeaxis.contract_id=$contractId and timeaxis.delete_time is null order by timeaxis.add_time asc";

$res = Mysql::run_select($sql);

$data = array();

foreach($res as $k=>$v)
{
	//新建合同
	if($v['type']==1)
	{
		$data[] = array(
			'type'=>1,
			'name'=>$v['realname'],
			'time'=>date("Y-m-d H:i:s",$v['add_time']),
			'desc'=>json_decode($v['des'],true),
		);
	}else if($v['type']==2){//编辑合同

	}else if($v['type']==3){

	}else if($v['type']==4){
		// $data[] = array(
		// 	'type'=>4,
		// 	'name'=>$v['realname'],
		// 	'time'=>date("Y-m-d H:i:s",$v['add_time']),
		// 	'desc'=>json_decode($v['des'],true),
		// );
	}

}
foreach($data as $k=>$v)
{
	$sortTime[] = $v['time'];
}
array_multisort($sortTime, SORT_DESC, $data);

EchoJsonData(0,'时间轴信息获取成功!',$data);
?>