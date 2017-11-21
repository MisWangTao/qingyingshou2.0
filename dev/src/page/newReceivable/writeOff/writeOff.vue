<template>
    <div>
        <div class="contract detail writeOff">
            <div class="container-fluid">
                <div class="title"><h4>回款信息</h4></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">客户名称</div>
                        <div class="col-xs-9">{{selectCustomer.customName}}</div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">结算方式</div>
                        <div class="col-xs-9">{{newReceivable.payment | echopaymethod}}</div>
                    </div>
                </div>
<!--                 <div class="container">
                    <div class="row">
                        <div class="col-xs-3">账号</div>
                        <div class="col-xs-9">6235635512585562</div>
                    </div>
                </div> -->
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">回款金额</div>
                        <div class="col-xs-9"><span>￥{{newReceivable.accountNum |numberFormat}}</span></div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">回款日期</div>
                        <div class="col-xs-9">{{newReceivable.date}}</div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="title">
                    <h4>核销信息</h4>
                    <p @click="choosecontract">已选择<span>{{optionContract.number}}</span>个合同<i class="icon iconfont">&#xe63c;</i><i class="icon iconfont">&#xe681;</i>
                    </p>
                </div>
                <div class="tishi"><i class="icon iconfont">&#xe874;</i>提示:以下信息为系统根据回款信息自动匹配结果,如不准确,可取消重选;</div>

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
            <div class="input-group">
                <input @click="zhiding" class="ipt1" type="button" value="指给"/>
                <input @click="hexiao" class="ipt2" type="button" value="核销"/>
            </div>
        
        </div>
        
        
        <!-- 选择人员部分弹框 -->
        <div v-show="showadduser" class="modal">
            <div class="modalInner">
                <div class="modalHead">
                    <h4>选择人员</h4>
                    <i class="icon iconfont" @click="closeadduser">&#xe60f;</i>
                </div>
                <div class="modalBody">
                    <div class="cont">
                        <p class="p">回款信息发给指定人员后,可直接认领核销，请选择指定对象:</p>
                        <div class="person">
                            
                            <div class="col" v-for="item,key in checkedusers" >
                                <div class="imgs">
                                    <div class="img">
                                        <img v-if="!item.ding_avatar"  :src="imghost+'menu/hetong_new@2x.png'" alt="">
                                        <img v-if="item.ding_avatar"   :src="item.ding_avatar" alt="">
                                    </div>
                                </div>
                                <p>{{item.realname}}</p>
                            </div>
                            <div class="col" @click="chooseuser">
                                <div class="imgs">
                                    <div class="img">
                                        <img :src="imghost+'tianjia@2x.png'" alt="">
                                    </div>
                                </div>
                                <p class="tjry">添加人员</p>
                            </div>
                        </div>
                    </div>
                    <div class="ipts">
                        <input class="ipt1" type="button" value="取消" @click="closeadduser" />
                        <input class="ipt2" type="button" value="确定" @click="subzhiding" />
                    </div>
                </div>
            </div>
        </div>
        <!-- 选择人员部分弹框 -->
        <div v-show="showchoseuser" class="modal">
            <div class="modalInner">
                <div class="modalHead">
                    <h4>选择人员</h4>
                    <i class="icon iconfont" @click="closechooseuser">&#xe60f;</i>
                </div>
                <div class="modalBody">

                    <div class="cont" v-for="item,key in userlist">
                        <div class="title"><span></span><h4>{{item.depart_name}}</h4></div>
                        <div class="person" >

                            <div class="col" v-for="i,k in item.users" @click="checkeduser(i,key,k)">
                                <div class="imgs">
                                    <div class="img">
                                        <img v-if="i.ding_avatar"   :src="i.ding_avatar" alt="">
                                        <img v-else  :src="imghost+'menu/hetong_new@2x.png'" alt="">
                                    </div>
                                    <div class="active" v-show="i.checked"><i class="icon iconfont">&#xe614;</i></div>
                                </div>
                                <p>{{i.realname}}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {host, imghost} from '../../../config/config.js'
    import {mapState} from 'vuex'
    export default{
        data(){
            return {
                host,
                imghost,
                userlist:[],
                showadduser:false,
                showchoseuser:false,
                checkedusers:[],
            }
        },
        mounted(){

            let id = this.$route.query.custom_id
            this.$http('POST','/receivables/appoint_person.php',{custom_id:id}).then(res=>{
                    this.userlist = res.data
                })
        },
        computed:{
            ...mapState([
                'newReceivable','selectCustomer','optionContract'
            ])
        },
        methods:{
            zhiding(){

                this.showadduser  = true
            },
            closeadduser(){
                this.showadduser  = false
            },
            chooseuser(){
                this.showchoseuser = true
            },
            closechooseuser(){
                this.showchoseuser = false
            },
            checkeduser(user,key,k){
                let users = this.checkedusers.filter( e => { return e.userId == user.userId })

                if(!users.length){
                    this.checkedusers.push(user)
                    this.userlist[key].users[k].checked = true
                }else{
                    const userId = user.userId
                    for(let i = 0 ;i<this.checkedusers.length;i++){
                        if(this.checkedusers[i].userId==userId)this.checkedusers.splice(i,1)
                    }
                    this.userlist[key].users[k].checked = false
                }

                this.showchoseuser = false
            },
            choosecontract(){
                this.$router.push('/optionContract/'+this.$route.query.custom_id)
            },
            subzhiding(){

                if(this.checkedusers.length==0)alert("请选择指派人")
                let id = this.$route.query.rece_id

                var newForm = new FormData()
                newForm.append('id',id)
                newForm.append('userids',JSON.stringify(this.checkedusers))
                
                this.$http('FORM','/receivables/financer_assign_business.php',newForm).then(res=>{
                    if(res.code == 0){
                        this.$router.push('/paymentManage')
                    }else{
                        alert(res.msg)
                    }
                })

            },
            hexiao(){
                let newForm = new FormData()
                newForm.append('id',this.$route.query.rece_id)
                newForm.append('contract',JSON.stringify(this.optionContract.contract))

                this.$http("FORM", 'receivables/business_claim_caiwu.php' ,newForm).then(res => {
                    alert(res.msg)
                })
            }
        },
        
    }
</script>
<style lang="scss" scoped>
    @import "../../../assets/main.scss";
    
    .writeOff {
        .container-fluid {
            .title {
                background: $bgColor;
                p {
                    padding: 0;
                    display: inline-block;
                    float: right;
                    color: #888888;
                    font-size: 0.75rem;
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
            .tishi {
                margin-top: 0.3rem;
                padding: 0 0.5rem 0 0.8rem;
                font-size: 0.55rem;
                color: #ccc;
                i {
                    font-size: 0.6rem;
                    margin-right: 0.2rem;
                    color: $chengColor;
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
    
    .cont {
        padding: 0.3rem 0.5rem;
        overflow: hidden;
        .p {
            color: #333333;
        }
        .title {
            span {
                margin: 0 5px 3px 0;
                display: inline-block;
                width: 5px;
                height: 5px;
                background: $mainColor;
            }
            h4 {
                display: inline-block;
                font-size: $fontSize;
                color: #666666;
            }
        }
        .person {
            margin-top: 0.5rem;
            overflow: hidden;
            .col {
                margin: 0.3rem 0;
                width: 33.333%;
                float: left;
                text-align: center;
                .imgs {
                    width: 60%;
                    margin: 0 auto;
                    position: relative;
                    .img {
                        position: relative;
                        width: 100%;
                        padding-bottom: 100%;
                        img {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            border-radius: 50%;
                            
                        }
                    }
                    .active {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(56, 145, 249, 0.4);
                        border-radius: 50%;
                        i {
                            font-size: 1.5rem;
                            color: $baiColor;
                            opacity: 0.8;
                        }
                    }
                }
                p {
                    line-height: 1.2rem;
                    font-size: 0.65rem;
                    color: #000000;
                }
                .tjry {
                    color: #5a6879;
                }
            }
        }
    }
</style>
