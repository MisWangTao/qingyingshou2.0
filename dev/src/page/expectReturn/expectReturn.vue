<template>
    <div id="expectReturn">
        <div class="container" @click="selectCumter">
            <div class="row">
                <div class="col-xs-3">客户名称</div>
                <div class="col-xs-9"><input type="text" disabled placeholder="请选择客户名称"
                                             :value="selectCustomer.customName"><i
                    class="icon iconfont">&#xe681;</i>
                </div>
            </div>
        </div>
        <div class="container conMoney">
            <div class="row">
                <div class="col-xs-3">计划回款金额</div>
                <div class="col-xs-9"><input type="text" v-model="expectReturn.arrival_amount" placeholder="请输入计划回款金额">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-xs-3">计划回款日期</div>
                <div class="col-xs-9"><input type="date" v-model="expectReturn.arrival_date" placeholder="请选择计划回款日期">
                </div>
            </div>
        </div>
        <div class="container" @click="selectContract">
            <div class="row">
                <div class="col-xs-3">选择合同</div>
                <div class="col-xs-9 text-right">
                    已选择<span>{{optionContract.number}}</span>个合同
                    <i class="icon iconfont">&#xe681;</i>
                </div>
            </div>
        </div>
        <div class="container containerLast" @click="showfinance">
            <div class="row">
                <div class="col-xs-3">发给谁？</div>
                <div class="col-xs-2" v-show="checked.id">
                    <img :src="checked.ding_avatar" alt="">
                    <p>{{checked.realname}}</p>
                </div>
            </div>
        </div>
        <div class="btn">
            <button @click="submit">确定</button>
        </div>

        <div v-show="checkedfinance" class="modal">
            <div class="modalInner">
                <div class="modalHead">
                    <h4>发给谁</h4>
                    <i class="icon iconfont" @click="closecheckedfinance">&#xe60f;</i>
                </div>
                <div class="modalBody">
                    <div class="cont">
                        <div class="person" >

                            <div class="col" v-for="item,key in financelist" @click="checkefinance(item)">
                                <div class="imgs">
                                    <div class="img">
                                        <img v-if="item.ding_avatar" :src="item.ding_avatar" alt="">
                                        <img v-if="!item.ding_avatar" :src="imghost+'menu/hetong_new@2x.png'" alt="">
                                    </div>
                                    <div class="active" v-if="checked.id==item.id"><i class="icon iconfont">&#xe614;</i></div>
                                </div>
                                <p>{{item.realname}}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {imghost} from '../../config/config'
    import {mapState} from 'vuex'
    import ccl from '../../common/ccl.js'
    export default{
        data(){
            return {
                imghost,
                financelist:[],
                checkedfinance:false,
                checked:{},
            }
        },
        computed: {
            ...mapState([
                'selectCustomer','expectReturn','optionContract'
            ]),
            
        },
        mounted(){

            this.checked = this.expectReturn.checked?this.expectReturn.checked:{}
            delete(this.expectReturn['checked'])
        },
        methods: {
            selectCumter(){

                this.expectReturn.checked  = this.checked
                this.$router.push('/selectCustomer')
            },
            selectContract() {
                if(!this.selectCustomer.customId){
                    alert('请先选择客户')
                    return
                }
                this.expectReturn.checked  = this.checked
                this.$router.push('/optionContract/'+this.selectCustomer.customId)
            },
            showfinance(){
                this.$http('GET', '/receivables/get_finance_list.php').then(response => {
                    this.financelist = response.data
                    this.checkedfinance = true
                })
            },
            closecheckedfinance(){
                this.checkedfinance = false
            },
            checkefinance(item){
                this.checked = item
                setTimeout(()=>{ this.checkedfinance = false },300)
            },
            submit(){
                this.expectReturn.custom_id = this.selectCustomer.customId
                this.expectReturn.contract  = this.optionContract.contract

                var newForm = new FormData()
                for(let key in this.expectReturn){
                    if(key=='contract'){
                        newForm.append(key,JSON.stringify(this.expectReturn[key]))
                    }
                    else {
                        newForm.append(key,this.expectReturn[key])
                    }
                }
                newForm.append('assist_id',this.checked.id)
                
                this.$http('FORM', '/salesmanreceivables/add_fore_busness.php', newForm).then(response => {
                    if(response.code==0){
                        this.$router.push('/paymentManage')
                    }else{
                        ccl.alert({text:response.msg})
                    }
                })
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../assets/main";
    
    #expectReturn {
        input {
            border: none;
        }
        .container {
            margin-bottom: 0.5rem;
            color: #888;
            height: calc(2.1rem + 1px);
            padding: 0 0.5rem;
            background-color: #fff;
            .row {
                height: 1.1rem;
                border-bottom: 1px solid #eee;
                padding: 0.5rem 0;
                i {
                    float: right;
                    line-height: 1.1rem;
                }
            }
            
        }
        .conMoney {
            margin: 0;
        }
        .containerLast {
            height: 3rem;
            line-height: 3rem;
            .row {
                padding: 0;
                height: 3rem;
                .col-xs-2 {
                    position: relative;
                    text-align: center;
                    img {
                        width: 1.25rem;
                        height: 1.25rem;
                    }
                    p {
                        position: absolute;
                        left: 0;
                        width: 100%;
                        font-size: 0.5rem;
                        top: 2rem;
                        height: 0.7rem;;
                        line-height: 0.7rem;
                    }
                }
            }
        }
        .btn {
            margin: 3rem auto 0;
        }
    }
    .cont {
        padding: 0.3rem 0.5rem;
        overflow: hidden;
        .p {
            color: #333333;
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
