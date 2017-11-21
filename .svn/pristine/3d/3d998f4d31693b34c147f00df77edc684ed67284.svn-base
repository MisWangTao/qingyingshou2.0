<?php
//PC获取变更数据列表
require_once(__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");
require_once ("../../common/config/db.cof.php");
//
//$user_id   = $_SESSION['userinfo']['id'];
//
//$company_id = $_SESSION['userinfo']['custom_id'];


$userInfo = $GLOBALS['userinfo'];

$user_id  = $userInfo['id'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

$company_id = $userInfo['company_id'];


$contract_id  = I('post.contract_id','i',0);
if($contract_id==0) EchoJsonData(1,'应收单不为空!');

$response =array();






$pro_sql = "select * from contract_list where id=$contract_id";

$project_name = Mysql::run_select($pro_sql)[0]['project_name'];

$sql = "select contract_change.id,contract_change.change_date,contract_change.original_ywje as money,contract_change.original_dz as daozhang, 
(contract_change.original_ywje - contract_change.original_dz) as balance_money,contract_change.change_money,contract_change.refund_money,contract_change.change_reason,contract_change.add_time,contract_change.cancel_time  
from contract_change
left join contract_list on contract_change.contract_id=contract_list.id 
where contract_change.contract_id=$contract_id and contract_change.custom_id=$company_id
group by `contract_change` .id order by contract_change.add_time desc";

$res = Mysql::run_select($sql);

$arr =array();

//查询该笔应收单的到账时间和编辑应收单时间
$sql1 = "(select MAX(add_time) as max_time from `verification_contract` where `contract_id` =$contract_id and delete_time is null)

UNION 

(select update_time as max_time from contract_list where id=$contract_id and delete_time is null)";

$res1 = Mysql::run_select($sql1);

if($res1[0]['max_time']>$res1[1]['max_time'])
{
	$rss = $res1[0]['max_time'];

}else if($res1[0]['max_time']<$res1[1]['max_time']){

	$rss = $res1[1]['max_time'];
}

$response['code']=0;
$response['msg']='获取列表成功!';
$response['project_name'] = $project_name;
$response['last_time'] = $rss;
$response['data'] = count($res)>0?$res:array();

echo json_encode($response, JSON_UNESCAPED_SLASHES);
exit;

?>