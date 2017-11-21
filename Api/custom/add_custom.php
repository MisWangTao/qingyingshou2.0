<?php
//添加客户信息接口
require_once(__DIR__ . "/../common/common.php");

require_once ("../../common/function/file.fun.php");

$nowtime = time();

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

$companyId = $userinfo['company_id'];

$is_caiwu = $userinfo['is_caiwu'];

$customAdministrator = $userinfo['custom_administrators'];

if(!$customAdministrator)EchoJsonData(2,'非客户管理员不能添加客户!');

$custom_name  = I('post.custom_name','s','',true);

if(!$custom_name)EchoJsonData(3,'客户名称不能为空!');


//客户查重
$sql = "select * from custom_list where company_id=$companyId and delete_time is null";

$res = Mysql::run_select($sql);

$allCompany = array();

foreach($res as $k=>$v)
{
	$allCompany[] = md5($v['custom_name']);
}

if(in_array(md5($custom_name),$allCompany))EchoJsonData(4,'该客户已添加,请重新添加!');

$custom_number = I('post.custom_number','s','',true);

$custom_nature = I('post.custom_nature','i','NULL',true);

$industryId = I('post.industry_id','i','NULL',true);

$custom_address = I('post.custom_address','s','',true);

$type = I('post.type','i','NULL',true);

$dateType = I('post.date_type','i','NULL',true);

$date = I('post.date','i','NULL',true);

//负责人
$followArr = !empty($_POST['fuzeren'])?json_decode($_POST['fuzeren'],true):"";

if(!$followArr)EchoJsonData(5,'负责人不能为空!');

$invoice_header = I('post.invoice_header','s','',true);

$taxpayr_number = I('post.payer_id','s','',true);

$bankName = I('post.bankName','s','',true);

$bankNumber = I('post.bank_number','s','',true);

$address = I('post.address','s','',true);

$tel = I('post.tel','s','',true);

$file = I('post.file','s','',true);

// $file = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAIAAAACCAYAAABytg0kAAAAFklEQVQImWOU6Ln1n4HhPwPLfyABAgA+PwWAOx+VvQAAAABJRU5ErkJggg==";

// $img = base64_decode($file);
if($file){
$arr_file = explode(';base64,', $file);

$file1 = $arr_file[0];

$file = $arr_file[1];

$img_type_arr = explode('/', $file1);

$img_type = $img_type_arr[1];

if(!$img_type)$img_type = 'jpg';

$img = str_replace('data:image/png;base64,', '', $file);
$img = str_replace(' ', '+', $img);
$img = base64_decode($img);


$root     = dirname(dirname(dirname(__FILE__)));

$path     = "/upload/custom_logo/".date("Y")."/".date("m")."/";

$dir = $root.$path;

if (!file_exists($dir)){
	    if (!make_dir($dir))
	    {
	        /* 创建目录失败 */
	    }
	}


$filename = unique_name($dir).'.'.$img_type;

// $dir      = $root.$path;
// echo $filename;


$src = $dir.$filename;

file_put_contents($src, $img);


$src_to_server = $path.$filename;
}else{
	$src_to_server = null;
}

// echo $src_to_server;

$sql = "insert into custom_list(custom_name,custom_number,custom_nature,industry_id,custom_address,type,date_type,date,invoice_header,taxpayer_identification_number,bank_name,bank_account_number,address,tel,logo,add_time,update_time,company_id,user_id,update_userid)
		values('".trim($custom_name)."','".trim($custom_number)."',".trim($custom_nature).",".$industryId.",'".trim($custom_address)."',".$type.",".$dateType.",".$date.",'".trim($invoice_header)."','".trim($taxpayr_number)."','".trim($bankName)."','".trim($bankNumber)."','".trim($address)."','".trim($tel)."','$src_to_server',$nowtime,$nowtime,$companyId,$userId,$userId)";

$customId =  Mysql::run_insert($sql);

if($customId>0)
{
	foreach($followArr as $k=>$v)
	{
		$depart_sql = " select id from company_depart where ding_id=".$v['ding_id']." and delete_time is null";

		$departId = Mysql::run_select($depart_sql);

		$sql = "insert into customer_leader(custom_id,company_id,user_id,depart_id,add_time,update_time)
		   values($customId,$companyId,".$v['id'].",".$departId[0]['id'].",$nowtime,$nowtime)";
		$learderId = Mysql::run_insert($sql);
	}
}


$where = '';
if($is_caiwu!=1){
	$where = " and customer_leader.user_id=$userId";
}else{
	$where = '';
}

$sql = "select custom_list.id,custom_name,
custom_nature,custom_industry.`industry_name`,logo,from_unixtime(custom_list.add_time,'%Y-%m-%d') as add_time
from custom_list
left join custom_industry on custom_list.`industry_id` =`custom_industry`.id
left join customer_leader on customer_leader.custom_id = custom_list.id
where custom_list.company_id=$companyId and customer_leader.company_id=$companyId and custom_list.delete_time is null and customer_leader.delete_time is null".$where." group by custom_list.id order by custom_list.update_time desc";

$res = Mysql::run_select($sql);

$res = count($res)?$res:array();



if($learderId>0)
	EchoJsonData(0,'客户添加成功!',$res);
else
	EchoJsonData(1,'客户添加失败!');
?>