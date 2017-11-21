<?php

require_once(__DIR__ . "/../common/common.php");

// $userId = !empty($_POST['user_id'])?intval($_POST['user_id']):0;

// $userId = 6073;

// if($userId==0)echo EchoJsonData(1,'userId不能为空!');

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];



// $sql = "select * from company_user where id=".$userId;

// $res = Mysql::run_select($sql);

// $isCaiWu = $res[0]['is_caiwu'];

$isCaiWu = $userinfo['is_caiwu'];

$companyId = $userinfo['company_id'];

// print_r($userinfo);
// echo $isCaiWu;
// echo $companyId;
// exit;


$nowtime = time();

// if($isCaiWu!=1)EchoJsonData(2,'非财务人员!');

$label_name = I('post.label_name','s','',true);
// $label_name ='23';
if($label_name=='')EchoJsonData(2,'合同标签不能为空!');

$sql = "insert into contract_label(label_name,company_id,add_time,add_user,update_time)
		values('".$label_name."',$companyId,$userId,$nowtime,$nowtime)";

$res =  Mysql::run_insert($sql);

// echo $res;exit;

$sql1 = "select id,label_name,add_user from contract_label where company_id=$companyId";

$res1 = Mysql::run_select($sql1);

$res1 = count($res1)>0?$res1:array();

if($res>0)
	EchoJsonData(0,'新建标签成功!',$res1);
else
	EchoJsonData(-1,'新建标签失败!',$res1);
?>