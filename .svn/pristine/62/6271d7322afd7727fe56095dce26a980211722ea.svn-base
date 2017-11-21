<?php
require_once(__DIR__ . "/../util/Log.php");
require_once(__DIR__ . "/../util/Http.php");
require_once(__DIR__ . "/../util/Cache.php");
require_once(__DIR__ . "/../util/Mysql.php");
require_once(__DIR__ . "/Department.php");
/**
 * ISV授权方法类
 */
class ISVService
{
    public static function getSuiteAccessToken($suiteTicket)
    {
        $suiteAccessToken = Cache::getSuiteAccessToken();
	    if (!$suiteAccessToken)
        {
            $response = Http::post("/service/get_suite_token",
                null,
                json_encode(array(
                    "suite_key" => SUITE_KEY,
                    "suite_secret" => SUITE_SECRET,
                    "suite_ticket" => $suiteTicket
                )));
            self::check($response);
            $suiteAccessToken = $response->suite_access_token;
            Cache::setSuiteAccessToken($suiteAccessToken);
        }
        return $suiteAccessToken;
    }

    public static function getCorpInfoByCorId($corpId){
        $corpInfo = Cache::getCorpInfo($corpId);

         if(!$corpInfo){
            $permanent = Mysql::run_select("select * from company_list where corpid='".$corpId."'");
            $permanent_code  = $permanent[0]['permanent_code'];
            $corp_id  = $permanent[0]['corpid'];
            $corp_name  = $permanent[0]['custom_name'];
            $corpInfo = array();
            $corpInfo['permanent_code'] = $permanent_code;
            $corpInfo['corp_id'] = $corp_id;
            $corpInfo['corp_name'] = $corp_name;

            Cache::setCorpInfo($corpId,$corpInfo);   
        }
        
        return $corpInfo;
    }
    public static function getCorpInfoByTmpCode($code){
        return Cache::getCorpInfoByTmpCode($code);
    }

    public static function getPermanentCodeInfo($suiteAccessToken,$tmpAuthCode)
    {
        $permanentCodeInfo = json_decode(ISVService::getCorpInfoByTmpCode($tmpAuthCode));

        if (!$permanentCodeInfo)
        {
            $permanentCodeResult = Http::post("/service/get_permanent_code",
                array(
                    "suite_access_token" => $suiteAccessToken
                ), 
                json_encode(array(
                    "tmp_auth_code" => $tmpAuthCode
                )));
            self::check($permanentCodeResult);
            $permanentCodeInfo = self::savePermanentCodeInfo($permanentCodeResult,$tmpAuthCode);
        }
        return $permanentCodeInfo;
    }

    public static function savePermanentCodeInfo($permanentCodeInfo,$tmpAuthCode){
        $arr = array();
        $arr['corp_name'] = $permanentCodeInfo->auth_corp_info->corp_name;
        $arr['corp_id'] = $permanentCodeInfo->auth_corp_info->corpid;
        $arr['permanent_code'] = $permanentCodeInfo->permanent_code;
        $arr['tmp_auth_code'] = $tmpAuthCode;
        Cache::setCorpInfo($arr['corp_id'],$arr);
        Cache::setCorpInfoByTmpCode($tmpAuthCode,$arr);
        return $arr;
    }

    public static function getCurAgentId($corpId,$appId){
        $authInfo = json_decode(Cache::getAuthInfo("corpAuthInfo_".$corpId));
        $agents = $authInfo->agent;
        $agentId = 0;
        foreach($agents as $agent){
            if($agent->appid==$appId){
                $agentId = $agent->agentid;
                break;
            }
        }
	Log::i("[AGENTID]".$corpId."-----".$appId."-----".$agentId);
        return $agentId;
    }

    public static function getIsvCorpAccessToken($suiteAccessToken, $authCorpId, $permanentCode)
    {
        $key = "IsvCorpAccessToken_".$authCorpId;
        $corpAccessToken = Cache::getIsvCorpAccessToken($key);
        if (!$corpAccessToken)
        {
            $response = Http::post("/service/get_corp_token",
                array(
                    "suite_access_token" => $suiteAccessToken
                ),
                json_encode(array(
                    "auth_corpid" => $authCorpId,
                    "permanent_code" => $permanentCode
                )));
            if($response->errcode != 0){
                return '';
            }
            self::check($response);
            $corpAccessToken = $response->access_token;
            Cache::setIsvCorpAccessToken($key,$corpAccessToken);
        }
        return $corpAccessToken;
    }

    public static function getAuthInfo($suiteAccessToken, $authCorpId, $permanentCode)
    {
        $authInfo = json_decode(Cache::getAuthInfo("corpAuthInfo_".$authCorpId));
        if (!$authInfo)
        {
            $authInfo = Http::post("/service/get_auth_info",
                array(
                    "suite_access_token" => $suiteAccessToken
                ),
                json_encode(array(
                    "suite_key" => SUITE_KEY,
                    "auth_corpid" => $authCorpId,
                    "permanent_code" => $permanentCode
                )));
            self::check($authInfo);
            Cache::setAuthInfo("corpAuthInfo_".$authCorpId,json_encode($authInfo->auth_info));
        }

        return $authInfo;
    }
    public static function getAuthInfo2($suiteAccessToken, $authCorpId, $permanentCode)
    {
        $authInfo = Http::post("/service/get_auth_info",
            array(
                "suite_access_token" => $suiteAccessToken
            ),
            json_encode(array(
                "suite_key" => SUITE_KEY,
                "auth_corpid" => $authCorpId,
                "permanent_code" => $permanentCode
            )));
        self::check($authInfo);
        Cache::setAuthInfo("corpAuthInfo_".$authCorpId,json_encode($authInfo->auth_info));
        
        return $authInfo;
    }
    
    
    public static function getAgent($suiteAccessToken, $authCorpId, $permanentCode, $agentId)
    {
        $response = Http::post("/service/get_agent", 
            array(
                "suite_access_token" => $suiteAccessToken
            ), 
            json_encode(array(
                "suite_key" => SUITE_KEY,
                "auth_corpid" => $authCorpId,
                "permanent_code" => $permanentCode,
                "agentid" => $agentId
            )));
        self::check($response);
        return $response;
    }
    
    
    public static function activeSuite($suiteAccessToken, $authCorpId, $permanentCode)
    {
        $key = "dingdingActive_".$authCorpId;
        $response = Http::post("/service/activate_suite", 
            array(
                "suite_access_token" => $suiteAccessToken
            ), 
            json_encode(array(
                "suite_key" => SUITE_KEY,
                "auth_corpid" => $authCorpId,
                "permanent_code" => $permanentCode
            )));

        if($response->errcode==0){
            Cache::setActiveStatus($key);
        }
        self::check($response);
        return $response;
    }

    public static function removeCorpInfo($authCorpId){
        $arr = array();
        $key1 = "dingdingActive_".$authCorpId;
        $key2 = "corpAuthInfo_".$authCorpId;
        $key3 = "IsvCorpAccessToken_".$authCorpId;
        $key4 = "js_ticket_".$authCorpId;
        $arr[] = $key1;
        $arr[] = $key2;
        $arr[] = $key3;
        $arr[] = $key4;
        Cache::removeByKeyArr($arr);
        Mysql::run_alter("UPDATE custom_list set ding_state=3,delete_time=".time()." where corpid='".$authCorpId."'");
    }

    public static function disableCorpInfo($authCorpId){

        $suiteTicket = Cache::getSuiteTicket();
        $suiteAccessToken = self::getSuiteAccessToken($suiteTicket);       
        $temp = Mysql::run_select("select * from custom_list where corpid='".$authCorpId."'");        
        $permanetCode = $temp[0]['permanent_code'];
        $custom_id = $temp[0]['id'];
        $corpAccessToken = self::getIsvCorpAccessToken($suiteAccessToken, $authCorpId, $permanetCode);
        $res = self::getAuthInfo($suiteAccessToken, $authCorpId, $permanetCode);
        $agentId = $res->agent[0]->agentid;
        $res = self::getAgent($suiteAccessToken, $authCorpId, $permanentCode, $agentId);

        if($res->close==0){
            $arr = array();
            $key1 = "dingdingActive_".$authCorpId;
            $key2 = "corpAuthInfo_".$authCorpId;
            $key3 = "IsvCorpAccessToken_".$authCorpId;
            $key4 = "js_ticket_".$authCorpId;
            $arr[] = $key1;
            $arr[] = $key2;
            $arr[] = $key3;
            $arr[] = $key4;
            Cache::removeByKeyArr($arr);
            Mysql::run_alter("UPDATE custom_list set ding_state=2,delete_time=".time()." where corpid='".$authCorpId."'");
        }
        else if($res->close==1){
            Mysql::run_alter("UPDATE custom_list set ding_state=1 where corpid='".$authCorpId."'");
            fastcgi_finish_request();
            Department::update_dep($corpAccessToken,$custom_id);
        }
    }

    static function check($res)
    {
        if ($res->errcode != 0)
        {
            Log::e("[FAIL]: " . json_encode($res));
            exit("Failed: " . json_encode($res));
        }
    }
}
