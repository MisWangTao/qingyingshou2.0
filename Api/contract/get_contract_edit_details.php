<?php

//手机获取合同详细信息接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

$company_id = $userinfo['company_id'];

if($userId==0)EchoJsonData(1,'userId不能为空!');

$id = I('get.id','i',0);
if($id==0)EchoJsonData(1,'Id不能为空!');

// $id = 64;

$sql_detail = "SELECT contract_name,
       contract_date,
       contract_money,
       contract_number,
       label_id,custom_id,
       contract_type,followup_id,followup_depart,expiration_reminder as remindState,
       linkman,maturity_date,currency_id,payment_type,each_month,each_day,
       tel,remark,payment_cycle,first_date_payment,each_money,cycle,advance_remind,
       (SELECT realname FROM `company_user` WHERE `company_user` .id=`contract_list` .followup_id and `company_user` .`is_delete` =0) AS followusername,
       (SELECT dapart_name FROM `company_depart` WHERE `company_depart` .id=`contract_list` .followup_depart and `company_depart` .`is_delete` =0) AS followdepartname,
       ( SELECT realname
  FROM `company_user`
 WHERE `company_user` .id= `contract_list` .user_id
   and `company_user` . `is_delete` =0) AS creatname,FROM_UNIXTIME(add_time,'%Y-%m-%d') AS creattime,
         (
SELECT custom_name
  FROM `custom_list`
 WHERE `custom_list` .id= `contract_list` .custom_id
   and `custom_list` .delete_time is null) AS custom_name
  FROM `contract_list`
 WHERE `id`= $id and company_id=$company_id";

$res_contract = Mysql::run_select($sql_detail)[0];

$res_label_id = $res_contract['label_id'];

if($res_label_id)
{
  $label_sql = "SELECT id,label_name FROM `contract_label` WHERE `id` IN (".$res_label_id.") and `delete_time` is null";

  $res_label = Mysql::run_select($label_sql);

}else{

  $res_label = array();
}



$res_contract['label'] = $res_label;

$sql = " SELECT id,old_name as name,src,ext,mime,filesize as size FROM  files WHERE relation_id = $id and `delete_time` is null and company_id=$company_id";
$files = Mysql::run_select($sql);

$res_contract['files'] = count($files)?$files:array();
$res_contract['aa'] = 1;
// $res_contract['follow'] = $res_follow;

if($res_contract)
  EchoJsonData(0,'合同信息获取成功!',$res_contract);
else
  EchoJsonData(-1,'合同信息获取失败!');


?>