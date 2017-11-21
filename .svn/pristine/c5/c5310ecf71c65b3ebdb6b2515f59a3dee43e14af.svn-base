// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import store from './store'
import getData from './server/getData'
import {fetch} from './config/fetch'
import filters from './filters/index'
import {I} from './common/function.js'

Object.keys(filters).forEach((key) => Vue.filter(key, filters[key]))
Vue.config.productionTip = false
Vue.prototype.$http = fetch
Vue.prototype.I = I

router.beforeEach((to, from, next) => {
  	dd.biz.navigation.setRight({
        show: false,
        control: false,
        text: '' ,
        onSuccess : function(result) {},
        onFail : function(err) {}
    })
    next()
})



require('./assets/iconfont.css')
require('./assets/main.scss')

new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: {App}
})
