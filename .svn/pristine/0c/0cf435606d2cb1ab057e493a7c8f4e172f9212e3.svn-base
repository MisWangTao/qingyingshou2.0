<?php
//获取合同列表接口
require_once(__DIR__ . "/../common/common.php");

// $userId = !empty($_POST['user_id'])?intval($_POST['user_id']):0;

// $userId = 6072;

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];


if($userId==0)EchoJsonData(1,'userId不能为空!');

// $sql = "select * from company_user where id=$userId";

// $res = Mysql::run_select($sql);

// $companyId = $res[0]['company_id'];

$companyId = $userinfo['company_id'];

$is_caiwu = $userinfo['is_caiwu'];
$where = '';
if($is_caiwu!=1){
  $where = " and followup_id=$userId ";
}


$sql = "select contract_list.`id`,
       contract_list.`contract_name`,
      b.`custom_name` ,
       contract_list.`contract_money`,
       contract_list.`contract_date`,
       contract_list.`contract_type`,
     contract_list.`label_id`,
     contracted_money as verification_money,
     ifnull((select SUM(arrival_amount) from verification_contract where contract_list.`id`=verification_contract.contract_id and verification_contract.delete_time is null),0) as arrival_amount
  from contract_list
  left join custom_list as b on contract_list.custom_id= b .id
   and b.delete_time is null
 where contract_list.company_id=$companyId
   and contract_list.delete_time is null".$where."
   order by contract_list.update_time desc";

$res = Mysql::run_select($sql);
$result = array();

  foreach($res as $k=>$v)
  {
    $labels_name = array();
		$result['htje'] += $v['contract_money'];
		$result['hxje'] += $v['verification_money'];
		$result['arrival_amount'] += $v['arrival_amount'];
    if($v['label_id']!='')
    {
       $sql = "select label_name from contract_label where id in (".$v['label_id'].")";
       // var_dump($sql);
      $rs = Mysql::run_select($sql);

      $labels_name = $rs;

      $res[$k]['label_name'] = $labels_name;

    }else{
      $res[$k]['label_name'] = array();
    }
  }

$result['ysye'] = $result['htje'] - $result['hxje'];


$conteact_list = count($res)>0?$res:array();

// print_r($conteact_list);
$response = array();
if($conteact_list)
{
  $response['code'] = 0;
	$response['msg']   = '获取收款核销记录成功!';
	$response['data']  = $conteact_list;
	$response['result']  = $result;

}else{
  $response['code'] = 0;
	$response['msg']   = '暂无数据!';
	$response['data']  = array();
}

echo json_encode($response,JSON_UNESCAPED_SLASHES);






//if(count($conteact_list)>0)
//	EchoJsonData(0,'合同列表获取成功!',$conteact_list);
//else
//	EchoJsonData(0,'暂无数据!',$conteact_list);

?>