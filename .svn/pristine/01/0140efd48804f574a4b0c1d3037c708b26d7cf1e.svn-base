const host = "https://devd.paiago.com/"
const apihost = host + "Api/"

export function httpRequest(opts, aa) {
    let opt = opts || {};
    opt.method = opts.method.toUpperCase() || 'POST';
    opt.url = apihost + opts.url || '';
    opt.async = opts.async || true;
    opt.data = opts.data || "";
    opt.success = opts.success || function () {
        };
    opt.error = opts.error || function () {
        };
    opt.user_token = opts.user_token || "";
    let str = '';
    for (var prop in opt.data) {
        str += prop + "=" + opt.data[prop] + "&"
    }
    var xmlHttp = null;
    if (XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
    }
    else {
        xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
    }
    if (opt.method.toUpperCase() === 'POST') {
        xmlHttp.open(opt.method, opt.url, opt.async);
        if (aa != 3 && aa != 4) {
            xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        }
        if (opt.user_token != -1) {
            xmlHttp.setRequestHeader("Authorization", opt.user_token);
        }
        if (aa == 3 || aa == 4) {
            xmlHttp.send(formdata);
        } else {
            xmlHttp.send(str);
        }
    }
    else if (opt.method.toUpperCase() === 'GET') {
        xmlHttp.open(opt.method, opt.url, opt.async);
        xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        if (opt.user_token != -1) {
            xmlHttp.setRequestHeader("Authorization", opt.user_token);
        }
        xmlHttp.send(null);
    }
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            if (aa != 5 && aa != 6) {
            
            }
            let obj = xmlHttp.response
            if (typeof obj !== 'object') {
                obj = JSON.parse(obj);
            }
            return obj;
        } else {
        
        }
    };
}
export {
    host,
    apihost,
}
