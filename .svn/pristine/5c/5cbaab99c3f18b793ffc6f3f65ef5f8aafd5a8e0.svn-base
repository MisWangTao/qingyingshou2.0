import Vue from 'vue'
import Vuex from 'vuex'

import getters from './getters'
import actions from './action'
import mutations from './mutations'

Vue.use(Vuex)

const state = {
    loading: false,
    showNav: true,
    userInfo: null,
    newCustom: {},      //新建客户
    editCustom : {},
    newContract: {
        label: {
            labelName: [],
            labelId: [],
        },
        contractType: 1,
        currencyId: 1,
        currencyName: 'CNY',
        remindState: 0,
        advance_remind: 7,
        payment_type: 1,
        three_type: 1,
        two_type: 1,
        each_day: 1,
    },  //新建合同
    editContract:{
    
    },//编辑合同
    newReceivable: {payment: 1},
    expectReturn:{},
    
    //组件 公共
    selectCustomer: {},
    selectIndustry : {},
    optionContract:{contract:[],number:0},
    selectLinkman : [],
}

export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations,
})
