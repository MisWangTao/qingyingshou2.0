import{
    SET_USERINFO,
} from './mutations-type'

export default {
    setUserInfo: ({commit}, res) => {
        commit('SET_USERINFO', res)
    },
}
