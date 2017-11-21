<?php
/**
* 
*/
class Mysql 
{
	
	private static	$DB_IP="rm-vy1sys5beujh24u60.mysql.rds.aliyuncs.com";
	private	static  $DB_Username="penk2015";
	private	static  $DB_Password="PenkAdmin-20151111";
	
	private	static  $DB_Name="yszkserverkf";
	private	static  $DB_Chartype="utf8";


	//函数:run_select
	//参数:string $sql
	//功能:传入select类型的SQL语句字符串,函数将连接数据库并且进行选择库,提交SQL语句,将返回结果分行存入数组变量$return_rs中。当SQL语句报错时返回false;
	//返回:二维数组变量$return_rs,第一下标为行,第二下标为列;提交失败返回false。
	public static function run_select($sql)
	{
		$conn=mysqli_connect(self::$DB_IP,self::$DB_Username,self::$DB_Password,self::$DB_Name);

		mysqli_query($conn,"set names ".self::$DB_Chartype);
		$temp_rs=mysqli_query($conn,$sql) or die("Invalid query: $sql   ERROR MSG: ".mysqli_error($conn));
		if($temp_rs)
		{
			$rs_count=mysqli_num_rows($temp_rs);
			for($j=0;$j<$rs_count;$j++)
			{
				$row=mysqli_fetch_array($temp_rs,MYSQL_ASSOC);
				$return_rs[$j]=$row;
			}
			mysqli_close($conn);
			return $return_rs;
		}
		else
		{
			mysqli_close($conn);
			return false;
		}
	}

	//函数:run_alter
	//参数:string $sql
	//功能:传入update类型的SQL语句字符串,函数将连接数据库并且进行选择库,提交SQL语句,将返回结果分行存入数组变量$return_rs中。当SQL语句报错时返回false;
	//返回:影响的记录数;提交失败返回false。
	public static function run_alter($sql)
	{
		$conn=mysqli_connect(self::$DB_IP,self::$DB_Username,self::$DB_Password,self::$DB_Name);
		mysqli_query($conn,"set names ".self::$DB_Chartype);
		if(mysqli_query($conn,$sql) or die("Invalid query: $sql ERROR MSG: ".mysqli_error($conn)))
		{
			$count=mysqli_affected_rows($conn);
			mysqli_close($conn);
			return $count;
		}
		else
		{
			mysqli_close($conn);
			return false;
		}
	}

	//函数:run_insert
	//参数:string $sql
	//功能:传入insert类型的SQL语句字符串,函数将连接数据库并且进行选择库,提交SQL语句,将返回结果分行存入数组变量$return_rs中。当SQL语句报错时返回false;
	//返回:插入数据行的id;提交失败返回false。
	public static function run_insert($sql)
	{
		$conn=mysqli_connect(self::$DB_IP,self::$DB_Username,self::$DB_Password,self::$DB_Name);
		mysqli_query($conn,"set names ".self::$DB_Chartype);
		if(mysqli_query($conn,$sql) or die("Invalid query: $sql ERROR MSG: ".mysqli_error($conn)))
		{
			$id=mysqli_insert_id($conn);
			mysqli_close($conn);
			return $id;
		}
		else
		{
			mysqli_close($conn);
			return false;
		}
	}
}
