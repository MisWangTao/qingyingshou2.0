<?php

/**
 * 处理日期的方法
 */
function HandleDate($paymentType,$startDate,$endDate)
{

	 $i=0;

	 $sumDays = 0;

	 $dates = array();
	 //每月结算
	 if($paymentType=='1')
	 {

	 	$dates = nextMonthDate($startDate,$endDate);

	 }else if($paymentType=='2')
	 {
	 	$dates = nextSeasonDate($startDate,$endDate);

	 }else if($paymentType=='3')
	 {
	 	$dates = nextYearDate($startDate,$endDate);
	 }

	 return $dates;

}
//传入开始时间和结束时间返回每个月份的结算日期
function nextMonthDate($startDate,$endDate)
{	

	$startYear = substr($startDate,0,4);

	$startMonth = substr($startDate,5,2);

	$startDay = substr($startDate,8,2);

	$endYear = substr($endDate,0,4);

	$endMonth = substr($endDate,5,2);

	$endDay = substr($endDate,8,2);

	//计算循环次数
	if($endYear>$startYear)
	{
		if($endDay >= $startDay)
		{
			$loop = $endMonth-$startMonth+(($endYear-$startYear)*12)+1; 

		}else
		{
			$loop = $endMonth-$startMonth+(($endYear-$startYear)*12);
		}
	}else
	{
		if($endDay >= $startDay)
		{
			$loop = $endMonth-$startMonth+1; 

		}else
		{
			$loop = $endMonth-$startMonth;
		}
	}
	$arr = array();

	for($i=0;$i<$loop;$i++)
	{
		$returnYear = $startYear;
		$returnMonth = $startMonth+$i<10?'0'.($startMonth+$i):$startMonth+$i;
		$returnDay = $startDay<10?'0'.$startDay:$startDay;


		$returnYear = $startYear + intval(($i+$startMonth-1)/12);

		$returnMonth = ($returnMonth)%12 == 0 ? 12 : ($returnMonth)%12;

		$returnMonth = $returnMonth<10?'0'.$returnMonth:$returnMonth;
		
		$day = date("t",strtotime($returnYear.'-'.$returnMonth));

		if($returnDay > $day)
		{
			$returnDay = $day;
		}
		
		$arr[] = $returnYear.'-'.$returnMonth.'-'.$returnDay;
	}
	return $arr;
}
//传入开始时间和结束时间返回每个季度的结算日期
function nextSeasonDate($startDate,$endDate)
{
	$startYear = substr($startDate,0,4);

	$startMonth = substr($startDate,5,2);

	$startDay = substr($startDate,8,2);

	$endYear = substr($endDate,0,4);

	$endMonth = substr($endDate,5,2);

	$endDay = substr($endDate,8,2);

	//计算循环次数
	if($endYear>$startYear)
	{
		if($endDay >= $startDay)
		{
			$loop = intval(($endMonth-$startMonth+(($endYear-$startYear)*12))/3)+1; 

		}else
		{
			$loop = intval(($endMonth-$startMonth+(($endYear-$startYear)*12-1))/3)+1;
		}
	}else
	{
		if($endDay >= $startDay)
		{
			$loop = intval(($endMonth-$startMonth)/3)+1;

		}else
		{
			$loop = intval(($endMonth-$startMonth-1)/3)+1;
		}
	}

	for($i=0;$i<$loop;$i++)
	{
		$returnYear = $startYear;
		
		$returnMonth = $startMonth+3*$i<10?'0'.($startMonth+3*$i):$startMonth+3*$i;
		
		$returnDay = $startDay;

		$returnYear = $startYear + intval((3*$i+$startMonth-1)/12);

		$returnMonth = ($returnMonth)%12 == 0 ? 12 : ($returnMonth)%12;

		$returnMonth = $returnMonth<10?'0'.$returnMonth:$returnMonth;
		
		$day = date("t",strtotime($returnYear.'-'.$returnMonth));

		if($returnDay > $day)
		{
			$returnDay = $day;
		}
		
		$arr[] = $returnYear.'-'.$returnMonth.'-'.$returnDay;
	}
	return $arr;

}
//传入开始时间和结束时间返回每年的结算日期
function nextYearDate($startDate,$endDate)
{
	$startYear = substr($startDate,0,4);

	$startMonth = substr($startDate,5,2);

	$startDay = substr($startDate,8,2);

	$endYear = substr($endDate,0,4);

	$endMonth = substr($endDate,5,2);

	$endDay = substr($endDate,8,2);

	//计算循环次数
	if($endYear>$startYear)
	{
		if($endDay >= $startDay)
		{
			$loop = intval(($endMonth-$startMonth+(($endYear-$startYear)*12))/12)+1; 

		}else
		{
			$loop = intval(($endMonth-$startMonth+(($endYear-$startYear)*12-1))/12)+1;
		}
	}else
	{
		if($endDay >= $startDay)
		{
			$loop = intval(($endMonth-$startMonth)/12)+1;

		}else
		{
			$loop = intval(($endMonth-$startMonth-1)/12)+1;
		}
	}

	for($i=0;$i<$loop;$i++)
	{
		$returnYear = $startYear;
		
		$returnMonth = $startMonth+12*$i<10?'0'.($startMonth+12*$i):$startMonth+12*$i;
		
		$returnDay = $startDay;

		$returnYear = $startYear + intval((12*$i+$startMonth-1)/12);

		$returnMonth = ($returnMonth)%12 == 0 ? 12 : ($returnMonth)%12;

		$returnMonth = $returnMonth<10?'0'.$returnMonth:$returnMonth;
		
		$day = date("t",strtotime($returnYear.'-'.$returnMonth));
		
		if($returnDay > $day)
		{
			$returnDay = $day;
		}
		
		$arr[] = $returnYear.'-'.$returnMonth.'-'.$returnDay;
	}
	return $arr;
}
?>