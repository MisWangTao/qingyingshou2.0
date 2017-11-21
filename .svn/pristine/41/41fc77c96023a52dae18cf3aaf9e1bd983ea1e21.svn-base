<?php
//移动添加回款接口   直接点击保存

require_once(__DIR__ . "/../common/common.php");
require_once ("../../common/function/file.fun.php");
$userinfo = $GLOBALS['userinfo'];

$user_id = $userinfo['id'];

if($user_id==0)EchoJsonData(1,'userId不能为空!');

$is_caiwu = $userinfo['is_caiwu'];

$company_id = $userinfo['company_id'];

$now_time = time();

if($is_caiwu != 1) EchoJsonData(1,'你不是财务额!');

// print_r($userinfo);exit;
$custom_id = I('post.custom_id','i',0);   //接收的custom_id 客户公司的id

if($custom_id==0) EchoJsonData(1,'回款的客户不为空!');

$payment_id = I('post.payment','i',0);  //获取回款方式的id
//$payment_id = 1;

if($payment_id==0) EchoJsonData(1,'回款方式不为空!');

$arrival_amount = I('post.arrival_amount','f',0); //接收回款金额

if($arrival_amount<=0) EchoJsonData(1,'回款金额不能小于0!');

$arrival_date = I('post.arrival_date','s','',true);

if($arrival_date=='')EchoJsonData(1,'回款时间不为空!');

$bill_num = I('post.bill','s','',true);

$remark = I('post.remark','s','',true);

$insert_sql = "insert into receivables(custom_id,company_id,payment_method_id,operate_id,arrival_date,bill_number,arrival_amount,remarks,add_time,update_time,states)
				values($custom_id,$company_id,$payment_id,$user_id,'".$arrival_date."','".$bill_num."','".$arrival_amount."','".$remark."',$now_time,$now_time,1)";

$rece_id = Mysql::run_insert($insert_sql);
$arr = array('custom_id'=>$custom_id,'rece_id'=>$rece_id);
// echo $rece_id;

if(count($_FILES)>0)
{
	foreach($_FILES as $k=>$v)
	{
		uploadFile($v['name'],$v['type'],$v['tmp_name'],$v['error'],$v['size']);
	}
}


if($rece_id)
	EchoJsonData(0,'添加成功!',$arr);
else
	EchoJsonData(1,'添加失败!');
function uploadFile($fileName,$fileType,$fileTmpName,$fileError,$fileSize)
{
	global $custom_id,$company_id,$user_id,$rece_id,$now_time;

	$root     = dirname(dirname(dirname(__FILE__)));

	$path     = "/upload/receivable/".date("Y")."/".date("m")."/";

	$dir      = $root.$path;

	if (!file_exists($dir)){
	    if (!make_dir($dir))
	    {
	        /* 创建目录失败 */
	    }
	}


	$old_name =  substr($fileName,0,strrpos($fileName,'.'));

    $img_name = unique_name($dir);

    $ext      = ".".substr($fileType, strrpos($fileType,'/')+1);

	$filename = $dir.$img_name.$ext;

	$res      = move_uploaded_file($fileTmpName, $filename);

	if($res)
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);

	    $mimetype = finfo_file($finfo, $filename);

	    finfo_close($finfo);

	    $src      = $path.$img_name.$ext;

	    $t_filesize = filesize($filename);

	    $sql = "insert into files(company_id,custom_id,relation_id,relation_type,old_name,src,ext,mime,filesize,add_time,add_userid,update_time)
			values($company_id,$custom_id,$rece_id,2,'".$old_name."','".$src."','".$ext."','".$mimetype."','".$fileSize."',".$now_time.",$user_id,".$now_time.")";

	    $filesId = Mysql::run_insert($sql);
	}



	return $filesId;
}
?>