<template>
    <div id="home">
        <h1 v-if="userInfo">{{userInfo.realname}}</h1>
        <h1 v-if="userInfo">is_caiwu:{{userInfo.is_caiwu}}</h1>
        <h1 v-if="userInfo">custom_administrators:{{userInfo.custom_administrators}}</h1>
        <router-link tag="div" to="/remind" class="item">
            <div class="col-xs-7"><i class="icon iconfont icon1">&#xe671;</i>提醒</div>
            <div class="col-xs-5"><i class="icon iconfont">&#xe681;</i></div>
        </router-link>
        <router-link tag="div" to="/paymentManage" class="item">
            <div class="col-xs-7"><i class="icon iconfont icon2">&#xe645;</i>回款管理</div>
            <div class="col-xs-5"><i class="icon iconfont">&#xe681;</i></div>
        </router-link>
        <div v-for="key,item in home">{{key}}</div>
    </div>
</template>
<script>
    import {mapState, mapActions} from 'vuex'
    export default{
        data () {
            return {}
        },
        computed: {
            home: function () {
                
                let res = []
                if (this.userInfo) res.push(this.userInfo.id)
                return res
            },
            ...mapState([
                'userInfo'
            ]),
        },
        methods: {}
    }
</script>
<style lang="scss" scoped>
    #home {
        .item {
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            overflow: hidden;
            background: #ffffff;
            .col-xs-7 {
                color: #121213;
                font-size: 0.75rem;
                i {
                    margin-right: 0.3rem;
                    font-size: 0.8rem;
                    font-weight: bold;
                }
                .icon1 {
                    color: #93f362;
                }
                .icon2 {
                    color: #3891f9;
                }
            }
            .col-xs-5 {
                text-align: right;
                color: #97a8b1;
            }
        }
    }
</style>
