<?php

require_once(__DIR__ . "/../../common/classes/Cachebasic.class.php");

class Cache extends Cachebasic
{
    public static function setSuiteTicket($ticket)
    {
        $memcache = self::getMemcache();
        $res = $memcache->set(self::$pre."suite_ticket", $ticket);
        self::set_suiteTicket_file($ticket);
    }
    
    public static function getSuiteTicket()
    {
        $memcache = self::getMemcache();
        $ticket   = $memcache->get(self::$pre."suite_ticket");
        return $ticket;

    }
    
    public static function setJsTicket($key,$ticket)
    {
        $memcache = self::getMemcache();
        $memcache->set(self::$pre.$key, $ticket, 0, time() + 7000); // js ticket有效期为7200秒，这里设置为7000秒
    }
    
    public static function getJsTicket($key)
    {
        $memcache = self::getMemcache();
        return $memcache->get(self::$pre.$key);
    }
    
    public static function setSuiteAccessToken($accessToken)
    {
        $memcache = self::getMemcache();
        $memcache->set(self::$pre."suite_access_token", $accessToken, 0, time() + 7000); // suite access token有效期为7200秒，这里设置为7000秒
    }
    
    public static function getSuiteAccessToken()
    {
        $memcache = self::getMemcache();
        return $memcache->get(self::$pre."suite_access_token");
    }

    public static function setIsvCorpAccessToken($key,$accessToken)
    {
        $memcache = self::getMemcache();
        $memcache->set(self::$pre.$key, $accessToken, 0, time() + 7000);
    }

    public static function getIsvCorpAccessToken($key)
    {
        $memcache = self::getMemcache();
        return $memcache->get(self::$pre.$key);
    }

    public static function setTmpAuthCode($tmpAuthCode){
        $memcache = self::getMemcache();
        $memcache->set(self::$pre."tmp_auth_code", $tmpAuthCode);
    }

    public static function getTmpAuthCode(){
        $memcache = self::getMemcache();
        return $memcache->get(self::$pre."tmp_auth_code");
    }

    public static function setPermanentCode($key,$value){
        $memcache = self::getMemcache();
        $memcache->set(self::$pre.$key, $value);
    }

    public static function getPermanentCode($key){
        $memcache = self::getMemcache();
        return $memcache->get(self::$pre.$key);
    }

    public static function setActiveStatus($corpKey){
        $memcache = self::getMemcache();
        $memcache->set(self::$pre.$corpKey,100);
    }

    public static function getActiveStatus($key){
        $memcache = self::getMemcache();
        return $memcache->get(self::$pre.$key);
    }

    public static function setCorpInfo($corpId,$data){
        $memcache = self::getMemcache();
        $memcache->set(self::$pre."dingding_corp_info_".$corpId,$data);
    }

    public static function getCorpInfo($corpId){
        $memcache = self::getMemcache();
        $memcache->delete(self::$pre."dingding_corp_info_".$corpId);
        $corpInfo =  $memcache->get(self::$pre."dingding_corp_info_".$corpId);
        return $corpInfo;
    }

    public static function setCorpInfoByTmpCode($TmpCode,$data){
        $memcache = self::getMemcache();
        $memcache->set(self::$pre."dingding_corp_info_TmpCode_".$TmpCode,$data);
    }

    public static function getCorpInfoByTmpCode($TmpCode){
        $memcache = self::getMemcache();
        $corpInfo =  $memcache->get(self::$pre."dingding_corp_info_TmpCode_".$TmpCode);
        
        return $corpInfo;
    }


    public static function setAuthInfo($key,$authInfo){
        $memcache = self::getMemcache();
        $memcache->set(self::$pre.$key,$authInfo);
    }

    public static function getAuthInfo($key){
        $memcache = self::getMemcache();
        return $memcache->get(self::$pre.$key);
    }

    public static function removeByKeyArr($arr){
        $memcache = self::getMemcache();
        foreach($arr as $a){
            $memcache->delete(self::$pre.$a);
        }
    }

    public static function setUserToken($userid,$token){
        $memcache = self::getMemcache();
        $memcache->set(self::$pre.$userid."_token", $token, 0, time() + 1800); // js ticket有效期为7200秒，这里设置为7000秒
    }

    public static function getUserToken($userid){
        $memcache = self::getMemcache();
        return $memcache->get(self::$pre.$userid."_token");
    }

    private static function getMemcache()
    {
        if (class_exists("Memcache"))
        {
            $memcache = new Memcache; 
            if ($memcache->connect('localhost', 11211))
            {
                return $memcache;   
            }
        }
    }
    
    public static function get($key)
    {
        return self::getMemcache()->get($key);
    }
    
    public static function set($key, $value)
    {
        self::getMemcache()->set($key, $value);
    }
}

/**
 * fallbacks 
 */
class FileCache
{
    function __call($name, $args)
    {
        if($name=='set')
        {
            switch(count($args))
            {
                case 0:break;
                case 1: break;
                case 2: $this->setComm($args[0], $args[1]); break;
                case 4: $this->setLimit($args[0], $args[1],$args[2],$args[3]); break;
                default: //do something
                    break;
            }
        }
    }

    function setComm($key, $value)
    {
        if($key){
            $data = json_decode($this->get_file(DIR_ROOT ."filecache.php"),true);
            if(!$value){
                unset($data["$key"]);
            }else{
                $item = array();
                $item["$key"] = $value;
                $item['expire_time'] = 0;
                $item['create_time'] = time();
                $data["$key"] = $item;
            }
            $this->set_file("filecache.php",json_encode($data));
        }
    }

	function setLimit($key, $value,$tag,$time)
	{
        if($key){
            $data = json_decode($this->get_file(DIR_ROOT ."filecache.php"),true);
            if(!$value){
                unset($data["$key"]);
            }else{
                $item = array();
                $item["$key"] = $value;
                $item['expire_time'] = $time;
                $item['create_time'] = time();
                $data["$key"] = $item;
            }

            $this->set_file("filecache.php",json_encode($data));
        }
	}

	function get($key)
	{
        if($key){
            $data = json_decode($this->get_file(DIR_ROOT ."filecache.php"),true);
            if($data&&array_key_exists($key,$data)){
                $item = $data["$key"];
                if(!$item){
                    return false;
                }
                if($item['expire_time']>0&&$item['expire_time'] < time()){
                    return false;
                }

                return $item["$key"];
            }else{
                return false;
            }

        }
	}

    function get_file($filename) {
        if (!file_exists($filename)) {
            $fp = fopen($filename, "w");
            fwrite($fp, "<?php exit();?>" . '');
            fclose($fp);
            return false;
        }else{
            $content = trim(substr(file_get_contents($filename), 15));
        }
        return $content;
    }

    function set_file($filename, $content) {
        $fp = fopen($filename, "w");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }
}
