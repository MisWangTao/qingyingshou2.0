<?php

require_once(__DIR__ . "/../common/common.php");
require_once(__DIR__ . "/../../ding/api/User.php");
require_once(__DIR__ . "/../../ding/api/ISVClass.php");

$corpId = I('post.corpId','s');
$code   = I('post.code','s');

if($corpId && $code){

	$corpInfo = ISVClass::getCorpInfo($corpId);
	$accessToken = $corpInfo['corpAccessToken'];
	$userInfo = json_decode(User::getUserInfo($accessToken, $code),true);

	$userid    = $userInfo['userid'];
	$sql       =  "select id from company_list where corpid='$corpId'";
	$res       =  Mysql::run_select($sql);
	$custom_id = $res[0]['id'];

	$sql       = "select * from company_user where company_id='$custom_id' and ding_userid='$userid'";
	$res       = Mysql::run_select($sql);
	$user      = $res[0];
	$user['token'] = $user['id'];

	EchoJsonData(0,'登录成功',$user);

}else{
	if(DEBUG){
		$sql = " SELECT * FROM company_user WHERE id=1 ";
		$res = Mysql::run_select($sql);
		$user = $res[0];
		$user['token'] = 1;

		EchoJsonData(0,'登录成功',$user);
	}else EchoJsonData(1,'登录失败');
}
