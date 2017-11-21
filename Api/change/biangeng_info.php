<?php
//PC变更申请详情
require_once(__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");

$userInfo = $GLOBALS['userinfo'];

$userId  = $userInfo['id'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

$companyId = $userInfo['company_id'];

$nowtime = time();

if($_GET)
{
	$changeId  = I('get.changeId','i','');

	if($changeId=='')EchoJsonData(2,'变更单Id不存在');
	//查询变更信息
	$sql1 = 
	"select id,contract_id,change_type,change_reason,change_money,change_date,change_status,refund_money,remark
	from contract_change where id=$changeId";

	$res1 = Mysql::run_select($sql1);

	$contractId = $res1[0]['contract_id'];
	//查询合同信息
	$sql2 = "select contract_name,contract_number,contract_money,contract_date,contracted_money,
	(select custom_name from custom_list where contract_list.custom_id = custom_list.id ) as custom_name, 
	(select realname from company_user where contract_list.`user_id` =company_user.id) as genjinren
	from contract_list where id=$contractId and company_id=$companyId";

	$res2 = Mysql::run_select($sql2);
	//查询回款计划
	$sql3 = 
	"select type,paymented_plan_money,change_plan_type,change_plan_date,change_plan_money,change_plan_remark from contract_payment_plan_change where contract_change_id=$changeId and contract_id=$contractId and delete_time is null";

	$res3 = Mysql::run_select($sql3);
	$res3 = $res3?$res3:array();
	//查询附件

	$sql4 = "select old_name,src,ext,mime,filesize from files where company_id=$companyId and relation_id=$changeId  and relation_type=3 and delete_time is null";
	$res4 = Mysql::run_select($sql4);
	$res4 = $res4?$res4:array();

	$data['contract_info'] = $res2;
	$data['change_info'] = $res1;
	$data['payment_plan'] = $res3;
	$data['files'] = $res4;

	EchoJsonData(0,'获取变更详情成功!',$data);
		
}else if($_POST)
{
	$changeId  = !empty($_POST['changeId'])?intval($_POST['changeId']):'';

	if($changeId==''){
		$response['code']=2;
		$response['msg']='变更单Id不存在!';
		echo json_encode($response, JSON_UNESCAPED_SLASHES);
		exit;
	}
	$nowtime = time();

	$mysqli =new mysqli($DB_IP,$DB_Username,$DB_Password,$DB_Name);

	mysqli_query($mysqli ,"set names utf8");

	$mysqli->autocommit(false);
	
	$sql = "select * from record_change where id=$changeId";

	$res = Mysql::run_select($sql);

	$ysId = $res[0]['ysid'];

	$sql1 = "update record_change set cancel_time=$nowtime,cancel_id=$user_id where id=$changeId";

	$res1 = mysqli_query($mysqli,$sql1);

	// var_dump($sql1);
	// var_dump($res1);
	// echo "<br/>";

	$sql2 = "update ysyf_record set money=money+".-$res[0]['change_money']." where id=$ysId";

	$res2 = mysqli_query($mysqli,$sql2);

	// var_dump($sql2);
	// var_dump($res2);
	// echo "<br/>";

	$sql3 = "select * from record_change_return_plan where record_change_id=$changeId";

	$res3 = Mysql::run_select($sql3);

	// var_dump($sql3);
	// echo "<br/>";
	// var_dump($res3);
	if($res3){
		foreach($res3 as $k3=>$v3)
		{	
			if($v3['type']==1)
			{
				$sql4 = "update ysyf_return_plan set delete_time=$nowtime where id=".$v3['return_plan_id'];

			}else if($v3['type']==2)
			{
				$sql4 = "update ysyf_return_plan set type=".$v3['return_plan_type'].",return_money=".$v3['return_plan_money'].",return_date=".strtotime($v3['return_plan_date']).",returned_money=".$v3['returned_plan_money'].",remark='".$v3['return_plan_remark']."' where id=".$v3['return_plan_id'];

			}else if($v3['type']==3)
			{
				$sql4 = "update ysyf_return_plan set delete_time=null where id=".$v3['return_plan_id'];
			}
			
			// var_dump($sql4);
			$res4 = mysqli_query($mysqli,$sql4);

		}
    }else{

    	$res4 = ture;
    }
	// var_dump($sql4);
	// var_dump($res4);
	// echo "<br/>";

	$sql5 = "update record_change_return_plan set delete_time=$nowtime,cancel_time=$nowtime,cancel_id=$user_id where record_change_id=$changeId";

	$res5 = mysqli_query($mysqli,$sql5);

	// var_dump($sql5);
	// var_dump($res5);
	// echo "<br/>";

	$sql6 = "update return_log set delete_time=$nowtime,cancel_time=$nowtime,cancel_id=$user_id where change_id=$changeId";

	$res6 = mysqli_query($mysqli,$sql6);
	
	// var_dump($sql6);
	// var_dump($res6);
	// echo "<br/>";

	$sql7 = "select * from return_log where change_id=$changeId and custom_id=$custom_id and delete_time is null";

	$res7 = Mysql::run_select($sql7);

	// var_dump($sql7);
	// echo "<br/>";

	$returnLogId = $res7[0]['id'];
	if($returnLogId>0)
	{
		$sql8 = "update ysyf_plan_record set delete_time=$nowtime,cancel_time=$nowtime,cancel_id=$user_id where log_id=$returnLogId";

		$res8 = mysqli_query($mysqli,$sql8);

		if($res8<=0)
		{
			$mysqli->rollback();
		}
	}
	
	// var_dump($sql8);
	// var_dump($res8);
	// echo "<br/>";

	if(!$mysqli->errno && $res1 && $res2 && $res4 && $res5 && $res6 )
	{
	 	$mysqli->commit();
	 	$response['code']=0;
		$response['msg']='变更单撤销成功!';
	}else{
		$mysqli->rollback();
		$response['code']=-1;
		$response['msg']='变更单撤销失败!';
	 	
	}
	$mysqli->autocommit(true); //设置为非自动提交——事务处理

	$mysqli->close();

	echo json_encode($response, JSON_UNESCAPED_SLASHES);
}


?>