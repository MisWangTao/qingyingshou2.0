<?php
//获取客户信息列表   新建回款的选择客户列表
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0) EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$sql = "SELECT contract_name,
       SUM(contract_money) AS total,
       SUM(ifnull(`contracted_money`, 0)) AS daozhang,
       custom_id,
       (
SELECT custom_name
  FROM `custom_list`
 WHERE `custom_list` .`id`= `contract_list` .`custom_id`
   and `custom_list` .`delete_time` IS NULL) AS custom_name
  FROM `contract_list`
 WHERE `delete_time` IS NULL
   AND company_id= $company_id
 GROUP BY `custom_id`";

$res = Mysql::run_select($sql);

foreach($res as $k=>$v){
	$res[$k]['ysye'] = number_format($v['total'] - $v['daozhang'],2);
}

$res = count($res)>0?$res:array();

// print_r($res);

if($res)
  EchoJsonData(0,'客户列表获取成功!',$res);
else
  EchoJsonData(0,'没数据!',$res);



















?>