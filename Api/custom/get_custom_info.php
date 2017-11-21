<?php
//手机获取客户详细信息
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

$customId = I('post.custom_id','i',0);
// $customId = 2;
if($userId=='')EchoJsonData(1,'userId不能为空!');

if($customId==0)EchoJsonData(2,'customId不能为空!');

$companyId = $userinfo['company_id'];

if($companyId==0)EchoJsonData(3,'company_id不能为空!');

//$result = array();
$sql = "select custom_list.id,
       custom_list.custom_name,
       custom_list.custom_number,
       custom_nature,custom_list.industry_id,
       custom_industry.industry_name,
       custom_address as bangongdizhi,
       custom_list.type,
       custom_list.date_type,
       custom_list.date,
       invoice_header as fapiaotaitou,
       taxpayer_identification_number as payer_id,
       bank_name,
       bank_account_number,
       bank_account_number as bank_number,
       address,
       custom_list.tel,
       (select company_name from company_list where company_list.id=custom_list.company_id) as company_name,
       logo,from_unixtime(custom_list.update_time,'%Y-%m-%d') as update_time,
       (select realname from company_user where company_user.id=custom_list.update_userid and company_user.is_delete=0) as update_realname,
       FROM_UNIXTIME(custom_list.add_time, '%Y-%m-%d') AS add_time,
       `company_user` .realname
  from custom_list
  left join company_user on custom_list.user_id= company_user.id
   and company_user.is_delete= 0
  left join custom_industry on custom_list.industry_id= custom_industry.id
 where custom_list.`id` = $customId and custom_list.company_id=$companyId
   and custom_list.delete_time is null";

$res = Mysql::run_select($sql);

$sql1 = "select customer_leader.id,user_id,depart_id,company_user.`realname`,company_user.`ding_avatar`,company_depart.`dapart_name`
from customer_leader
left join company_user on customer_leader.`user_id` = `company_user` .id
left join company_depart on `customer_leader` .depart_id = `company_depart` .id
where customer_leader.custom_id=$customId and customer_leader.company_id=$companyId and customer_leader.delete_time is null";

$res1 = Mysql::run_select($sql1);

$res[0]['follows'] = $res1;

//$customId 获取公司合同列表
$sql_contract_list = "SELECT contract_name,contract_date,contract_money,contract_number,contract_money,
(SELECT custom_name FROM `custom_list` WHERE `custom_list` .id=`contract_list` .custom_id and `custom_list` .delete_time is null) AS custom_name,
contracted_money as verification_money
FROM `contract_list` WHERE `custom_id` = $customId and delete_time is null and company_id=$companyId";

$res_contract = Mysql::run_select($sql_contract_list);

if(!$res_contract)$res_contract = array();

$res[0]['contract_list'] = $res_contract;

// print_r($res);
if($res)
	EchoJsonData(0,'客户信息获取成功!',$res[0]);
else
	EchoJsonData(8,'客户信息获取失败!');
?>