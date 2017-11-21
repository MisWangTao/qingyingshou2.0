<template>
    <div id="remind">
        <div class="remindTop">
            <div @click="switchindex(1)">
                <span :class="{active:showindex==1}">待处理</span>
            </div>
            <div @click="switchindex(2)">
                <span :class="{active:showindex==2}">已处理</span>
            </div>
            <div @click="switchindex(3)">
                <span :class="{active:showindex==3}">我发起的</span>
            </div>
        </div>
        <div class="mainCont">
            
            <!-- 待处理部分 -->
            <div class="pending" v-show="showindex==1">
                <div class="itemlist" v-for="item,key in datalist" v-if=" item.type==1 && item.state==0 && (item.style==1 || item.style==3) &&  item.accept_userid==userInfo.id " @click="showdetail(item.type,item.state,item.style,item)">
                    <div class="renlogo">
                        <img :src="imghost+'logo_defaullt@2x.png'" alt="">
                    </div>
                    <div class="rentitle">
                        <p>
                            <label v-if="item.style==1">回款认领</label>
                            <label v-if="item.style==3">预计回款</label>
                            <span>{{item.add_time}}</span>
                        </p>
                        <p>
                            
                            <label v-if="item.style==1">{{item.send_user}}发来了一条回款认领消息</label>
                            <label v-if="item.style==3">{{item.send_user}}发来了一条预计回款消息</label>
                            <span><i class="icon iconfont">&#xe681;</i></span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- 已处理部分 -->
            <div class="already" v-show="showindex==2">
                <div class="itemlist">
                    <div class="renlogo">
                        <img :src="imghost+'logo_defaullt@2x.png'" alt="">
                    </div>
                    <div class="rentitle">
                        <p>
                            回款认领
                            <span>2017-02-04 12:21</span>
                        </p>
                        <p>
                            aaa发来了一条回款消息认领
                            <span><i class="icon iconfont">&#xe681;</i></span>
                        </p>
                    </div>
                </div>
            </div>
            <!-- 我发起的 -->
            <div class="sent" v-show="showindex==3">
                <div class="itemlist">
                    <div class="renlogo">
                        <img :src="imghost+'/remind/chuli.png'" alt="">
                    </div>
                    <div class="rentitle">
                        <p>
                            已处理
                            <span>2017-02-04 12:21</span>
                        </p>
                        <p>
                            回款认领信息已确认，请及时确认！
                            <span><i class="icon iconfont">&#xe681;</i></span>
                        </p>
                    </div>
                </div>
                <div class="itemlist">
                    <div class="renlogo">
                        <img :src="imghost+'remind/dengdai.png'" alt="">
                    </div>
                    <div class="rentitle">
                        <p>
                            等待操作
                            <span>2017-02-04 12:21</span>
                        </p>
                        <p>
                            回款认领信息已确认，请及时确认！
                            <span><i class="icon iconfont">&#xe681;</i></span>
                        </p>
                    </div>
                </div>
                <div class="itemlist">
                    <div class="renlogo">
                        <img :src="imghost+'remind/tuihui.png'" alt="">
                    </div>
                    <div class="rentitle">
                        <p>
                            已退回
                            <span>2017-02-04 12:21</span>
                        </p>
                        <p>
                            回款认领信息已确认，请及时确认！
                            <span><i class="icon iconfont">&#xe681;</i></span>
                        </p>
                    </div>
                </div>
                <div class="itemlist">
                    <div class="renlogo">
                        <img :src="imghost+'/remind/yichang.png'" alt="">
                    </div>
                    <div class="rentitle">
                        <p>
                            异常
                            <span>2017-02-04 12:21</span>
                        </p>
                        <p>
                            回款认领信息已确认，请及时确认！
                            <span><i class="icon iconfont">&#xe681;</i></span>
                        </p>
                    </div>
                </div>
            </div>
        
        
        </div>
    </div>
</template>
<script>
    import {imghost} from '../../../config/config'
    import {mapState} from 'vuex'
    export default{
        data(){
            return {
                imghost,
                showindex:1,
                datalist:[]
            }
        },
        computed: {
            ...mapState([
                'userInfo'
            ]),
            
        },
        mounted(){
            this.initData()
        },
        methods:{
            switchindex(index){
                this.showindex = index
            },
            initData(){

                this.$http("GET", 'news/get_news_list.php').then(res => {
                    this.datalist = res.data
                }).catch(err => {

                })
            },
            showdetail(type,state,style,item){
                if(type==1 && state==0 && style==1){
                    this.$router.push('/claimPayment/'+item.id)
                }
                else if(type==1 && state==0 && style==3){
                    this.$router.push('/estimatedReturn/'+item.id)
                }
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../assets/main";
    
    #remind {
        background-color: #fff;
        
        .remindTop {
            border-bottom: 1px solid #CADEEA;
            padding: 0.3rem 0;
            display: -webkit-box;
            display: -moz-box;
            display:-webkit-flex;
            display: -ms-flexbox;
            display:flex;
            div {
                height: 1rem;
                width: 33%;
                border-right: 1px solid #eee;
                padding: 0 1rem;
                span {
                    width: 100%;
                    height: calc(100% + 0.3rem);
                    display: block;
                    line-height: 1rem;
                    text-align: center;
                }
                span.active {
                    border-bottom: 2px solid #3891F9;
                    color: #3891F9;
                }
            }
            div:last-child {
                border: none;
            }
        }
        .itemlist {
            padding: 0.5rem;
            border-bottom: $borderStyle;
            overflow: hidden;
            .renlogo {
                float: left;
                position: relative;
                width: 15%;
                img {
                    display: block;
                    width: 1.5rem;
                    height: 1.5rem;
                    border-radius: 50%;
                    margin: 0.5rem 0 0 0.3rem;
                }
            }
            .rentitle {
                float: left;
                width: 85%;
                p {
                    line-height: 1.2rem;
                    color: #121213;
                    span {
                        font-size: 0.45rem;
                        float: right;
                        color: #5a6879;
                    }
                }
                p:last-child {
                    font-size: 0.65rem;
                    color: #5a6879;
                }
            }
        }
    }
</style>
