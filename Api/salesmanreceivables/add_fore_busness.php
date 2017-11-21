<?php
//移动添加预计回款接口   客户添加

require_once(__DIR__ . "/../common/common.php");


$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];


if($user_id==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$is_caiwu = $userinfo['is_caiwu'];

if($is_caiwu!=0)EchoJsonData(1,'这是业务员做的事!');

$now_time = time();

$custom_id = I('post.custom_id','i',0);   //接收的custom_id 客户公司的id

if($custom_id==0) EchoJsonData(1,'客户公司的id不能为空!');

$arrival_amount = I('post.arrival_amount','f',0); //接收预计回款金额

if($arrival_amount<=0)EchoJsonData(1,'没填金额!');

$arrival_date = I('post.arrival_date','s','',true);  //接收预计回款日期

if(!$arrival_date)EchoJsonData(1,'没有日期!');

$assist = I('post.assist_id','i',0);

if($assist<=0)EchoJsonData(1,'没选指定财务!');

$contract_arr = json_decode($_POST['contract'],true); //得到的数据是contract_id 和 returning_money
if(count($contract_arr)<=0)EchoJsonData(3,'没有选合同!');


// if(!$contract_arr)$contract_arr = array(
// 	array(
// 		'contract_id'=>12,
// 		'returning_money'=>'100'
// 	),
// 	array(
// 		'contract_id'=>13,
// 		'returning_money'=>'222'
// 	)
// );
$money = 0;
$contract_ids = '';
foreach($contract_arr as $key=>$value){
	$money += $value['returning_money'];
	$contract_ids .= $value['contract_id'].',';
	$sql = "select (contract_money-ifnull(contracted_money,0)) as ysye from contract_list where id='".$value['contract_id']."' and delete_time is null and company_id=$company_id";
	// echo $sql;
	$res = Mysql::run_select($sql)[0]['ysye'];
	// echo $res;
	if($res<$value['returning_money']) EchoJsonData(1,'核销金额不能大于该合同的应收余额!');

}

// echo $money;
if($money>$arrival_amount)  EchoJsonData(1,'总核销金额不能大于预计回款金额!');

$contract_ids = substr($contract_ids, 0,-1);

//先向forecastreceivables 添加数据

$insert_fore = "insert into forecastreceivables (custom_id,company_id,operate_id,assist_id,arrival_date,arrival_amount,contract_ids,add_time,update_time)
				values ($custom_id,$company_id,$user_id,$assist,'".$arrival_date."','".$arrival_amount."','".$contract_ids."',$now_time,$now_time)";

$fore_id = Mysql::run_insert($insert_fore);

$insert_new = "insert into news (company_id,send_userid,accept_userid,type,state,style,relation_id,add_time,update_time)
				values($company_id,$user_id,$assist,1,0,3,$fore_id,$now_time,$now_time)";
$new_id = Mysql::run_insert($insert_new);


foreach($contract_arr as $k=>$v){
	$sql = "insert into forecastverification_contract (willreceivable_id,custom_id,company_id,contract_id,returning_money,add_time,update_time)
			values($fore_id,$custom_id,$company_id,'".$v['contract_id']."','".$v['returning_money']."',$now_time,$now_time)";
			// echo $sql;
	$res = Mysql::run_insert($sql);
}







if($fore_id)
	EchoJsonData(0,'添加成功!');
else
	EchoJsonData(1,'添加失败!');

?>