<?php
require_once(__DIR__ . "/../common/common.php");


$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

$company_id = $userinfo['company_id'];

if($userId==0)EchoJsonData(1,'userId不能为空!');

if($company_id=='')EchoJsonData(2,'公司Id不能为空!');

$id =I('post.id','i',0,true);   //获取合同id
   // $id = 1;
if($id==0)EchoJsonData(3,'合同Id不能为空!');

$result = array();

$sql = "SELECT contract_name,contract_date,contract_money,contract_type,contract_number,maturity_date,payment_cycle,first_date_payment,each_money,cycle,expiration_reminder,advance_remind,
(contract_money-contracted_money) as ysye,
(select sum(arrival_amount) from verification_contract where verification_contract.contract_id=contract_list.id and verification_contract.delete_time is null) as arrival_amount,(select realname from company_user where company_user.id=contract_list.followup_id) as realname,remark,
(SELECT custom_name FROM `custom_list` WHERE `custom_list` .id=`contract_list` .custom_id and `custom_list` .delete_time is null) AS custom_name,
contracted_money as verification_money,expiration_reminder,advance_remind
FROM `contract_list` WHERE `id` = $id and company_id=$company_id";

$res = Mysql::run_select($sql);

$result['contract'] = $res[0];

//print_r($res);
//合同操作回款计划详情
$sql_plan = "select `plan_date` ,`plan_money` ,`plan_remark` ,`plan_type` ,`planed_money`,id
from `contract_payment_plans` WHERE `contract_id` =$id and `delete_time` is null and company_id=$company_id";

//$sql_plan = "SELECT `returning_time` ,`returning_money` ,b.`plan_date` ,b.`plan_money` ,b.`plan_type` ,b.`plan_remark`
//FROM verification_paymentplan AS a
//where a.`contract_id` =$id and a.`delete_time` is null";



$res_plan = Mysql::run_select($sql_plan);



foreach($res_plan as $k=>$v){
	$sql = "select returning_money,returning_time from `verification_paymentplan`  where return_plan_id=".$v['id']." and contract_id=$id and delete_time is null";
	$res = Mysql::run_select($sql);
	$res = count($res)?$res:array();
	$res_plan[$k]['plan_detail'] = $res;
}



$res_plan = count($res_plan)?$res_plan:array();

$result['plan'] = $res_plan;
//合同操作动态
// $dynamic_sql = "SELECT des,
//        (
// SELECT realname
//   FROM `company_user`
//  WHERE `company_user` .id= contract_log.user_id) AS realname,
//        type,
//        from_unixtime(add_time,'%m-%d') AS time1,from_unixtime(add_time,'%H:%i') as time2
//   FROM contract_log
//  where contract_id= $id and delete_time is null ";

//  $res_dynamic = Mysql::run_select($dynamic_sql);

// $result['dynamic'] = $res_dynamic;

//时间轴
$sql1 = "select timeaxis.id,des,company_user.realname,timeaxis.type,add_time,from_unixtime(add_time,'%Y-%m-%d') as time1,from_unixtime(add_time,'%H:%i:%s') as time2 from timeaxis
left join company_user on timeaxis.user_id = company_user.id and `is_delete` =0
where timeaxis.company_id=$company_id and timeaxis.contract_id=$id and timeaxis.delete_time is null order by timeaxis.add_time asc";

$res = Mysql::run_select($sql1);

$data = array();

foreach($res as $k=>$v)
{
	//新建合同
	if($v['type']==1)
	{
		$data[] = array(
			'type'=>1,
			'name'=>$v['realname'],
			'time1'=>$v['time1'],
			'time2'=>$v['time2'],
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

$result['dongtai'] = $data;


$sql = " SELECT id,src,old_name as name,ext,`filesize` as size FROM  files WHERE relation_id = $id and relation_type=1 and `delete_time` is null and company_id=$company_id";
$files = Mysql::run_select($sql);

$result['files'] = count($files)?$files:array();







   // print_r($result);

if($result)
	EchoJsonData(0,'合同信息获取成功!',$result);
else
	EchoJsonData(-1,'合同信息获取失败!');

?>
