<template>
    <div>
        <div class="contract return">
            <div class="container-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">客户名称</div>
                        <div class="col-xs-9">{{data.custom_name}}</div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">预计回款金额</div>
                        <div class="col-xs-9"><span>￥{{data.arrival_amount}}</span></div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">预计回款日期</div>
                        <div class="col-xs-9">{{data.arrival_date}}</div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">跟进人</div>
                        <div class="col-xs-9">{{data.realname}}</div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="top">
                    <p class="p1">合同信息</p>
                    <p class="p2">已选择{{data.contract.length}}个合同<i class="icon iconfont">&#xe622;</i></p>
                </div>
                <div class="hetong" >

                    <div class="container" v-for="item,key in data.contract">
                        <h4>{{item.contract_name}}</h4>
                        <div class="row">
                            <div class="col-xs-3">合同编号</div>
                            <div class="col-xs-9">{{item.contract_number}}</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">合同金额</div>
                            <div class="col-xs-9">￥{{item.contract_money}}</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">本次核销</div>
                            <div class="col-xs-9">￥{{item.returning_money}}</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="container-fluid state">
                <div class="title">
                    <h4>当前状态：未确认到账</h4>
                </div>
                <div class="txt">
                    <textarea></textarea>
                </div>
                <div class="input-group">
                    <input class="ipt1" type="button" value="暂未到账" @click="weidaozhang">
                    <input class="ipt2" type="button" value="确认到账" @click="subdaozhang">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {host, imghost} from '../../../../config/config.js'
    import confirm from './confirm/confirm.vue'
    export default{
        data(){
            return {
                host,
                imghost,
                data:{contract:[]},
            }
        },
        components:{
            confirm
        },
        mounted(){
            this.initData()
        },
        methods:{
            initData(){
                this.$http('GET', '/salesmanreceivables/get_fore_detail.php?id='+this.$route.params.id).then(res => {
                    this.data = res.data
                }).catch(err => {

                })
            },
            weidaozhang(){
                this.$http('POST', '/receivables/financial_confirmation.php',{forid:this.data.id,is_arrival:0}).then(res => {
                    if(res.code==0){
                        this.$router.go(-1)
                    }else {
                        alert(res.msg)
                    }
                }).catch(err => {

                })
            },
            subdaozhang(){
                this.$router.push('/confirm/'+this.data.id)
                // this.$http('POST', '/receivables/financial_confirmation.php',{forid:this.data.id,is_arrival:1}).then(res => {
                //     if(res.code==0){
                //         this.$router.go(-1)
                //     }else {
                //         alert(res.msg)
                //     }
                // }).catch(err => {

                // })
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../../assets/main.scss";
    
    .return {
        .container-fluid {
            margin-bottom: 0.5rem;
            .top {
                margin: 0 0.8rem;
                padding: 0.3rem 0;
                border-bottom: $qianStyle;
                overflow: hidden;
                .p1 {
                    float: left;
                    color: #97a8b3;
                }
                .p2 {
                    float: right;
                    color: #222222;
                    i {
                        color: #777777;
                    }
                }
            }
            .container {
                margin: 0 0.5rem;
                padding: 0.3rem 0;
                border-bottom: $qianStyle;
                h4 {
                    padding-left: 6px;
                }
                .row {
                    border: 0;
                    padding: 0;
                    line-height: 1.4rem;
                    span {
                        color: $mainColor;
                    }
                }
            }
        }
        .state {
            
            .title {
                border-top: 1px solid #e6e6e6;
                padding: 0.3rem 0.8rem;
                background: $bgColor;
                
                h4 {
                    display: inline-block;
                    color: #121213;
                }
                p {
                    display: inline-block;
                    float: right;
                    color: #888888;
                    font-size: 0.65rem;
                }
            }
            .txt {
                padding: 0.5rem 0.8rem;
                textarea {
                    width: 100%;
                    height: 3rem;
                    border-radius: 2px;
                    border: 1px solid #b7c2cf;
                }
            }
        }
    }
</style>
