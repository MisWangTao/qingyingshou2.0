<?php

//客户信息修改
require_once(__DIR__ . "/../common/common.php");

require_once ("../../common/function/file.fun.php");

$userinfo = $GLOBALS['userinfo'];

$userId = $userinfo['id'];

if($userId==0)EchoJsonData(1,'userId不能为空!');

$company_id = $userinfo['company_id'];

$is_caiwu = $userinfo['is_caiwu'];

$now_time = time();

$id = I('post.id','i','NULL',true);//id  修改的对应数据的 id

if($id=='NULL')EchoJsonData(2,'客户Id不能为空!');

$custom_name  = I('post.custom_name','s','',true);

if(!$custom_name)EchoJsonData(3,'客户名称不能为空!');

$custom_number = I('post.custom_number','s','',true);

$custom_nature = I('post.custom_nature','i','NULL',true);

$industryId = I('post.industry_id','i','NULL',true);

$custom_address = I('post.bangongdizhi','s','',true);

//$type = I('post.type','i',NULL,true);

$dateType = I('post.date_type','i','NULL',true);
// if(!$dateType)$dateType=08;
$date = I('post.date','i','NULL',true);
// if(!$date)$date=08;
//$dingUserId = I('post.ding_userid','s','',true);
//// if(!$dingUserId)$dingUserId = 4;
//if($dingUserId =='')EchoJsonData(4,'负责人不能为空!');

$invoice_header = I('post.fapiaotaitou','s','',true);

$taxpayr_number = I('post.payer_id','s','',true);

$bankName = I('post.bank_name','s','',true);

$bankNumber = I('post.bank_number','s','',true);

$address = I('post.address','s','',true);

$tel = I('post.tel','s','',true);

$file = I('post.logo','s','',true);


$edit_custom_sql = "update custom_list set custom_name= '".$custom_name."',custom_number='".$custom_number."',custom_nature='".$custom_nature."',industry_id='".$industryId."',custom_address='".$custom_address."',date_type='".$dateType."',date='".$date."',invoice_header='".$invoice_header."',taxpayer_identification_number='".$taxpayr_number."',bank_name='".$bankName."' ,bank_account_number='".$bankNumber."',address='".$address."',tel='".$tel."',update_time='".$now_time."',update_userid='".$userId."' where id=$id and company_id=$company_id";


//echo $edit_custom_sql;

$res = Mysql::run_alter($edit_custom_sql);

$sql = "select logo from custom_list where id=$id and company_id=$company_id";

$logo = Mysql::run_select($sql)[0]['logo'];

$where = '';
if($is_caiwu!=1){
	$where = " and customer_leader.user_id=$userId";
}else{
	$where = '';
}

$sql1 = "select custom_list.id,custom_name,
custom_nature,custom_industry.`industry_name`,logo,from_unixtime(custom_list.add_time,'%Y-%m-%d') as add_time
from custom_list
left join custom_industry on custom_list.`industry_id` =`custom_industry`.id
left join customer_leader on customer_leader.custom_id = custom_list.id
where custom_list.company_id=$company_id and customer_leader.company_id=$company_id and custom_list.delete_time is null and customer_leader.delete_time is null".$where." group by custom_list.id order by custom_list.update_time desc";

$res1 = Mysql::run_select($sql1);

$res1 = count($res1)?$res1:array();




if(!preg_match("(/upload/custom_logo/)", $file)&&$file!=''){
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

	$edit_file_sql = "update custom_list set logo='".$src_to_server."' where id=$id and company_id=$company_id";
	$res_file = Mysql::run_alter($edit_file_sql);

//	if()
	if($res_file)
		EchoJsonData(0,'信息修改成功!',$res1);
	else
		EchoJsonData(-1,'信息修改失败!');

}



//echo $res;exit;








if($res)
	EchoJsonData(0,'客户信息修改成功!',$res1);
else
	EchoJsonData(-1,'客户信息修改失败!');








//if($file){
//
//}









?>