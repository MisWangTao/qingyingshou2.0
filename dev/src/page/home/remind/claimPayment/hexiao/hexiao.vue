<template>
    <div>
        <div class="contract detail hexiao">
            <div class="container-fluid">
                <div class="title"><h4>回款信息</h4></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">客户名称</div>
                        <div class="col-xs-9">{{data.custom_name}}</div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">结算方式</div>
                        <div class="col-xs-9">{{data.payment_method | echopaymethod}}</div>
                    </div>
                </div>
<!--                 <div class="container">
                    <div class="row">
                        <div class="col-xs-3">账号</div>
                        <div class="col-xs-9">{{data.values}}</div>
                    </div>
                </div> -->
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">回款金额</div>
                        <div class="col-xs-9"><span>{{data.arrival_amount}}</span></div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">回款日期</div>
                        <div class="col-xs-9">{{data.arrival_date}}</div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="title">
                    <h4>核销信息</h4>
                    <p @click="choosecontract">已选择<span>{{optionContract.number}}</span>个合同<i class="icon iconfont">&#xe681;</i>
                    </p>
                </div>
                <div class="container" v-for="item,key in optionContract.contract">
                    <h4>{{item.contract_name}}</h4>
                    <div class="row">
                        <div class="col-xs-3">合同编号</div>
                        <div class="col-xs-9">{{item.contract_number}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">合同金额</div>
                        <div class="col-xs-9">￥{{item.contract_money | numberFormat}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">本次核销</div>
                        <div class="col-xs-9">￥{{item.returning_money | numberFormat}}</div>
                    </div>
                </div>
            </div>
            <div class="btn">
                <button @click="submit">确定</button>
            </div>
        
        </div>
        
    </div>
</template>
<script>
    import {host, imghost} from '../../../../../config/config.js'
    import {mapState} from 'vuex'
    import ccl from '../../../../../common/ccl.js'
    export default{
        data(){
            return {
                host,
                imghost,
                data:{}
            }
        },
        mounted(){
            this.initData()
        },
        computed:{
            ...mapState([
                'optionContract'
            ]),
        },
        methods:{
            initData(){

                const iscaiwu = this.$route.query.caiwu
                let apiurl = ''
                if(iscaiwu==1) apiurl='receivables/get_receivable_details.php' ; else apiurl= 'receivables/business_claim_detail.php'

                this.$http("POST", apiurl,{id:this.$route.params.id}).then(res => {
                    this.data = res.data
                }).catch(err => {

                })
            },
            choosecontract(){
                this.$router.push('/optionContract/'+this.data.custom_id)
            },
            submit(){

                if(!this.optionContract.contract.length)alert('请选择合同')
                const iscaiwu = this.$route.query.caiwu

                let newForm = new FormData()
                if(iscaiwu==1){
                    newForm.append('id',this.$route.params.id)
                }else{
                    newForm.append('newsid',this.$route.params.id)
                }
                
                newForm.append('contract',JSON.stringify(this.optionContract.contract))

                let apiurl = ''

                if(iscaiwu==1) apiurl='receivables/business_claim_caiwu.php' ; else apiurl= 'receivables/business_claim.php'

                this.$http("FORM", apiurl ,newForm).then(res => {
                    if(res.code==0){
                        this.$router.go(-2)
                    }else{
                        ccl.alert({text:res.msg})
                    }
                }).catch(err => {

                })         
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../../../assets/main.scss";
    
    .hexiao {
        .container-fluid {
            .title {
                background: $bgColor;
                p {
                    padding: 0;
                    display: inline-block;
                    float: right;
                    color: #888888;
                    font-size: 0.7rem;
                    span {
                        margin: 0 0.2rem;
                        color: $mainColor;
                    }
                    i {
                        margin-left: 0.3rem;
                        font-size: 0.9rem;
                        color: $mainColor;
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
    }
</style>
