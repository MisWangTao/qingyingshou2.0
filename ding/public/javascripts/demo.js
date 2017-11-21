/**
 * Created by liqiao on 8/10/15.
 */

// logger.i('Here we go...');

// logger.i(location.href);

/**
 * _config comes from server-side template. see views/index.jade
 */
dd.config({
    agentId: _config.agentId,
    corpId: _config.corpId,
    timeStamp: _config.timeStamp,
    nonceStr: _config.nonceStr,
    signature: _config.signature,
    jsApiList: [
        'runtime.info',
        'device.notification.prompt',
        'biz.chat.pickConversation',
        'device.notification.confirm',
        'device.notification.alert',
        'device.notification.prompt',
        'biz.chat.open',
        'biz.util.open',
        'biz.user.get',
        'biz.contact.choose',
        'biz.telephone.call',
        'biz.util.uploadImage',
        'biz.ding.post']
});
dd.userid=0;
dd.ready(function() {
    // logger.i('dd.ready rocks!');

    dd.runtime.info({
        onSuccess: function(info) {
            // logger.i('runtime info: ' + JSON.stringify(info));
        },
        onFail: function(err) {
            // logger.e('fail: ' + JSON.stringify(err));
        }
    });

    dd.runtime.permission.requestAuthCode({
        corpId: _config.corpId, //企业id
        onSuccess: function (info) {
            // logger.i('authcode: ' + info.code);
            $.ajax({
                url: '/ding/sendMsg.php',
                type:"POST",
                data: {"event":"get_userinfo","code":info.code,"corpId":_config.corpId},
                dataType:'json',
                timeout: 3000,
                success: function (data, status, xhr) {
                    // logger.i('success');
                    var info = JSON.parse(data);
                    if (info.errcode === 0) {
                        // logger.i('user id: ' + info.userid);
                        dd.userid = info.userid;
                        var mes_type = GetQueryString('mes_type');
                        var record_id = GetQueryString('record_id');
                        var company_id = GetQueryString('company_id');
                        if(mes_type==null){
                            window.location.href="http://www.paiago.com/ding/ding_login.php?userid="+info.userid+"&corpid="+_config.corpId; 
                        }
                        else{
                            window.location.href="http://www.paiago.com/ding/ding_login.php?userid="+info.userid+"&corpid="+_config.corpId+"&mes_type="+mes_type+"&record_id="+record_id+"&company_id="+company_id; 
                        }
                    }
                    else {
                        // logger.e('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    // logger.i('fail');
                    // logger.e(errorType + ', ' + error);
                }
            });
        },
        onFail: function (err) {
            // logger.e('requestAuthCode fail: ' + JSON.stringify(err));
        }
    });
});

dd.error(function(err) {
    logger.e('dd error: ' + JSON.stringify(err));
});

function GetQueryString(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}