import Vue from 'vue'
import Router from 'vue-router'

//首页
import Home     from '@/page/home/home'
//客户管理
import Customer from '@/page/customer/customer'
//合同管理
import Contract from '@/page/contract/contract'
import Payment  from '@/page/payment/payment'


Vue.use(Router)

export default new Router({
    mode: 'history',
    scrollBehavior: () => ({y: 0}),
    routes: [
        {
            path: '/',
            component: Home
        }, {
            path: '/customer',
            component: Customer
        }, {
            path: '/contract',
            component: Contract
        }, {
            path: '/payment',
            component: Payment
        },

    ],
})
