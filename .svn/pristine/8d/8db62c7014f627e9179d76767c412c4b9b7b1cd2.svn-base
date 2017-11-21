const ccl = {
    setMenu: opt => {
        dd.biz.navigation.setMenu({
            backgroundColor: "#ADD8E6",
            textColor: "#ADD8E611",
            items: opt.items,
            onSuccess: function (data) {
                opt.onSuccess(data)
            },
            onFail: function (err) {
            }
        })
    },
    scanCard: opt => {
        dd.biz.util.scanCard({ // 无需传参数
            onSuccess: function (data) {
                opt.onSuccess(data)
            },
            onFail: function (err) {
            }
        })
    },
    showPreloader: opt => {
        dd.device.notification.showPreloader({
            text: opt.text, //loading显示的字符，空表示不显示文字
            showIcon: true, //是否显示icon，默认true
            onSuccess: function (result) {
                /*{}*/
            },
            onFail: function (err) {
            }
        })
    },
    hidePreloader: () => {
        dd.device.notification.hidePreloader({
            onSuccess: function (result) {
                /*{}*/
            },
            onFail: function (err) {
            }
        })
    },
    toast: opt => {
        dd.device.notification.toast({
            icon: '', //icon样式，有success和error，默认为空 0.0.2
            text: opt.text, //提示信息
            duration: '1s', //显示持续时间，单位秒，默认按系统规范[android只有两种(<=2s >2s)]
            delay: 0, //延迟显示，单位秒，默认0
            onSuccess: function (result) {
                /*{}*/
            },
            onFail: function (err) {
            }
        })
    },
    actionSheet: opt => {
        dd.device.notification.actionSheet({
            title: opt.title, //标题
            cancelButton: opt.cancelButton, //取消按钮文本
            otherButtons: opt.otherButtons,
            onSuccess: function (result) {
                opt.onSuccess(result)
            },
            onFail: function (err) {
            }
        })
    },
    alert: opt => {
        dd.device.notification.alert({
            message: opt.text,
            title: "提示",//可传空
            buttonName: "确定",
            onSuccess: function () {
                //onSuccess将在点击button之后回调
                /*回调*/
            },
            onFail: function (err) {
            }
        });
    },
    setRight: opt => {
        dd.biz.navigation.setRight({
            show: true,//控制按钮显示， true 显示， false 隐藏， 默认true
            control: true,//是否控制点击事件，true 控制，false 不控制， 默认false
            text: opt.text ,//控制显示文本，空字符串表示显示默认文本
            onSuccess : function(result) {
                opt.onSuccess()
            },
            onFail : function(err) {}
        })
    }
}
export default ccl
