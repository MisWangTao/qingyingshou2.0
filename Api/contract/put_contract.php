<?php
//编辑合同接口
require_once(__DIR__."/../common/common.php");

require_once ("../../common/function/file.fun.php");

$userInfo = $GLOBALS['userinfo'];

$userId = $userInfo['id'];

$realname = $userInfo['realname'];

$is_caiwu = $userinfo['is_caiwu'];

if($userId=='')EchoJsonData(1,'userId不能为空!');

$companyId = $userInfo['company_id'];
/*---------------公共参数---------------*/
$contractId = I('post.contract_id','i',NULL,true);

$contractName = I('post.contract_name','s','',true);

$contractNumber = I('post.contract_number','s','',true);

$customId = I('post.custom_id','i',NULL,true);

$labelId = I('post.label_id','s','',true);
//合同日期
$contractDate = I('post.contract_date','s','',true);
//合同备注
$remark = I('post.remark','s','',true);
//货币id
$currencyId = I('post.currency_id','i',NULL,true);

$linkMan = I('post.linkman','s','',true);

$tel = I('post.tel','s','',true);
//跟进人Id
$followupId = I('post.followup','s','',true);
//部门Id
$departId = I('post.depart_id','i','NULL',true);
//到期日期
$maturity_date = I('post.maturity_date','s','',true);
//金额
$contractMoney = I('post.contract_money','f','NULL',true);
/*---------------周期---------------*/
//回款周期1:每月,2:每季度,3:每年
$paymentCycle = I('post.payment_cycle','i','NULL',true);
//首次收款日期
$firstPayment = I('post.firstPayment','s','',true);
//每期金额
$each_money = I('post.each_money','f','NULL',true);
//是否提醒
$expirationReminder = I('post.expiration_reminder','i','NULL',true);
//提前几天
$advanceRemind =  I('post.advance_remind','i','',true);
/*---------------框架---------------*/
//预收款
$advanceMoney = I('post.advance_money','f','NULL',true);
//收款方式
$paymentType = I('post.payment_type','i','NULL',true);
//每月或
$eachMonth =  I('post.each_month','i','NULL',true);
//每日
$eachDay = I('post.each_day','i','NULL',true);

if($followupId=='')EchoJsonData(2,'跟进人不能为空!');

$nowtime = time();

//先查询数据对比修改
$search_contract_sql = "SELECT contract_name,
       contract_date,
       contract_money,
       contract_number,
       contract_type,
       label_id,
       custom_id,
       currency_id,
       linkman,maturity_date,
       tel,followup_id,
       followup_depart,
       (select dapart_name from company_depart where contract_list.`followup_depart`  = company_depart.id ) as depart_name,
       (select realname from company_user where company_user.id=contract_list.followup_id and company_user.is_delete =0) as genjinren,remark,payment_cycle,first_date_payment,each_money,cycle,expiration_reminder,advance_remind,
       (
SELECT realname
  FROM `company_user`
 WHERE `company_user` .id= `contract_list` .user_id
   and `company_user` . `is_delete` =0) AS creatname,FROM_UNIXTIME(add_time,'%Y-%m-%d') AS creattime,
         (
SELECT custom_name
  FROM `custom_list`
 WHERE `custom_list` .id= `contract_list` .custom_id
   and `custom_list` .delete_time is null) AS custom_name
  FROM `contract_list`
 WHERE `id`= $contractId";

$old_contract = Mysql::run_select($search_contract_sql)[0];

$res_label_id = $old_contract['label_id'];


if($res_label_id)
{
  $label_sql = "SELECT id,label_name FROM `contract_label` WHERE `id` IN (".$res_label_id.") and `delete_time` is null";

  $res_label = Mysql::run_select($label_sql);

}else{

  $res_label = array();
}

$old_contract['label'] = $res_label;

$old_contract['follow'] = $res_follow;

$news_contract = array();

//查询附件
$files_sql = "select id,old_name,src,ext,mime from files where relation_id=$contractId and relation_type=1 and company_id=$companyId and custom_id=$customId
and delete_time is null";
// var_dump($files_sql);
$files = Mysql::run_select($files_sql);
// var_dump($files);
//公用参数
//合同名称、合同标签、跟进人、备注、附件

$olds_contract['contract_name'] = $old_contract['contract_name'];

$olds_contract['label_id'] = $old_contract['label_id'];

$olds_contract['followup_id'] = $old_contract['followup_id'];

// $olds_contract['followup_depart'] = $old_contract['followup_depart'];

$olds_contract['remark'] = $old_contract['remark'];

// $olds_contract['files'] = $files?$files:array();
//
foreach($files as $k=>$v)
{
	$oldFile[$v['id']] = $v['src'];
}

$news_contract['contract_name'] = $contractName;

$news_contract['label_id'] = $labelId;

$sql3 = "select realname from company_user where id=$followupId";

$res3 = Mysql::run_select($sql3);

$genjinren = $res3[0]['realname'];

$news_contract['followup_id'] = $followupId;

$news_contract['remark'] = $remark;

//所有的图片
$imagesArr = json_decode($_POST['oldArr'],true);

$newFile = array();

foreach($imagesArr as $k=>$v)
{
	$newFile[] = str_replace("https://l.paiago.com","",$v);
}

$editObj = array();

//判断该笔合同是否有过到账
$sql = "select ifnull(sum(`returning_money`),0) as daozhang from verification_contract where company_id=$companyId and contract_id=$contractId and delete_time is null";

$daozhang = Mysql::run_select($sql)[0]['daozhang'];


//有到账
if($daozhang>0)
{
	//合同类型1:一般合同,2:周期合同,3:框架合同..

	$olds_contract['maturity_date']=$old_contract['maturity_date'];

	$news_contract['maturity_date']=$maturity_date;

	$result = array_diff_assoc($news_contract,$olds_contract);

	$where = "";

	// var_dump($result);

	if(count($result)>0)
	{
		foreach($result as $k=>$v)
		{
			if($k=='contract_name')
			{
				$editObj[] = "合同名称:".$olds_contract['contract_name']." 修改为:".$news_contract['contract_name'];
				$where.="contract_name='".$news_contract['contract_name']."',";

			}else if($k=='label_id')
			{
				$sql = "select label_name from contract_label where id in(".$olds_contract['label_id'].")";
				$old_label = Mysql::run_select($sql);
				foreach($old_label as $k=>$v)
				{
					$olds_label[] = $v['label_name'];
				}
				$olds_label = implode(",",$olds_label);
				$sql = "select label_name from contract_label where id in(".$news_contract['label_id'].")";
				$new_label = Mysql::run_select($sql);
				foreach($new_label as $k=>$v)
				{
					$news_label[] = $v['label_name'];
				}
				$news_label = implode(",",$news_label);

				$editObj[] = "标签名称:".$olds_label." 修改为:".$news_label;
				$where.="label_id='".$news_contract['label_id']."',";

			}else if($k=='followup_id')
			{
				$editObj[] = "跟进人:".$olds_contract['followup_id']." 修改为:".$news_contract['followup_id'];
				$where.="followup_id='".$news_contract['followup_id']."',";

			}else if($k=='remark')
			{
				$editObj[] = "备注:".$olds_contract['remark']." 修改为:".$news_contract['remark'];
				$where.="remark='".$news_contract['remark']."',";
			}
		}
	}
	$sql = "update contract_list set $where update_time=$nowtime,update_userid=$userId where delete_time is null and id=$contractId";

	$res = Mysql::run_alter($sql);

}else{
	//无回款的公共部分
	$olds_contract['contract_number'] = $old_contract['contract_number'];
	$olds_contract['custom_id'] = $old_contract['custom_id'];
	$olds_contract['contract_date'] = $old_contract['contract_date'];
	$olds_contract['maturity_date'] = $old_contract['maturity_date'];
	$olds_contract['linkman'] =  $old_contract['linkman'];
	$olds_contract['tel'] = $old_contract['tel'];

	$news_contract['contract_number'] = $contractNumber;
	$news_contract['custom_id'] = $customId;
	$news_contract['contract_date'] = $contractDate;
	$news_contract['maturity_date'] = $maturity_date;
	$news_contract['linkman'] = $linkMan;
	$news_contract['tel'] = $tel;

	if($old_contract['contract_type']=='1')
	{
		$olds_contract['contract_money'] = floatval($old_contract['contract_money']);
		$olds_contract['currency_id'] = $old_contract['currency_id'];
		// var_dump($olds_contract);

		$news_contract['contract_money'] = $contractMoney;
		$news_contract['currency_id'] = $currencyId;
		// var_dump($news_contract);

	}else if($old_contract['contract_type']=='2')
	{
		$olds_contract['contract_money'] = floatval($old_contract['contract_money']);
		$olds_contract['payment_cycle'] = $old_contract['payment_cycle'];
		$olds_contract['first_date_payment'] = $old_contract['first_date_payment'];
		$olds_contract['each_money'] =  floatval($old_contract['each_money']);
		$olds_contract['cycle'] = $old_contract['cycle'];
		$olds_contract['expiration_reminder'] = $old_contract['expiration_reminder'];
		$olds_contract['advance_remind'] = $old_contract['advance_remind'];

		// var_dump($olds_contract);
		$news_contract['contract_money'] = $contractMoney;
		$news_contract['payment_cycle'] = $paymentCycle;
		$news_contract['first_date_payment'] = $firstPayment;
		$news_contract['each_money'] =  $each_money;
		$news_contract['cycle'] = I('post.cycle','i','NULL',true);
		$news_contract['expiration_reminder'] = $expirationReminder;
		$news_contract['advance_remind'] = $advanceRemind;
		// var_dump($news_contract);

	}else if($old_contract['contract_type']=='3')
	{
		//预收款
		$olds_contract['advance_money'] = $old_contract['payment_cycle'];
		$olds_contract['payment_type'] = $old_contract['payment_type'];
		$olds_contract['each_month'] =  $old_contract['each_month'];
		$olds_contract['each_day'] = $old_contract['each_day'];
		// var_dump($olds_contract);
		$news_contract['advance_money'] = $advanceMoney;
		$news_contract['payment_type'] = $paymentType;
		$news_contract['each_month'] =  $eachMonth;
		$news_contract['each_day'] = $eachDay;
		// var_dump($news_contract);
	}
	$result = array_diff_assoc($news_contract,$olds_contract);

	$where = "";
	//对比差异
	foreach($result as $k=>$v)
	{
		if($k=='contract_name')
		{
			$editObj[] = "合同名称:".$olds_contract['contract_name']." 修改为:".$news_contract['contract_name'];
			$where.="contract_name='".$news_contract['contract_name']."',";

		}else if($k=='contract_number')
		{
			$editObj[] = "合同编号:".$olds_contract['contract_number']." 修改为:".$news_contract['contract_number'];
			$where.="contract_number='".$news_contract['contract_number']."',";

		}else if($k=='custom_id')
		{
			$sql = "select custom_name from custom_list where id=".$olds_contract['custom_id'];
			$old_custom_name = Mysql::run_select($sql)[0]['custom_name'];
			$sql = "select custom_name from custom_list where id=".$news_contract['custom_id'];
			$new_custom_name = Mysql::run_select($sql)[0]['custom_name'];
			$editObj[] = "客户名称:".$old_custom_name." 修改为:".$new_custom_name;
			$where.="custom_id='".$news_contract['custom_id']."',";

		}else if($k=='label_id')
		{
			$sql = "select label_name from contract_label where id in(".$olds_contract['label_id'].")";
			$old_label = Mysql::run_select($sql);
			foreach($old_label as $k=>$v)
			{
				$olds_label[] = $v['label_name'];
			}
			$olds_label = implode(",",$olds_label);
			$sql = "select label_name from contract_label where id in(".$news_contract['label_id'].")";
			$new_label = Mysql::run_select($sql);
			foreach($new_label as $k=>$v)
			{
				$news_label[] = $v['label_name'];
			}
			$news_label = implode(",",$news_label);

			$editObj[] = "标签名称:".$olds_label." 修改为:".$news_label;
			$where.="label_id='".$news_contract['label_id']."',";

		}else if($k=='contract_date')
		{
			$editObj[] = "合同日期:".$olds_contract['contract_date']." 修改为:".$news_contract['contract_date'];
			$where.="contract_date='".$news_contract['contract_date']."',";

		}else if($k=='maturity_date')
		{
			$editObj[] = "到期日期:".$olds_contract['maturity_date']." 修改为:".$news_contract['maturity_date'];
			$where.="maturity_date='".$news_contract['maturity_date']."',";

		}else if($k=='contract_money')
		{
			$editObj[] = "合同金额:".number_format($olds_contract['contract_money'],2)." 修改为:".number_format($news_contract['contract_money'],2);
			$where.="contract_money='".$news_contract['contract_money']."',";

		}else if($k=='payment_cycle')
		{
			$olds_contract['payment_cycle'] = $olds_contract['payment_cycle']==1?'每月':$olds_contract['payment_cycle']==2?'每季':$olds_contract['payment_cycle']==3?'每年':'';
			$str = $news_contract['payment_cycle']==1?'每月':$news_contract['payment_cycle']==2?'每季':$news_contract['payment_cycle']==3?'每年':'';
			$editObj[] = "回款周期:".$olds_contract['payment_cycle']." 修改为:".$str;
			$where.="payment_cycle='".$news_contract['payment_cycle']."',";

		}else if($k=='first_date_payment')
		{
			$editObj[] = "首次收款日期:".$olds_contract['first_date_payment']." 修改为:".$news_contract['first_date_payment'];
			$where.="first_date_payment='".$news_contract['first_date_payment']."',";

		}else if($k=='each_money')
		{
			$editObj[] = "每期金额:".number_format($olds_contract['each_money'],2)." 修改为:".number_format($news_contract['each_money'],2);
			$where.="each_money='".$news_contract['each_money']."',";

		}else if($k=='expiration_reminder')
		{
			$editObj[] = "周期提醒:".$olds_contract['expiration_reminder']." 修改为:".$news_contract['expiration_reminder'];
			$where.="expiration_reminder='".$news_contract['expiration_reminder']."',";

		}else if($k=='advance_remind')
		{
			$editObj[] = "提前:".$olds_contract['expiration_reminder']."天,修改为:提前:".$news_contract['expiration_reminder']."天";
			$where.="advance_remind='".$news_contract['advance_remind']."',";

		}else if($k=='advance_money')
		{
			$editObj[] = "预收款:".$olds_contract['advance_money']." 修改为:".$news_contract['advance_money'];

		}else if($k=='payment_type')
		{
			//swith case
			$editObj[] = "收款方式:".$olds_contract['expiration_reminder']." 修改为:".$news_contract['expiration_reminder'];
			$where.="payment_type='".$news_contract['payment_type']."',";

		}else if($k=='linkman')
		{
			$editObj[] = "联系人:".$olds_contract['linkman']." 修改为:".$news_contract['linkman'];
			$where.="linkman='".$news_contract['linkman']."',";

		}else if($k=='tel')
		{
			$editObj[] = "电话:".$olds_contract['tel']." 修改为:".$news_contract['tel'];
			$where.="tel='".$news_contract['tel']."',";

		}else if($k=='followup_id')
		{
			$editObj[] = "跟进人:".$olds_contract['followup_id']." 修改为:".$news_contract['followup_id'];
			$where.="followup_id='".$news_contract['followup_id']."',";

		}else if($k=='remark')
		{
			$editObj[] = "备注:".$olds_contract['remark']." 修改为:".$news_contract['remark'];
			$where.="remark='".$news_contract['remark']."',";
		}

	}

	if($old_contract['contract_type'] =='2')
	{
		if($result['first_date_payment'] || $result['payment_cycle'] || $result['maturity_date'])
		{
			$sql = "update contract_payment_plans set delete_time=$nowtime where contract_id=$contractId and company_id=$companyId and delete_time is null";
			$rs = Mysql::run_alter($sql);

			if($rs>0)
			{	

				$dates = HandleDate($news_contract['payment_cycle'],$news_contract['first_date_payment'],$news_contract['maturity_date']);
			}
			foreach($dates as $k1=>$v1)
			{
				$sql1 = "insert into contract_payment_plans (contract_id,company_id,plan_date,plan_money,add_time,update_time)
					values(".$contractId.",".$companyId.",'".$v1."',".$news_contract['each_money'].",$nowtime,$nowtime)";
				$res1 = Mysql::run_insert($sql1);
			}
		}

	}

	$sql = "update contract_list set $where update_time=$nowtime,update_userid=$userId where delete_time is null and id=$contractId";

	$res = Mysql::run_alter($sql);
}

	//删除图片的数组
	$fileId = array();

	foreach($oldFile as $k=>$v)
	{
		if(in_array($v,$newFile)==false)
		{
			$fileId[] = $k;
		}
	}
	if($_FILES)
	{
		foreach($_FILES as $k=>$v)
		{
			$filesId = insertFiles($v['name'],$v['type'],$v['tmp_name'],$v['error'],$v['size']);

			if($filesId>0){
				$editObj[] = $realname.",". date('Y-m-d H:i:s').",添加了一个附件";
			}else{
				EchoJsonData(10,'附件添加失败!');
			}

		}
	}
	//如果存在执行删除操作
	if($fileId)
	{
		// echo 22;
		foreach($fileId as $k=>$v)
		{
			$delId = deleteFiles($v);

			if($delId>0){
				$editObj[] = $realname.",". date('Y-m-d H:i:s').",删除了一个附件";
			}else{
				EchoJsonData(11,'附件删除失败!');
			}
		}
	}

$desc = addslashes(json_encode(implode(",",$editObj),true));

$sql = "insert into timeaxis(company_id,contract_id,des,user_id,type,add_time,update_time)
			values($companyId,$contractId,'".$desc."',$userId,1,$nowtime,$nowtime)";
$insertTimeAxis = Mysql::run_insert($sql);

$where = '';
if($is_caiwu!=1){
  $where = " and followup_id=$userId ";
}


$sql = "select contract_list.`id`,
       contract_list.`contract_name`,
      b.`custom_name` ,
       contract_list.`contract_money`,
       contract_list.`contract_date`,
       contract_list.`contract_type`,
     contract_list.`label_id`,
     contracted_money as verification_money,
     ifnull((select SUM(arrival_amount) from verification_contract where contract_list.`id`=verification_contract.contract_id and verification_contract.delete_time is null),0) as arrival_amount
  from contract_list
  left join custom_list as b on contract_list.custom_id= b .id
   and b.delete_time is null
 where contract_list.company_id=$companyId
   and contract_list.delete_time is null".$where."
   order by contract_list.update_time desc";

$res = Mysql::run_select($sql);
$result = array();

  foreach($res as $k=>$v)
  {
    $labels_name = array();
		$result['htje'] += $v['contract_money'];
		$result['hxje'] += $v['verification_money'];
		$result['arrival_amount'] += $v['arrival_amount'];
    if($v['label_id']!='')
    {
       $sql = "select label_name from contract_label where id in (".$v['label_id'].")";
       // var_dump($sql);
      $rs = Mysql::run_select($sql);

      $labels_name = $rs;

      $res[$k]['label_name'] = $labels_name;

    }else{
      $res[$k]['label_name'] = array();
    }
  }

$result['ysye'] = $result['htje'] - $result['hxje'];

$conteact_list = count($res)>0?$res:array();

$response = array();

if($insertTimeAxis>0)
{
 	$response['code'] = 0;
	$response['msg']   = '成功!';
	$response['data']  = $conteact_list;
	$response['result']  = $result;

}else{
  	$response['code'] = 1;
	$response['msg']   = '插入失败!';
	
}

echo json_encode($response,JSON_UNESCAPED_SLASHES);



function insertFiles($fileName,$fileType,$fileTmpName,$fileError,$fileSize)
{
	global $customId,$companyId,$userId,$contractId,$nowtime;

	$root     = dirname(dirname(dirname(__FILE__)));

	$path     = "/upload/contract/".date("Y")."/".date("m")."/";

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
			values($companyId,$customId,$contractId,1,'".$old_name."','".$src."','".$ext."','".$mimetype."','".$fileSize."',".$nowtime.",$userId,".$nowtime.")";

	    $filesId = Mysql::run_insert($sql);
	}

	return $filesId;
}

function deleteFiles($fileId)
{
	global $userId,$nowtime;

	$sql = "update files set delete_time=$nowtime,delete_userid=$userId where id=$fileId";
	$res = Mysql::run_alter($sql);
	return $res;
}

function returnTwoDimensionalDiffentData($oldArr,$newArr)
{
	$editPlanId = array();
	$returnArr = array();
	//type==1新增,type==2修改,type==3删除
	foreach($oldArr as $k=>$v)
	{
		foreach($newArr as $k1=>$v1)
		{
			if($v1['id']!=''){

				$editPlanId[] = $v1['id'];
			}

			if($v['id']==$v1['id'])
			{

				$rs = array_diff_assoc($v1,$v);
				// var_dump($rs);
				if(count($rs)>0){
					$rs['id'] = $v['id'];
					$rs['status'] = 2;
					$returnArr[] = $rs;
				}

			}
		}
	}

	foreach($newArr as $k=>$v)
	{
		if($v['id']=='')
		{
			$returnArr[]=$v;
		}
	}

	$editPlanId = array_unique($editPlanId);
	// var_dump($returnArr);
	foreach($oldArr as $k=>$v)
	{
		if(!in_array($v['id'],$editPlanId))
		{
			$returnArr[] = $v;
		}
	}

	foreach($returnArr as $k=>$v)
	{
		if($v['id']=='')
		{
			$returnArr[$k]['status'] = 1;

		}else if($v['id']!='' && $v['type']=='')
		{
			$returnArr[$k]['status'] = 3;
		}
	}
	return $returnArr;
}

?>