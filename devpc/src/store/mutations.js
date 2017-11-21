import {
    SET_USERINFO,
} from './mutations-type'


export default {
    [SET_USERINFO](state, info){
        state.userInfo = info;
    }
}
