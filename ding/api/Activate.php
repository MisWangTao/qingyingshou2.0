<?php

require_once(__DIR__ . "/../util/Log.php");
require_once(__DIR__ . "/../util/Http.php");
require_once(__DIR__ . "/../util/Mysql.php");
require_once(__DIR__ . "/ISVService.php");
require_once(__DIR__ . "/Department.php");
require_once(__DIR__ . "/../util/Myhttp.php");

/**
 * 激活ISV套件方法类
 */     
class Activate
{
    /**
     * 某个企业的临时授权码在成功换取永久授权码后，开放平台将不再推送该企业临时授权码。
     */
    public static function autoActivateSuite($tmpAuthCode)
    {
        //持久化临时授权码
        //Cache::setTmpAuthCode($tmpAuthCode);
	    $suiteTicket = Cache::getSuiteTicket();
        $suiteAccessToken = ISVService::getSuiteAccessToken($suiteTicket);
        Log::i("[Activate] getSuiteToken: " . $suiteAccessToken);
        //获取永久授权码以及corpid等信息，持久化，并激活临时授权码
        $permanetCodeInfo = ISVService::getPermanentCodeInfo($suiteAccessToken, $tmpAuthCode);
        Log::i("[Activate] getPermanentCodeInfo: " . json_encode($permanetCodeInfo));
        
        $permanetCode = $permanetCodeInfo['permanent_code'];
        $authCorpId = $permanetCodeInfo['corp_id'];
        $corp_name = $permanetCodeInfo['corp_name'];
        Log::i("[Activate] permanetCode: " . $permanetCode . ",  authCorpId: " . $authCorpId);
        
        /**
         * 获取企业access token
         */
        $corpAccessToken = ISVService::getIsvCorpAccessToken($suiteAccessToken, $authCorpId, $permanetCode);
        Log::i("[Activate] getCorpToken: " . $corpAccessToken);
        
        /**
         * 获取企业授权信息
         */
        $res = ISVService::getAuthInfo2($suiteAccessToken, $authCorpId, $permanetCode);
        Log::i("[Activate] getAuthInfo: " . json_encode($res));
        self::check($res);

        $invite_code       = $res->auth_corp_info->invite_code;
        $industry          = $res->auth_corp_info->industry;
        $license_code      = $res->auth_corp_info->license_code;
        $auth_channel      = $res->auth_corp_info->auth_channel;
        $auth_channel_type = $res->auth_corp_info->auth_channel_type;
        $is_authenticated  = $res->auth_corp_info->is_authenticated;
        $auth_level        = $res->auth_corp_info->auth_level;

        /**
         * 激活套件
         */
        $res = ISVService::activeSuite($suiteAccessToken, $authCorpId, $permanetCode);
        Log::i("[activeSuite]: " . json_encode($res));
        self::check($res);

        $now_time = time();

        if($corp = Mysql::run_select("SELECT * from custom_list where corpid='".$authCorpId."'")){
            $custom_id = $corp[0]['id'];
            Mysql::run_alter("UPDATE  custom_list SET custom_name='".$corp_name."',permanent_code='".$permanetCode."',invite_code='".$invite_code."',industry='".$industry."',license_code='".$license_code."',auth_channel='".$auth_channel."',auth_channel_type='".$auth_channel_type."',is_authenticated='".$is_authenticated."',auth_level='".$auth_level."',ding_state=1,update_time=$now_time where corpid='".$authCorpId."'");//更新公司表
        }else{
            $custom_id = Mysql::run_insert("INSERT INTO custom_list (custom_name,corpid,permanent_code,invite_code,industry,license_code,auth_channel,auth_channel_type,is_authenticated,auth_level,ding_state,add_time,update_time) VALUES ('$corp_name','$authCorpId','$permanetCode','$invite_code','$industry','$license_code','$auth_channel','$auth_channel_type','$is_authenticated','$auth_level',1,$now_time,$now_time)");//插入公司表
        }

        fastcgi_finish_request();
        Department::update_dep($corpAccessToken,$custom_id);



        //注册事件回调接口


            $url = "https://oapi.dingtalk.com/call_back/register_call_back?access_token=".$corpAccessToken;
            $data = array(
                'call_back_tag'=>array(
                    'user_add_org','user_modify_org','user_leave_org','org_admin_add','org_admin_remove','org_dept_create','org_dept_modify','org_dept_remove','org_remove','org_change'
                    ),
                'token'=>TOKEN,
                'aes_key'=>ENCODING_AES_KEY,
                'url'=>'http://l.paiago.com/ding/receive.php',
            );
            $res = Myhttp::post_http($url,json_encode($data));
    }
    
    
    static function check($res)
    {
        if ($res->errcode != 0)
        {
            exit("Failed: " . json_encode($res));
        }
    }
}
