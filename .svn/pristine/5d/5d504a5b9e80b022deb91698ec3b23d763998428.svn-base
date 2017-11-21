import {
    SET_USERINFO,
    SHOWHEADER,
    HIDEHEADER,
    SHOWLOADING,
    HIDELOADING,
    SETRECEDATA,
    CLEAEREDATA,
    CLEAERNEWCUSTOM,
    SETNEWCUSTOM,
    SETNEWCONTRACT,
    CLEARSELECTCUSROM,
    SETEDITCUSTOM,
    SETLINKMAN,
    SETEDITCONTRACT,
    CLEAROPTIONCONTRACT,
    CLEARSELECTINDUSTRY,
    CLEARCUSTOM
} from './mutations-type'


export default {
    [SET_USERINFO](state, info){
        state.userInfo = info;
    },
    [SHOWHEADER](state){
        state.showNav = true
    },
    [HIDEHEADER](state){
        state.showNav = false
    },
    [SHOWLOADING](state){
        state.loading = true
    },
    [HIDELOADING](state){
        state.loading = false
    },
    [SETRECEDATA](state, res){
        state.newReceivable = res
    },
    [CLEAEREDATA](state){
        state.newReceivable = {}
    },
    //清空新建客户数据
    [CLEAERNEWCUSTOM](state){
        state.newCustom = {}
    },
    //设置新建客户数据
    [SETNEWCUSTOM](state, Custom){
        
        let newCustom = {}
        
        for (let key in state.newCustom) {
            newCustom[key] = state.newCustom[key]
        }
        
        for (let key in Custom) {
            newCustom[key] = Custom[key]
        }
        
        state.newCustom = newCustom
    },
    //设置更改客户数据
    [SETEDITCUSTOM](state, Custom){
        
        let newCustom = {}
        
        for (let key in state.editCustom) {
            newCustom[key] = state.editCustom[key]
        }
        
        for (let key in Custom) {
            newCustom[key] = Custom[key]
        }
        
        state.editCustom = newCustom
    },
    [CLEARCUSTOM](state){
        state.editCustom = {}
    },
    //编辑合同
    [SETEDITCONTRACT](state,res){
        state.editContract = res
    },
    //设置新建合同数据
    [SETNEWCONTRACT](state, newContract){
        state.newContract = newContract
    },
    //清空选择客户数据
    [CLEARSELECTCUSROM](state){
        state.selectCustomer = {}
    },
    //设置联系人
    [SETLINKMAN](state,res){
        state.selectLinkman = res
    },
    //清空选择合同
    [CLEAROPTIONCONTRACT](state){
        state.optionContract = {contract:[],number:0}
    },
    //清空选择的行业
    [CLEARSELECTINDUSTRY](state){
        state.selectIndustry = {}
    }
}
