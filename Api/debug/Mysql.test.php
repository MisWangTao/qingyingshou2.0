<?php

class Mysql 
{
	public static function run_select($sql)
	{
		return self::sql($sql,1);
	}
	public static function run_alter($sql)
	{
		return self::sql($sql,2);
	}
	public static function run_insert($sql)
	{
		return self::sql($sql,3);
	}
	public static function sql($sql,$type){

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,'http://l.paiago.com/Api/debug/sql.php');//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        $headers[] = 'Content-type: application/json; charset=utf-8';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('sql'=>$sql,'type'=>$type)));
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

		if(strpos($data,'Invalid query')){
			exit($data);
		}else{
			return  json_decode($data,true);
		}
	}
}