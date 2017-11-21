<?php

function EchoJsonData($errorCode ,$errorMsg ,$data=false ){

	$response = array();

	$response['code'] = $errorCode;
	$response['msg']  = $errorMsg;
	if( $data !== false ) $response['data'] = $data;
		
	echo json_encode($response, JSON_UNESCAPED_SLASHES);
    exit;
}


function I($methodName ,$dataType = 's' ,$defaultValue = NULL ,$filter=false){

    list($method,$name) =   explode('.',$methodName,2);

    switch(strtolower($method)) {
        case 'get'     :   $input =& $_GET;break;
        case 'post'    :   $input =& $_POST;break;
        case 'input'   :   parse_str(file_get_contents('php://input'), $input);break;
        case 'globals' :   $input =& $GLOBALS;    break;
        default        :   die('错误methodName');
    }

    if(empty($name)) { // 获取全部变量
        $data       =   $input;
    }elseif(isset($input[$name])) { // 取值操作

    	switch (strtolower($dataType)) {
    		case 'i':
    			$data       =   intval($input[$name]);
    			break;
    		case 's':
    			$data       =   strval($input[$name]);
    			break;
    		case 'f':
    			$data       =   floatval($input[$name]);
    			break;
    		
    		default:
    			die('错误dataType');
    	}

        if($filter){
    	    $data = htmlspecialchars($data);
		    // $data = remove_xss($data);
		    $data = addslashes($data);
        }
    }else{ // 变量默认值
        $data       =    isset($defaultValue)?$defaultValue:NULL;
    }
    return $data;
}

function remove_xss($val) {
    // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
    // this prevents some character re-spacing such as <java\0script>
    // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

    // straight replacements, the user should never need these since they're normal characters
    // this prevents like <IMG SRC=@avascript:alert('XSS')>
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        // ;? matches the ;, which is optional
        // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

        // @ @ search for the hex values
        $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
        // @ @ 0{0,7} matches '0' zero to seven times
        $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
    }

    // now the only remaining whitespace attacks are \t, \n, and \r
    $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script',
                  'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut',
             'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate',
             'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut',
             'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend',
             'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange',
             'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete',
             'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover',
             'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange','onreadystatechange',
             'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted',
             'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true; // keep replacing as long as the previous round replaced something
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern .= '|';
                    $pattern .= '|(&#0{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
            $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
            if ($val_before == $val) {
                // no replacements were made, so exit the loop
                $found = false;
            }
        }
    }
    return $val;
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    if($operation == 'DECODE') {
        $string = str_replace('[a]','+',$string);
        $string = str_replace('[b]','&',$string);
        $string = str_replace('[c]','/',$string);
    }
    $ckey_length = 4;
    $key = md5($key ? $key : 'livcmsencryption ');
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {

            return substr($result, 26);
        } else {
            return '';
        }

    } else {
        $ustr = $keyc.str_replace('=', '', base64_encode($result));
        $ustr = str_replace('+','[a]',$ustr);
        $ustr = str_replace('&','[b]',$ustr);
        $ustr = str_replace('/','[c]',$ustr);
        return $ustr;
    }
}

function myGetAllHeaders(){
    if (!function_exists('getallheaders')) {
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }else{
        return getallheaders();
    }

}

function validateToken(){

    $header = myGetAllHeaders();
    $token = $header['Authorization'];
    if(!$token)return false;

    $sql  = "SELECT * FROM company_user WHERE id=$token ";
    $res  = Mysql::run_select($sql);
    $GLOBALS['userinfo'] = $res[0];
    return true;
}

function getCurrentFileName()
{
    $php_self=substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'],'/')+1);
    $php_self=explode(".",$php_self);
    return $php_self[0];
}

function WriteOffContract($contractId){
    
    $now_time = time();

    $sql = "UPDATE verification_paymentplan set delete_time=$now_time WHERE contract_id=$contractId and delete_time is null";
    Mysql::run_alter($sql);
    $sql = "UPDATE  contract_payment_plans  SET planed_money = 0 WHERE  contract_id=$contractId and delete_time is null";
    Mysql::run_alter($sql);

    $sql = " SELECT * FROM verification_contract WHERE  contract_id=$contractId and delete_time is null";
    $conHexRecord = Mysql::run_select($sql);

    $totalHexiao = 0;
    array_walk($conHexRecord, function($value, $key) use (&$totalHexiao){
        $totalHexiao += $value['returning_money'];
    });

    $sql = " SELECT * FROM contract_payment_plans WHERE contract_id=$contractId and delete_time is null ORDER BY plan_date DESC";
    $conPlan = Mysql::run_select($sql);

    foreach ($conHexRecord as $key => &$value) {
        if($totalHexiao<=0)break;
        foreach ($conPlan as $k => &$v) {

            $planyuer = $v['plan_money']-$v['planed_money'];

            if($value['returning_money']<=0 || $totalHexiao<=0 )break;
            if($planyuer<=0)continue;

            $maxhex = $value['returning_money']>=$planyuer?$planyuer:$value['returning_money'];
            $planhx = $maxhex>$totalHexiao?$totalHexiao:$maxhex;

            $sql = " INSERT INTO verification_paymentplan (receivable_id,custom_id,company_id,caozuoren_id,contract_id,vercon_id,return_plan_id,returning_money,returning_time,add_time,update_time) values(".$value['receivable_id'].",".$value['custom_id'].",".$value['company_id'].",".$value['caozuoren_id'].",$contractId,".$value['id'].",".$v['id'].",$planhx,'".$value['returning_time']."','".$value['add_time']."','".$value['update_time']."')";
            Mysql::run_insert($sql);
            $sql = " UPDATE  contract_payment_plans set planed_money=planed_money+$planhx  WHERE id=".$v['id'];
            Mysql::run_alter($sql);

            $value['returning_money'] -= $planhx;
            $totalHexiao              -= $planhx;
            $v['planed_money']        += $planhx;
        }
        if($value['returning_money']){
            $planhx = $value['returning_money'];
            $sql = " INSERT INTO verification_paymentplan (receivable_id,custom_id,company_id,caozuoren_id,contract_id,vercon_id,returning_money,returning_time,add_time,update_time) values(".$value['receivable_id'].",".$value['custom_id'].",".$value['company_id'].",".$value['caozuoren_id'].",$contractId,".$value['id'].",$planhx,'".$value['returning_time']."','".$value['add_time']."','".$value['update_time']."')";
            Mysql::run_insert($sql);
        }
    }
}
