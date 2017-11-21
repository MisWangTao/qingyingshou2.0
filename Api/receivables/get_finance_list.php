<?php
//获取公司的财务人员的 列表
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0) EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$sql = "select id,realname,ding_avatar
  from company_user
 where company_id= $company_id
   and is_delete= 0
   and is_caiwu= 1";

$res = Mysql::run_select($sql);

$res = count($res)>0?$res:array();

// print_r($res);

if($res)
  EchoJsonData(0,'财务人员列表获取成功!',$res);
else
  EchoJsonData(0,'没数据!',$res);






?>