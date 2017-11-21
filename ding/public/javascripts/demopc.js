/**
 * Created by liqiao on 8/10/15.
 */

// logger.i('Here we go...');

// logger.i(location.href);

/**
 * _config comes from server-side template. see views/index.jade
 */
DingTalkPC.config({
    agentId: _config.agentId,
    corpId: _config.corpId,
    timeStamp: _config.timeStamp,
    nonceStr: _config.nonceStr,
    signature: _config.signature,
    jsApiList: [
        'runtime.permission.requestAuthCode',
        'device.notification.alert',
        'device.notification.confirm',
        'biz.contact.choose',
        'device.notification.prompt',
        'biz.ding.post',
        'biz.util.openLink'
        ] // 必填，需要使用的jsapi列表
});
DingTalkPC.userid=0;
DingTalkPC.ready(function(res){
    // logger.i('dd.ready rocks!');

    DingTalkPC.runtime.permission.requestAuthCode({
        corpId: _config.corpId, //企业ID
        onSuccess: function(info) {
            // logger.i('authcode: ' + info.code);
	    $.ajax({
                url: '/ding/sendMsg.php',
                type:"POST",
                data: {"event":"get_userinfo","code":info.code,"corpId":_config.corpId},
                dataType:'json',
                timeout: 3000,
                success: function (data, status, xhr) {
                    var info = JSON.parse(data);
                    if (info.errcode === 0) {
                            // logger.i('user id: ' + info.userid);
                            DingTalkPC.userid = info.userid
                            location.href = "https://devd.paiago.com/ding/ding_loginpc.php?userid="+info.userid+"&corpid="+_config.corpId
                    }
                    else {
                        // logger.e('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    // logger.e(errorType + ', ' + error);
                }
            });
        },
        onFail : function(err) {
	   // logger.e(JSON.stringify(err));
	}

    });

});

DingTalkPC.error(function(error){
    // console.log(error)
    $.ajax({
        url: '/AdminEx/Api/collectError.php',
        type:"POST",
        data: {"code":error.code,"errorCode":error.body.errorCode,"errorMessage":error.body.errorMessage,'config':_config},
        dataType:'json',
        timeout: 3000,
        success: function (data, status, xhr) {},
        error: function (xhr, errorType, error) {}
    });
});