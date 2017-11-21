<?php
//删除回款计划
require_once (__DIR__ . "/../common/common.php");

$userInfo = $GLOBALS['userinfo'];

$user_id = $userInfo['id'];

if ($user_id == '')
	EchoJsonData(1, 'userId不能为空!');

$company_id = $userInfo['company_id'];

$now_time = time();

$plan_id = I('post.plan_id','i',0);

// $plan_id = 68;

if($plan_id<=0) EchoJsonData(1, '回款id不为空!');
$contract_id = I('post.contract_id','i',0);
// $contract_id = 21;
$rs_sql = "select * from contract_payment_plans where id=$plan_id and company_id=$company_id";

$rs = Mysql::run_select($rs_sql)[0];
$str = "";

if($rs['plan_type']==1){$str="常规";}else if($rs['plan_type' ]==2){$str="预收款";}else if($rs['plan_type']==3){$str="质保金";}else{$str="尾款";}
$text_arr = array();
$text = "删除的时间为".$rs['plan_date']."金额为".$rs['plan_money'].",备注为 ".$rs['plan_remark']." ,类型为 ".$str." 的回款计划";
$text = addslashes(json_encode($text,JSON_UNESCAPED_SLASHES));
// echo $text;exit;
$sql_time = "insert into timeaxis(company_id,contract_id,des,user_id,type,relation_id,add_time,update_time)
			values($company_id,$contract_id,'$text',$user_id,5,".$rs['id'].",$now_time,$now_time)";

$res_id = Mysql::run_insert($sql_time);

                                    
$sql = "update contract_payment_plans set delete_time=$now_time where id=$plan_id and company_id=$company_id";

$res = Mysql::run_alter($sql);

WriteOffContract($contract_id);

if($res)
	EchoJsonData(0, '成功!');
else
	EchoJsonData(1, '失败!');

?>