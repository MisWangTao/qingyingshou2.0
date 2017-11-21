<?php
//获取业务人员列表
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$is_caiwu = $userinfo['is_caiwu]'];

if($is_caiwu!=1)EchoJsonData(1,'你不是财务!');

$company_id = $userinfo['company_id'];

$sql = "SELECT id,
       realname
  FROM `company_user`
 WHERE `is_caiwu`= 0
   and `company_id`= $company_id
   and `is_delete`= 0";

$res = Mysql::run_select($sql);

$res = count($res)>0?$res:array();

// print_r($res);

if($res)
  EchoJsonData(0,'业务人员列表获取成功!',$res);
else
  EchoJsonData(0,'没数据!',$res);

















?>