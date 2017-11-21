import axios from 'axios'
import {apihost} from './config.js'
import {I} from '../common/function.js'
import ccl from   '../common/ccl.js'

axios.defaults.baseURL = apihost
axios.defaults.timeout = 10000; //请求超时
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8';

axios.interceptors.request.use(function (config) {
    ccl.showPreloader({text: '使劲加载中..'})
    return config;
}, function (error) {
    return Promise.reject(error)
});
axios.interceptors.response.use(function (response) {
    ccl.hidePreloader()
    return response;
}, function (error) {
    return Promise.reject(error)
});


function initData(obj) {
    if (typeof obj == 'object') {
        let str = '';
        for (let i in obj) {
            str += i + '=' + obj[i] + '&'
        }
        if (str != '') {
            str = str.slice(0, str.length - 1)
        }
        I('params : ' + str, 'i')
        return str
    } else {
        I(obj, 'i')
        return obj
    }
}

export function fetch(type, url, params) {
    return new Promise((resolve, reject) => {
        if (type === "GET") {
            axios.get(url)
                .then(response => {
                    I(response.data, 'i')
                    resolve(response.data)
                }, err => {
                    I(err, 'e')
                    reject(err)
                })
        } else if (type === "POST") {
            axios.post(url, initData(params))
                .then(response => {
                    I(response.data, 'i')
                    resolve(response.data);
                }, err => {
                    alert(err)
                    I(err, 'e')
                    reject(err);
                })
                .catch((error) => {
                    I(err, 'e')
                    reject(error)
                })
        } else if (type == "FORM") {
            axios.post(url, params)
                .then(response => {
                    I(response.data, 'i')
                    resolve(response.data)
                }, err => {
                    I(err, 'e')
                    reject(err)
                })
        }
        
    })
}
