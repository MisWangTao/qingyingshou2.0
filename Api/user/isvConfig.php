<?php

require_once(__DIR__ . "/../common/common.php");
require_once(__DIR__ . "/../../ding/api/Auth.php");

$corpid = $_GET["corpid"];
$url    = $_GET["url"];

foreach ($_GET as $key => $value) {
	if($key!='url')$url.="&$key=$value";
}

if($corpid && $url){
	echo Auth::isvConfig($corpid,$url);
}else{
	echo "{}";
}