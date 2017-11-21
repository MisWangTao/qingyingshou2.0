<?php
require_once(__DIR__ . "/../util/Http.php");
require_once(__DIR__ . "/../util/Mysql.php");
require_once(__DIR__ . "/../util/Cache.php");
require_once(__DIR__ . "/ISVService.php");

class Message
{
    public static function sendToConversation($accessToken, $opt)
    {
        $response = Http::post("/message/send_to_conversation",
            array("access_token" => $accessToken),
            json_encode($opt));
        return $response;
    }

    public static function send($accessToken, $opt)
    {
        $response = Http::post("/message/send",
            array("access_token" => $accessToken),json_encode($opt));
        return $response;
    }
    public static function send_tem_mes($CorpId,$userid,$temtype,$mes){
            $res = Mysql::run_select("select * from custom_list where corpid='".$CorpId."'");
            $suiteTicket = Cache::getSuiteTicket();


            $suiteAccessToken = ISVService::getSuiteAccessToken($suiteTicket);
            $authCorpId = $CorpId;
            $permanentCode = $res[0]['permanent_code'];
            $access_token = ISVService::getIsvCorpAccessToken($suiteAccessToken, $authCorpId, $permanentCode);

            $opt['touser']=$userid;
            $opt['toparty']="";
            $agentId = ISVService::getCurAgentId($CorpId,APPID);
            if(!$agentId)return;
            $opt['agentid']=$agentId;

            $opt['msgtype']="oa";
            $opt['oa']['head']['bgcolor']="FF5677FC";
            $opt['oa']['head']['text']="推送的消息";

            if($temtype==1){
                $opt['oa']['body']['title']="您有一笔应收款需要跟进";
                $opt['oa']['body']['form'][]=array('key'=>'项目:','value'=>$mes['proname']);
                $opt['oa']['body']['form'][]=array('key'=>'客户:','value'=>$mes['companyname']);
                $opt['oa']['body']['form'][]=array('key'=>'创建人:','value'=>$mes['chuangjianren']);
                $opt['oa']['body']['form'][]=array('key'=>'业务日期:','value'=>$mes['date']);
                $opt['oa']['body']['rich']=array('num'=>sprintf("%.2f",$mes['yingshou']),'unit'=>'元');
                $opt['oa']['message_url']=WEB_HOST."/detail/".$mes['ysid']."/?dd_nav_bgcolor=FF1f8ae8&corpid=$CorpId";
            }
            else if($temtype==2){
                $opt['oa']['body']['title']="逾期提醒";
                $opt['oa']['body']['form'][]=array('key'=>'逾期未收款:','value'=>$mes['count']."笔");
                $opt['oa']['body']['form'][]=array('key'=>'逾期金额:','value'=>number_format($mes['money'],2));
                $opt['oa']['message_url']=WEB_HOST."/remind/yqws/?mine=1&dd_nav_bgcolor=FF1f8ae8&corpid=$CorpId";
            }
            else if($temtype==3){
                $opt['oa']['body']['title']="应收到期提醒";
                $opt['oa']['body']['form'][]=array('key'=>'七天内到期:','value'=>$mes['count']."笔");
                $opt['oa']['body']['form'][]=array('key'=>'七天内到期金额:','value'=>number_format($mes['money'],2));
                $opt['oa']['message_url']=WEB_HOST."/remind/yzdq/?mine=1&dd_nav_bgcolor=FF1f8ae8&corpid=$CorpId";
            }
            else if($temtype==4){
                $opt['oa']['body']['title']="";
                $opt['oa']['body']['form'][]=array('key'=>'项目:','value'=>$mes['proname']);
                $opt['oa']['body']['form'][]=array('key'=>'客户:','value'=>$mes['companyname']);
                $opt['oa']['body']['content']=$mes['des'];
                // $opt['oa']['body']['form'][]=array('key'=>'描述:','value'=>$mes['des']);
                $opt['oa']['message_url']=WEB_HOST."/detail/".$mes['ysid']."/?dd_nav_bgcolor=FF1f8ae8&corpid=$CorpId";
            }
            else if($temtype==5){
                $opt['oa']['body']['title']="意见反馈";
                $opt['oa']['body']['form'][]=array('key'=>'电话:','value'=>$mes['user_tel']);
                $opt['oa']['body']['form'][]=array('key'=>'内容:','value'=>$mes['msg_cont']);
            }
            else if($temtype==6){
                $opt['oa']['body']['title']="";
                $opt['oa']['body']['content']=$mes['des'];
            }
            else if($temtype==7){
                $opt['oa']['body']['title']="版本通知更新";
                $opt['oa']['body']['content']="轻应收更新了你知道么？别说你还不知道，猛戳这里了解新版本";
                $opt['oa']['message_url']=WEB_HOST."/?dd_nav_bgcolor=FF1f8ae8&corpid=$CorpId";
                $opt['oa']['pc_message_url']="https://d.paiago.com/Update-notification.html";
            }
            else if($temtype==8){
                $opt['oa']['body']['title']="您有一笔应收单跟进人被修改";
                $opt['oa']['body']['form'][]=array('key'=>'项目:','value'=>$mes['proname']);
                $opt['oa']['body']['form'][]=array('key'=>'客户:','value'=>$mes['companyname']);
                $opt['oa']['body']['form'][]=array('key'=>'创建人:','value'=>$mes['chuangjianren']);
                $opt['oa']['body']['form'][]=array('key'=>'业务日期:','value'=>$mes['date']);
                $opt['oa']['body']['rich']=array('num'=>sprintf("%.2f",$mes['yingshou']),'unit'=>'元');
                $opt['oa']['message_url']=WEB_HOST."/detail/".$mes['ysid']."/?dd_nav_bgcolor=FF1f8ae8&corpid=$CorpId";
            }
            else if($temtype==9){
                $opt['oa']['body']['title']="通知";
                $opt['oa']['body']['content']="经系统监测发现，因轻应收5月2日升级可能导致您无法登陆轻应收主页，现已修复，给您带来的不便，敬请谅解，感谢使用。";
                $opt['oa']['message_url']=WEB_HOST."/?dd_nav_bgcolor=FF1f8ae8&corpid=$CorpId";
            }
            else if($temtype==10){
                $opt['oa']['body']['title']="";
                $opt['oa']['body']['content']="亲，贵公司需要设置一位财务即可开启轻松管理应收新模式，快去设置吧~";
                $opt['oa']['message_url']=WEB_HOST."/?dd_nav_bgcolor=FF1f8ae8&corpid=$CorpId";
            }
            else if($temtype==11){
                $opt['oa']['body']['title']="";
                $opt['oa']['body']['content']="亲，贵公司已开启轻应收，快去增加一笔应收款，为您的企业添砖加瓦吧~";
                $opt['oa']['message_url']=WEB_HOST."/?dd_nav_bgcolor=FF1f8ae8&corpid=$CorpId";
            }
            else if($temtype==12){
                $opt['oa']['body']['title']="应收周报";
                $opt['oa']['body']['form'][]=array('key'=>'上周新增应收:','value'=>$mes['lastadd']."元");
                $opt['oa']['body']['form'][]=array('key'=>'上周到账金额:','value'=>$mes['lasthui']."元");
                $opt['oa']['body']['form'][]=array('key'=>'本周预计到账:','value'=>$mes['next_hui']."元                       查看详情>>");
                $opt['oa']['message_url']=WEB_HOST."/?dd_nav_bgcolor=FF1f8ae8&corpid=$CorpId";
            }
            return self::send($access_token,$opt);
    }
}
