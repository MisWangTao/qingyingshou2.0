<template>
    <div>
        <div class="fade xxtxModal">
            <div class="madol">
                <div class="top">
                    <h4>消息提醒</h4>
                    <i class="icon iconfont" @click="closenewslist">&#xe60f;</i>
                </div>
                <div class="items">
                    <div class="pending">
                        <div class="row active">
                            <div class="col-xs-4">待处理</div>
                            <div class="col-xs-8">
                                <span>5</span>
                                <i class="icon iconfont">&#xe681;</i>
                            </div>
                        </div>
                        <div class="more">
                            <div class="row" v-for="item,key in newsList" v-show=" item.type==1 && item.state==0 && (item.style==1 ||item.style==7 || item.style==3 || item.style==6) "
                                 @click="showDetails(item)">
                                <div class="col-2">
                                    <i class="icon iconfont">&#xe620;</i>
                                </div>
                                <div class="col-10">
                                    <p>{{item.add_time}}</p>
                                    <p v-show="item.style==6">{{item.send_user}}发来一条:<span>{{item.contract_name}}</span>的变更申请</p>
                                    <p v-show="item.style==7">您提交的变更申请未通过，请及时查看</p>
                                    <p v-show="item.style==1">{{item.send_user}}发来一条回款认领消息</p>
                                    <p v-show="item.style==3">{{item.send_user}}发来一条预计回款消息</p>
                                </div>
                            </div>
                            <!--<div class="row">
                                <div class="col-2">
                                    <i class="icon iconfont">&#xe620;</i>
                                </div>
                                <div class="col-10">
                                    <p>2017-08-15 12:56:26</p>
                                    <p>李光洙发来一条:<span>设备销售合同KY-653</span>的变更申请</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <i class="icon iconfont">&#xe620;</i>
                                </div>
                                <div class="col-10">
                                    <p>2017-08-15 12:56:26</p>
                                    <p>李光洙发来一条:<span>设备销售合同KY-653</span>的变更申请</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <i class="icon iconfont">&#xe620;</i>
                                </div>
                                <div class="col-10">
                                    <p>2017-08-15 12:56:26</p>
                                    <p>李光洙发来一条:<span>设备销售合同KY-653</span>的变更申请</p>
                                </div>
                            </div>
                            <div class="row yidu">
                                <div class="col-2">
                                    <i class="icon iconfont">&#xe620;</i>
                                </div>
                                <div class="col-10">
                                    <p>2017-08-15 12:56:26</p>
                                    <p>李光洙发来一条:<span>设备销售合同KY-653</span>的变更申请</p>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">通知</div>
                        <div class="col-xs-8">
                            <span>5</span>
                            <i class="icon iconfont">&#xe681;</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <apply @closeDetail="closeDetails" :newsId="this.newsId" :id="this.detailId" v-if="showDetail"></apply>
        <claimReturn @closeDetail="closeclaimreturn" :newsId="this.newsId" :id="this.detailId"  v-if="isshowclaimReturn"></claimReturn>
        <noTongguo @closeDetail="closeNotongguo" :newsId="this.newsId" :id="this.detailId" v-if="showNotongtuo"></noTongguo>
        <yujiReturnInfo @closeDetail="closeyujiReturnInfo" :newsId="this.newsId" :id="this.detailId" v-if="isshowyujiReturnInfo"></yujiReturnInfo>
    </div>
</template>

<script>
    import {host, imghost} from '../../../config/config.js'
    import apply from './apply/apply.vue'
    import noTongguo from './noTongguo/noTongguo.vue'
    import claimReturn from './claimReturn/claimReturn.vue'
    import yujiReturnInfo from './yujiReturnInfo/yujiReturnInfo.vue'
    export default{
        data(){
            return {
                host,
                imghost,
                newsList: [],
                showDetail: false,
                detailId : '',
                newsId : '',
                isshowclaimReturn:false,
                showNotongtuo : false,
                isshowyujiReturnInfo:false
            }
        },
        mounted(){
            this.initData()
        },
        components: {
            apply,
            claimReturn,
            noTongguo,
            yujiReturnInfo
        },
        methods: {
            initData(){
                this.$http('GET', '/news/get_news_list.php').then(res => {
                    this.newsList = res.data
                }).catch(err => {
                
                })
            },
            closenewslist(){
                this.$emit('closenewslist')
            },
            closeDetails(){
                this.showDetail = false
            },
            showDetails(item){
                this.detailId = item.relation_id
                this.newsId = item.id

                if(item.style == 6){
                    this.showDetail = true
                }
                else if(item.style == 1){
                    this.isshowclaimReturn = true
                }
                else if(item.style == 7){
                    this.showNotongtuo = true
                }
                else if(item.style == 3){
                    this.isshowyujiReturnInfo = true
                }
                
            },
            closeclaimreturn(){
                this.isshowclaimReturn = false
            },
            closeNotongguo(){
                this.showNotongtuo = false
            },
            closeyujiReturnInfo(){
                this.isshowyujiReturnInfo = false
            }
        },
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
    @import "../../../assets/main";
    
    .fade {
        .madol {
            width: 560px;
            height: 100%;
            overflow: auto;
            .top {
                background: $danlanColor;
                border-bottom: $qianStyle;
                overflow: hidden;
                position: relative;
                h4 {
                    text-align: center;
                    font-size: 18px;
                    line-height: 40px;
                    font-weight: normal;
                    color: #1f2a44;
                }
                i {
                    position: absolute;
                    font-size: 18px;
                    top: 10px;
                    right: 10px;
                    cursor: pointer;
                }
            }
            .items {
                padding: 20px 30px 130px;
                .row {
                    height: 50px;
                    overflow: hidden;
                    
                    border-bottom: $qianStyle;
                    color: $hColor;
                    cursor: pointer;
                    .col-xs-4 {
                        font-size: 16px;
                        padding-left: 20px;
                        line-height: 50px;
                    }
                    .col-xs-8 {
                        text-align: right;
                        line-height: 50px;
                        span {
                            margin-right: 10px;
                        }
                        i {
                            font-size: 14px;
                            color: #c2c6c9;
                        }
                    }
                    .col-2 {
                        width: 10%;
                        float: left;
                        padding-left: 20px;
                        line-height: 50px;
                        i {
                            font-size: 22px;
                            color: $redColor;
                        }
                    }
                    .col-10 {
                        width: 84%;
                        float: left;
                        padding: 5px 0;
                        p {
                            line-height: 20px;
                            color: $huiColor;
                        }
                        p:first-child {
                            font-size: 12px;
                        }
                        p:nth-child(2) {
                            font-size: 14px;
                        }
                    }
                }
                .yidu {
                    .col-2 {
                        i {
                            color: #c2c6c9;
                        }
                    }
                    .col-10 {
                        p {
                            color: #c2c6c9;
                        }
                    }
                }
                .active {
                    .col-xs-4 {
                        color: $mainColor;
                    }
                }
                .row:hover {
                    background: #eef2f4;
                }
                .active:hover {
                    background: #ffffff;
                }
            }
        }
    }

</style>
