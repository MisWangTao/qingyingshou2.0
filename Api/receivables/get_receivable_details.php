<?php
//回款详情的接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$id = I('post.id','i',0);
// $id = 1;
if($id==0)EchoJsonData(1,'回款表id不为空!');

// $sql = "SELECT (SELECT custom_name FROM `custom_list` WHERE `custom_list` .id=`a` .custom_id and `custom_list` .delete_time is null) AS custom_name,custom_id,
// b.`payment_method` ,b.`values` ,
// `a` .payment_method_id,
// a.`arrival_amount` ,a.`arrival_date` ,a.`remarks` ,a.`contract_ids`,a.assist_id,a.states,a.custom_id
// FROM `receivables` AS a
// LEFT JOIN `payment_method` AS b ON `b` .id=`a` .payment_method_id
// WHERE a.`id` = $id and a.`company_id` =$company_id and a.`delete_time` IS NULL ";

$sql = "SELECT custom_list.custom_name,custom_id,custom_list.custom_number,bill_number,
`a` .payment_method_id as payment_method,
a.`arrival_amount` ,a.`arrival_date` ,a.`remarks` ,a.`contract_ids`,a.assist_id,a.states,a.custom_id
FROM `receivables` AS a LEFT JOIN custom_list on `custom_list` .id=`a` .custom_id and `custom_list` .delete_time is null
WHERE a.`id` = $id and a.`company_id` =$company_id and a.`delete_time` IS NULL ";



$res = Mysql::run_select($sql)[0];
$custom_id = $res['custom_id'];
// print_r($res);

$detail_sql = "SELECT `contract_id` ,`returning_money`  FROM `verification_contract` WHERE `receivable_id` = $id and `company_id` =$company_id";

$res_details = Mysql::run_select($detail_sql);

$hexiao_detail = array();

foreach ($res_details as $key => $value) {
	$contract_sql = "select contract_name,contract_number,contract_money,contract_date,
	(select realname from company_user where company_user.id=contract_list.followup_id and is_delete=0) as realname,
	
	(select sum(returning_money) from verification_contract where verification_contract.contract_id=contract_list.id ) as zdz
	from contract_list where id=".$value['contract_id'];
	$res_contract = Mysql::run_select($contract_sql)[0];
	$res_contract['returning_money'] = $value['returning_money'];
	$hexiao_detail[] = $res_contract;
}



$res['hexiao'] = $hexiao_detail;


$file_sql = "SELECT src,old_name,ext,id,filesize from `files` WHERE relation_type=2 and relation_id = $id and company_id=$company_id and mime like 'image%' and delete_time is null";
$result_file = Mysql::run_select($file_sql);
if(!$result_file)$result_file = array();
foreach($result_file as $key=>$value){
	$result_file[$key]['src'] = 'https://'.$_SERVER['HTTP_HOST'].$value['src'];
}
$res['files'] = $result_file;

$sql_custom = "select count(id) as count,sum(contract_money) as total_money,sum(contracted_money) as hxje
from contract_list where custom_id=$custom_id and delete_time is null";

$res3 = Mysql::run_select($sql_custom)[0];

$res['count'] = $res3['count'];

$res['total_money'] = $res3['total_money'];

$res['zhxje'] = $res3['hxje'];

$sql4 = "select sum(arrival_amount) as shoukuan from receivables where delete_time is null and custom_id=$custom_id";

$res['shoukuan'] = Mysql::run_select($sql4)[0]['shoukuan'];

   // print_r($res);
// print_r($_SERVER);
if($res)
  EchoJsonData(0,'回款详情获取成功!',$res);
else
  EchoJsonData(1,'参数错误!');
?>
