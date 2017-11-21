<?php

require_once(__DIR__ . "/../common/common.php");


$request = json_decode(file_get_contents('php://input'),true);
$sql  = $request['sql'];
$type = $request['type'];

if($type=='1'){
	$res = Mysql::run_select($sql);
}elseif ($type=='2') {
	$res = Mysql::run_alter($sql);
}elseif ($type=='3') {
	$res = Mysql::run_insert($sql);
}


echo json_encode($res, JSON_UNESCAPED_SLASHES);