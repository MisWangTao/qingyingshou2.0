<?php
//获取回款列表  移动
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$is_caiwu = $userinfo['is_caiwu'];

$where = '';

if ($is_caiwu!=1) {
	$where = " and assist_id =$user_id ";
}

$sql ="SELECT  `id` ,(SELECT custom_name FROM `custom_list` WHERE `receivables` .custom_id=`custom_list` .id AND `custom_list` .delete_time is null) AS custom_name,
arrival_date,arrival_amount,states,payment_method_id
FROM `receivables` WHERE `company_id` =$company_id and `delete_time` is null  ".$where." order by update_time desc";

$res = Mysql::run_select($sql);

$res = count($res)>0?$res:array();

// print_r($res);

if($res)
  EchoJsonData(0,'回款列表获取成功!',$res);
else
  EchoJsonData(0,'没数据!',$res);




?>