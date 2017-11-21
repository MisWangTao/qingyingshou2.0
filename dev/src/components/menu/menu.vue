<template>
    <div>
        <div class="menu">
            <router-link tag="div" active-class="active" to="/home">
                <img class="img1" :src="imghost+'/menu/index_selected@2x.png'" alt="">
                <img class="img2" :src="imghost+'/menu/index_default@2x.png'" alt="">
                <p>首页</p>
            </router-link>
            <router-link tag="div" active-class="active" to="/contractList">
                <img class="img1" :src="imghost+'/menu/hetong_selected@2x.png'" alt="">
                <img class="img2" :src="imghost+'/menu/hetong_default@2x.png'" alt="">
                <p>合同</p>
            </router-link>
            <div @click="changeShow">
                <img class="img" src="../../assets/img/more@2x.png" alt="">
            </div>
            <router-link tag="div" active-class="active" to="customer">
                <img class="img1" :src="imghost+'/menu/kehu_selected@2x.png'" alt="">
                <img class="img2" :src="imghost+'/menu/kehu_default@2x.png'" alt="">
                <p>客户</p>
            </router-link>
            <router-link tag="div" active-class="active" to="444">
                <img class="img1" :src="imghost+'/menu/tongji_selected@2x.png'" alt="">
                <img class="img2" :src="imghost+'/menu/tongji_default@2x.png'" alt="">
                <p>统计</p>
            </router-link>
        </div>
        <div class="made" v-show="showMode"></div>
        <div class="modes" v-show="showMode">
            <div class="modesInner">
                <div tag="div" @click="changeShow(1)" class="col-xs-3">
                    <img :src="imghost+'/menu/hetong_new@2x.png'" alt="">
                    <p>新建合同</p>
                </div>
                <div @click="changeShow(2)" class="col-xs-3" v-if="userInfo && userInfo.custom_administrators==1">
                    <img :src="imghost+'/menu/kehu_new@2x.png'" alt="">
                    <p>新建客户</p>
                </div>
                <div class="col-xs-3" @click="changeShow(3)" v-if="userInfo && userInfo.is_caiwu==1">
                    <img :src="imghost+'/menu/huikuan@2x.png'" alt="">
                    <p>新建回款</p>
                </div>
                <div @click="changeShow(4)" class="col-xs-3" v-if="userInfo && userInfo.is_caiwu==0">
                    <img :src="imghost+'/menu/jihua@2x.png'" alt="">
                    <p>预计回款</p>
                </div>
            </div>
            <div class="modesClose">
                <img @click="changeShow" class="img" :src="imghost+'/menu/close@2x.png'" alt="">
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapMutations} from 'vuex'
    import {host, imghost} from '../../config/config.js'
    import axios from 'axios'
    export default{
        data(){
            return {
                user: '',
                showMode: false,
                host,
                imghost,
            }
        },
        created(){
            const _this = this
            if (!this.userInfo || !this.userInfo) {
                
                if (dd.version) {
                    dd.ready(function () {
                        dd.runtime.permission.requestAuthCode({
                            corpId: _config.corpId,
                            onSuccess: function (info) {
                                _this.getUserInfo(_config.corpId, info.code)
                            },
                            error: function (xhr, errorType, error) {
                            }
                        })
                        dd.ui.webViewBounce.disable()
                        
                    });
                } else {
                    _this.getUserInfo('', '')
                }
            }
        },
        computed: {
            ...mapState([
                'userInfo'
            ])
        },
        methods: {
            ...mapMutations([
                'CLEAERNEWCUSTOM', 'SETNEWCONTRACT', 'CLEAEREDATA', 'CLEARSELECTCUSROM','SETLINKMAN','CLEAROPTIONCONTRACT','CLEARSELECTINDUSTRY'
            ]),
            getUserInfo(corpId, code){
                
                this.$http('POST', '/user/auth.php', {'corpId': corpId, 'code': code}).then(response => {
                    axios.defaults.headers.common['Authorization'] = response.data.token
                    this.$store.dispatch('setUserInfo', response.data)
                }).catch((err) => {
                    this.I(err, 'e')
                })
                
            },
            changeShow(aa){
                this.showMode = !this.showMode;
                this.CLEARSELECTCUSROM();
                if (aa == 1) {
                    this.SETNEWCONTRACT({
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
                    });
                    this.$router.push('/newContract')
                }
                if (aa == 2) {
                    this.CLEARSELECTINDUSTRY()
                    this.CLEAERNEWCUSTOM();
                    this.SETLINKMAN([]);
                    this.$router.push('/newCustom')
                }
                if (aa == 3) {
                    this.CLEAROPTIONCONTRACT()
                    this.CLEAEREDATA()
                    this.$router.push('/newReceivable')
                }
                if (aa == 4) {
                    this.CLEAROPTIONCONTRACT()
                    this.$router.push('/expectReturn')
                }
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
    @import "../../assets/main.scss";
    
    .menu {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 3;
        background: #fff;
        div {
            padding: 0.2rem 0;
            width: 20%;
            float: left;
            text-align: center;
            position: relative;
            .img1 {
                display: none;
                height: 1rem;
            }
            .img {
                width: 1.6rem;
                height: 1.6rem;
                vertical-align: top;
                margin-top: 0.22rem;
            }
            p {
                font-size: $fontSize;
                color: $menuColor;
            }
            .img2 {
                margin: 0 auto;
                display: block;
                height: 1rem;
            }
        }
        .active {
            p {
                color: $mainColor;
            }
            .img1 {
                margin: 0 auto;
                display: block;
            }
            .img2 {
                display: none;
            }
        }
    }
    
    .made {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 22;
        background: $bgOpcity
    }
    
    .modes {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 22;
        background: $baiColor;
        .modesInner {
            padding: 1rem 0.5rem;
            overflow: hidden;
            .col-xs-3 {
                width: 25%;
                text-align: center;
                img {
                    margin: 0 auto;
                    display: block;
                    width: 60%;
                }
                p {
                    line-height: 1.4rem;
                    font-size: 0.7rem;
                    color: #666666;
                }
            }
        }
        .modesClose {
            border-top: $qianStyle;
            height: 2.4rem;
            img {
                display: block;
                margin: 0.7rem auto;
                width: 1rem;
            }
        }
    }
    
    @media screen and (max-width: 341px) {
        .modes .modesInner .col-xs-3 img {
            width: 65%;
        }
        .modes .modesInner .col-xs-3 p {
            font-size: 0.65rem;
        }
    }
</style>
