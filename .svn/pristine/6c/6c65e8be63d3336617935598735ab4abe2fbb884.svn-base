<?php
//获取预计回款详情接口
require_once(__DIR__ . "/../common/common.php");

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

if($userId==0)EchoJsonData(1,'userId不能为空!');

$companyId = $userinfo['company_id'];

//查询部门的层级结构
$sql = "select id,dapart_name,ding_id,parent_ding_id from company_depart where company_id=$companyId and is_delete=0";

$res = Mysql::run_select($sql);

$departListUser = depart_tree($res);

$departListUser = count($departListUser)>0?$departListUser:array();
function depart_tree($array,$dingId=0)
{
	$departAndUser = array();

	foreach($array as $k=>$v)
	{
		if($v['parent_ding_id']==$dingId)
		{	
			$sql = "select id,realname,ding_userid,ding_avatar from company_user where MATCH(ding_department) AGAINST(".$v['ding_id'].") and is_delete=0";
			$res = Mysql::run_select($sql);
			$res = count($res)?$res:array();
			$v['sub'] = depart_tree($array,$v['ding_id']);
			$v['users'] = $res;
			$departAndUser[] = $v;
		}
	}
	return $departAndUser;
}
//查询第一级的人员
$sql1 = "select id,dapart_name,ding_id,parent_ding_id from company_depart where company_id=$companyId and is_delete=0 and ding_id=1";
$res1 = Mysql::run_select($sql1);

$sql2 = "select id,realname,ding_userid,ding_avatar from company_user where MATCH(`department_id`) AGAINST(".$res1[0]['id'].") and is_delete=0";
$res2 = Mysql::run_select($sql2);

$departListUser[0]['users'] = $res2;

if($departListUser)EchoJsonData(0,'获取部门人员列表成功!',$departListUser);

?>