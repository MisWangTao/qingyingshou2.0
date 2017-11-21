<?php
//回款详情的接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$id = I('post.id','i',0);
// $id = 81;
if($id<=0)EchoJsonData(2,'消息id不能为空!');

$sql = " SELECT relation_id FROM news WHERE id=$id ";
$res = Mysql::run_select($sql);

$id = $res[0]['relation_id'];

//$sql = "SELECT (SELECT custom_name FROM `custom_list` WHERE `custom_list` .id=`a` .custom_id and `custom_list` .delete_time is null) AS custom_name,(SELECT realname FROM company_user WHERE company_user.id=a.operate_id) as caozuoren,a.custom_id,
//b.`payment_method` ,b.`values` ,a.`arrival_amount` ,a.`arrival_date` ,a.`remarks` ,a.`assist_id`,a.assist_id,a.id
//FROM `receivables` AS a
//LEFT JOIN `payment_method` AS b ON `b` .id=`a` .payment_method_id
//WHERE a.`id` = $id and a.`company_id` =$company_id and a.`delete_time` IS NULL ";


$sql = "SELECT (SELECT custom_name FROM `custom_list` WHERE `custom_list` .id=`a` .custom_id and `custom_list` .delete_time is null) AS custom_name,(SELECT realname FROM company_user WHERE company_user.id=a.operate_id) as caozuoren,a.custom_id,FROM_UNIXTIME(update_time,'%Y-%m-%d %H:%i:%s') AS updatetime,
a.`arrival_amount` ,a.`arrival_date` ,a.`remarks` ,a.`assist_id`,a.assist_id,a.id,a.payment_method_id as payment_method
FROM `receivables` AS a
WHERE a.`id` = $id and a.`company_id` =$company_id and a.`delete_time` IS NULL ";



$res = Mysql::run_select($sql)[0];

$res['otherassist']  = $res['assist_id'] && $res['assist_id']!=$user_id ;

$detail_sql = "SELECT `contract_id` ,`returning_money`  FROM `verification_contract` WHERE `receivable_id` = $id and `company_id` =$company_id";

$res_details = Mysql::run_select($detail_sql);



$file_sql = "SELECT src from `files` WHERE relation_type=2 and relation_id = $id and company_id=$company_id and mime like 'image%' and delete_time is null";
$result_file = Mysql::run_select($file_sql);
if(!$result_file)$result_file = array();
foreach($result_file as $key=>$value){
	$result_file[$key]['src'] = 'https://'.$_SERVER['HTTP_HOST'].$value['src'];
}
$res['files'] = $result_file;
// print_r($res);
if($res)
  EchoJsonData(0,'回款详情获取成功!',$res);
else
  EchoJsonData(1,'参数错误!');
?>
