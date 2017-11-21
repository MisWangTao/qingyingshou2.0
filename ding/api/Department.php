<?php
require_once(__DIR__ . "/../util/Http.php");
require_once(__DIR__ . "/../util/Mysql.php");
require_once(__DIR__ . "/../util/Cache.php");
require_once(__DIR__ . "/ISVService.php");
require_once(__DIR__ . "/../util/Myhttp.php");


class Department
{
    public static function createDept($accessToken, $dept)
    {
        $response = Http::post("/department/create", 
            array("access_token" => $accessToken), 
            json_encode($dept));
        return $response->id;
    }
    
    
    public static function listDept($accessToken)
    {
        // $response = Http::get("/department/list", 
        // array("access_token" => $accessToken));
        // return $response->department;
        $url ="https://oapi.dingtalk.com/department/list?access_token=".$accessToken;
        $response = Myhttp::get_http($url);
        $data = json_decode($response,true);
        return $data['department'];
    }
    
    
    public static function deleteDept($accessToken, $id)
    {
        $response = Http::get("/department/delete", 
            array("access_token" => $accessToken, "id" => $id));
        return $response->errcode == 0;
    }

    public static function userList($accessToken,$dep_id){
        $url ="https://oapi.dingtalk.com/user/simplelist?access_token=".$accessToken."&department_id=".$dep_id;
        $response = Myhttp::get_http($url);
        $data = json_decode($response,true);
        return $data['userlist'];
    }

    public static function userList_detail($accessToken,$dep_id){
        $url ="https://oapi.dingtalk.com/user/list?access_token=".$accessToken."&department_id=".$dep_id;
        $response = Myhttp::get_http($url);
        $data = json_decode($response,true);
        return $data['userlist'];
    }

    public static function txl_change($msg){
        $ms['EventType']=$msg->EventType;
        $ms['TimeStamp']=$msg->TimeStamp;
        $ms['UserId']=$msg->UserId['0'];
        $ms['DeptId']=$msg->DeptId['0'];
        $ms['CorpId']=$msg->CorpId;

        $res = Mysql::run_select("select * from custom_list where corpid='".$ms['CorpId']."'");
        $custom_id = $res[0]['id'];
        $suiteTicket = Cache::getSuiteTicket();
        $suiteAccessToken = ISVService::getSuiteAccessToken($suiteTicket);
        $authCorpId = $ms['CorpId'];
        $permanentCode = $res[0]['permanent_code'];
        $access_token = ISVService::getIsvCorpAccessToken($suiteAccessToken, $authCorpId, $permanentCode);
        
        if($ms['EventType']==='org_dept_create'){ 
            $id = $ms['DeptId'];
            $url = "https://oapi.dingtalk.com/department/get?access_token=$access_token&id=$id";
            $response = Myhttp::get_http($url);
            $re = json_decode($response,true);
            Mysql::run_insert("INSERT INTO ysyf_depart (dapart_name,custom_id,ding_id,parent_ding_id,is_delete) VALUES ('".$re['name']."','".$res[0]['id']."','".$re['id']."','".$re['parentid']."',0)");
        }
        else if($ms['EventType']==='org_dept_modify'){
            $id = $ms['DeptId'];
            $url = "https://oapi.dingtalk.com/department/get?access_token=$access_token&id=$id";
            $response = Myhttp::get_http($url);
            $re = json_decode($response,true);
            if($re['id']==1){
                $re['parentid']=0;
                $sql = " UPDATE custom_list set custom_name='".$re['name']."' WHERE id=$custom_id";
                Mysql::run_alter($sql);
            }
            Mysql::run_alter("UPDATE ysyf_depart SET dapart_name='".$re['name']."',parent_ding_id='".$re['parentid']."',is_delete=0 where ding_id='".$re['id']."' and custom_id=$custom_id");
            self::update_dep_user($access_token,$custom_id,$id);
        }
        else if($ms['EventType']==='org_dept_remove'){
            Mysql::run_alter("UPDATE  ysyf_depart set is_delete=1 where ding_id='".$ms['DeptId']."' and custom_id=$custom_id");
        }
        else if($ms['EventType']==='user_add_org'){

            if(Mysql::run_select("select * from ysyf_user where ding_userid='".$ms['UserId']."' and custom_id='".$custom_id."'")){
                Mysql::run_alter("UPDATE ysyf_user set is_delete=0 where ding_userid='".$ms['UserId']."' and custom_id='".$custom_id."'");
                self::update_user($access_token,$custom_id,$ms['UserId'],false);
            }else{
                self::update_user($access_token,$custom_id,$ms['UserId'],true);
            }
        }
        else if($ms['EventType']==='user_modify_org' || $ms['EventType']==='org_admin_add' || $ms['EventType']==='org_admin_remove'){

            self::update_user($access_token,$custom_id,$ms['UserId'],false);

        }
        else if($ms['EventType']==='user_leave_org'){
            Mysql::run_alter("UPDATE ysyf_user set is_delete=1  where ding_userid='".$ms['UserId']."'");
        }
        else if($ms['EventType']==='org_remove'){
            $authCorpId = $ms['CorpId'];
            Mysql::run_alter("UPDATE custom_list set ding_state=4,delete_time=".time()." where corpid='".$authCorpId."'");
        }
        return true;
    }
    private static function panduan_leader($json){
        $res = false;
        $t=preg_replace("/(\d+)/", '"${1}"', $json);
        $arr = json_decode($t,true);
        foreach ($arr as $key => $value) {
           $res=$res||$value;
        }
        return $res;
    }
    private static function is_leader_str($json){
        $t=preg_replace("/(\d+)/", '"${1}"', $json);
        $arr = json_decode($t,true);
        $res = array();
        foreach ($arr as $key => $value) {
            if($value){
                $res[]=$key;
            }
        }
        return implode(",", $res);
    }

    public static function update_dep($corpAccessToken,$custom_id,$auto = true ){

        var_dump($auto);

        $res = self::listDept($corpAccessToken);//二维数组

        if(!$res){
            self::sync_update($corpAccessToken,$custom_id,$auto);
            return;
        }
        //遍历部门列表获取部门成员
        $new_dep =array();
        $users = array();
        foreach ($res as $key=>$re){
            if(!$auto)var_dump($re);
            if($re['id']=='1'){

                $sql = " UPDATE custom_list set custom_name='".$re['name']."' WHERE id=$custom_id";
                Mysql::run_alter($sql);

                
                if($temp_dep = Mysql::run_select("SELECT * FROM ysyf_depart where ding_id='".$re['id']."' and custom_id='".$custom_id."'")){
                $department_id = $temp_dep[0]['id'];
                Mysql::run_alter("UPDATE ysyf_depart SET dapart_name='".$re['name']."',is_delete=0 where id='".$department_id."'");//更新部门表
                }
                else{
                $department_id = Mysql::run_insert("INSERT INTO ysyf_depart (dapart_name,custom_id,ding_id,parent_ding_id,is_delete) VALUES ('".$re['name']."','$custom_id','".$re['id']."',0,0)");//插入部门表
                }

            }
            else{

                if($temp_dep = Mysql::run_select("SELECT * FROM ysyf_depart where ding_id='".$re['id']."' and custom_id='".$custom_id."'")){
                $department_id = $temp_dep[0]['id'];
                Mysql::run_alter("UPDATE ysyf_depart SET dapart_name='".$re['name']."',parent_ding_id='".$re['parentid']."',is_delete=0 where id='".$department_id."'");//更新部门表
                }
                else{
                $department_id = Mysql::run_insert("INSERT INTO ysyf_depart (dapart_name,custom_id,ding_id,parent_ding_id,is_delete) VALUES ('".$re['name']."','$custom_id','".$re['id']."','".$re['parentid']."',0)");//插入部门表
                }

            }
            // $temp_users = self::update_dep_user2($corpAccessToken,$custom_id,$re['id']);
            // $users = array_merge_recursive($users,$temp_users); 
            $new_dep[]=$re['id'];
        }
        $new_dep_str = implode("','", $new_dep);
        if($new_dep_str!=''){
            Mysql::run_alter("UPDATE ysyf_depart SET is_delete=1 where custom_id='".$custom_id."' and ding_id not in ('".$new_dep_str."')");            
        }
        foreach ($new_dep as $key => $value) {
            $temp_users = self::update_dep_user($corpAccessToken,$custom_id,$value,$auto);
            $users = array_merge_recursive($users,$temp_users); 
        }
        $new_user_str = implode("','", $users);
            if($new_user_str!=''){
                Mysql::run_alter("UPDATE ysyf_user SET is_delete=1 where custom_id='".$custom_id."' and ding_userid not in ('".$new_user_str."')");
            }
    }
    // public static function 
    public static function update_dep_user($corpAccessToken,$custom_id,$ding_department_id,$auto){

        $user_list = self::userList_detail($corpAccessToken,$ding_department_id);//二位数组 用户列表
        //数据库添加成员数据
        $new_user = array();
        foreach ($user_list as $key => $user) {
            if(!$auto)var_dump($user);
            

            $res_user = Mysql::run_select("select * from ysyf_user where ding_userid='".$user['userid']."' and custom_id='".$custom_id."'");

            if(count($res_user)){
                self::update_user($corpAccessToken,$custom_id,$user['userid'],false);
            }else{
                self::update_user($corpAccessToken,$custom_id,$user['userid'],true);
            }
            $new_user[] = $user['userid'];
        }
            return $new_user;
    }
    public static function update_user($corpAccessToken,$custom_id,$userid,$isadd){
        $url = "https://oapi.dingtalk.com/user/get?access_token=$corpAccessToken&userid=$userid";
        $response = Myhttp::get_http($url);
        $user = json_decode($response,true);
        if($user['isBoss']){
                $user_type = 4;
            }
            else if($user['isAdmin']) {
                $user_type = 3;
            }
            else if(self::panduan_leader($user['isLeaderInDepts'])){
                $user_type = 1;
            }
            else{
                $user_type = 0;
            }
            $str = implode(",",$user['department']);
            $departments = Mysql::run_select("SELECT * from ysyf_depart where ding_id in ($str) and custom_id=$custom_id");
            $department_id_arr =array();
            foreach ($departments as $key => $value) {
                $department_id_arr[]=$value['id'];
            }
            $department_id = implode(",",$department_id_arr);
            $islead_dep = self::is_leader_str($user['isLeaderInDepts']);
            if($islead_dep!=""){
                $islead_deps = Mysql::run_select("SELECT * from ysyf_depart where ding_id in ($islead_dep) and custom_id=$custom_id");
                $islead_dep_id =array();
                foreach ($islead_deps as $key => $value) {
                    $islead_dep_id[]=$value['id'];
                }
                $islead_dep_id = implode(",", $islead_dep_id);
            }else{
                $islead_dep_id = "";
            }

            $user['name'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $user['name']);

            if($isadd){
                Mysql::run_alter("INSERT INTO ysyf_user (custom_id,realname,ding_userid,is_delete,platform,islead_dep_id,department_id,user_type,ding_dingId,ding_isAdmin,ding_isBoss,ding_isLeader,ding_department,ding_position,ding_avatar) VALUES ('$custom_id','".$user['name']."','".$user['userid']."',0,2,'$islead_dep_id','$department_id',$user_type,'".$user['dingId']."','".(int)$user['isAdmin']."','".(int)$user['isBoss']."','$ding_isLeader','".$str."','".$user['position']."','".$user['avatar']."')");//插入员工表 
            }else{
                Mysql::run_alter("UPDATE ysyf_user set islead_dep_id='$islead_dep_id',department_id='$department_id',realname='".$user['name']."',user_type='".$user_type."',ding_dingId='".$user['dingId']."',ding_isAdmin='".(int)$user['isAdmin']."',ding_isBoss='".(int)$user['isBoss']."',ding_isLeader='$islead_dep',ding_department='".$str."',ding_position='".$user['position']."',ding_avatar='".$user['avatar']."' ,is_delete=0 where ding_userid='".$userid."' and custom_id='".$custom_id."'"); //更新员工表
            }
            
    }
    public static function sync_update_dep_user($corpAccessToken,$custom_id,$ding_userid,$auto){
        $url = "https://oapi.dingtalk.com/user/get?access_token=$corpAccessToken&userid=$ding_userid";
        $response = Myhttp::get_http($url);
        $user = json_decode($response,true);

        // $new_user = array();
        if($user['errcode']!='0') return;
        if(!$auto)var_dump($user);

        $user['name'] = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $user['name']);
        if($user['isBoss']){
            $user_type = 4;
        }
        else if($user['isAdmin']) {
            $user_type = 3;
        }
        else if(self::panduan_leader($user['isLeaderInDepts'])){
            $user_type = 1;
        }
        else{
            $user_type = 0;
        }
        $str = implode(",",$user['department']);
        $departments = Mysql::run_select("SELECT * from ysyf_depart where ding_id in ($str) and custom_id=$custom_id and is_delete=0");
        $department_id_arr =array();
        foreach ($departments as $key => $value) {
            $department_id_arr[]=$value['id'];
        }
        $department_id = implode(",",$department_id_arr);
        $islead_dep = self::is_leader_str($user['isLeaderInDepts']);
        if($islead_dep!=""){
            $islead_deps = Mysql::run_select("SELECT * from ysyf_depart where ding_id in ($islead_dep) and custom_id=$custom_id");
            $islead_dep_id =array();
            foreach ($islead_deps as $key => $value) {
                $islead_dep_id[]=$value['id'];
            }
            $islead_dep_id = implode(",", $islead_dep_id);
        }else{
            $islead_dep_id = "";
        }

        if(Mysql::run_select("select * from ysyf_user where ding_userid='".$user['userid']."' and custom_id='$custom_id'")){

            $res = Mysql::run_alter("UPDATE ysyf_user set islead_dep_id='$islead_dep_id',department_id='$department_id',realname='".$user['name']."',user_type='".$user_type."',ding_dingId='".$user['dingId']."',ding_isAdmin='".(int)$user['isAdmin']."',ding_isBoss='".(int)$user['isBoss']."',ding_isLeader='$islead_dep',ding_department='".$str."',ding_position='".$user['position']."',ding_avatar='".$user['avatar']."',is_delete=0 where ding_userid='".$user['userid']."' and custom_id='".$custom_id."'");

        }else{

            Mysql::run_alter("INSERT INTO ysyf_user (islead_dep_id,realname,department_id,tel,custom_id,user_type,ding_userid,ding_dingId,ding_isAdmin,ding_isBoss,ding_isLeader,ding_department,ding_position,ding_avatar,is_delete,platform) VALUES ('$islead_dep_id','".$user['name']."','".$department_id."','".$user['mobile']."','$custom_id','".$user_type."','".$user['userid']."','".$user['dingId']."','".(int)$user['isAdmin']."','".(int)$user['isBoss']."','$islead_dep','".$str."','".$user['position']."','".$user['avatar']."',0,2)");

        }
    }
    public static function sync_update($corpAccessToken,$custom_id,$auto){
        $url = "https://oapi.dingtalk.com/auth/scopes?access_token=".$corpAccessToken;
        $res = Myhttp::get_http($url);
        $re  = json_decode($res,true);

        if(!$auto)var_dump($re);

        $authed_user = $re['auth_org_scopes']['authed_user'];
        $authed_dept = $re['auth_org_scopes']['authed_dept'];

        $all_auth_dep = array();
        foreach ($authed_dept as $key => $value) {
            $all_auth_dep = array_merge($all_auth_dep,self::sync_update_dep($corpAccessToken,$custom_id,$value,$auto));
        }

        $new_dep_str = implode("','", $all_auth_dep);
        if($new_dep_str!=''){
            Mysql::run_alter("UPDATE ysyf_depart SET is_delete=1 where custom_id='".$custom_id."' and ding_id not in ('".$new_dep_str."')");            
        }else{
            Mysql::run_alter("UPDATE ysyf_depart SET is_delete=1 where custom_id='".$custom_id."' ");
        }

        $all_auth_user = array();

        foreach ($all_auth_dep as $key => $value) {
            $all_auth_user = array_merge($all_auth_user,self::update_dep_user($corpAccessToken,$custom_id,$value,$auto));
        }

        foreach ($authed_user as $key => $user) {
            self::sync_update_dep_user($corpAccessToken,$custom_id,$user,$auto);
            $all_auth_user[] = $user;
        }

        $new_user_str = implode("','", $all_auth_user);
        if($new_user_str!=''){
            Mysql::run_alter("UPDATE ysyf_user SET is_delete=1 where custom_id='".$custom_id."' and ding_userid not in ('".$new_user_str."')");
        }


    }
    public static function sync_update_dep($corpAccessToken,$custom_id,$ding_department_id,$auto){
        $url = "https://oapi.dingtalk.com/department/get?access_token=".$corpAccessToken."&id=$ding_department_id";
        $res = Myhttp::get_http($url);
        $re  = json_decode($res,true);

        if(!$auto)var_dump($re);

       if($temp_dep = Mysql::run_select("SELECT * FROM ysyf_depart where ding_id='".$re['id']."' and custom_id='".$custom_id."'")){
            $department_id = $temp_dep[0]['id'];
            Mysql::run_alter("UPDATE ysyf_depart SET dapart_name='".$re['name']."',parent_ding_id='".$re['parentid']."',is_delete=0 where id='".$department_id."'");//更新部门表
        }
        else{
            $department_id = Mysql::run_insert("INSERT INTO ysyf_depart (dapart_name,custom_id,ding_id,parent_ding_id,is_delete) VALUES ('".$re['name']."','$custom_id','".$re['id']."','".$re['parentid']."',0)");//插入部门表
        }

        $url = "https://oapi.dingtalk.com/department/list?access_token=".$corpAccessToken."&id=$ding_department_id";
        $res = Myhttp::get_http($url);
        $re  = json_decode($res,true);
        $department  = $re['department'];

        $response = array();
        $response[] = $ding_department_id;
        foreach ($department as $key => $value) {
            $response = array_merge($response,self::sync_update_dep($corpAccessToken,$custom_id,$value['id'],$auto));
        }
        return $response;
    }
}