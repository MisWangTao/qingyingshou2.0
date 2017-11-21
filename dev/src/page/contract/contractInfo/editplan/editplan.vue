<template>
    <div id="huikuanPlan">
        <div class="allMoney">
            合同金额：<span>{{data.contract.contract_money}}</span>
        </div>

        <div class="huikuanItem" v-for="item,key in data.plan">
            <div class="itemNum">
                第 {{key+1}} 期
                <i class="icon iconfont">&#xe601;</i>
            </div>
            <div class="planItem planDate">
                <span class="labels">计划日期</span>
                <input type="date" v-model="data.plan[key].plan_date"><i class="icon iconfont">&#xe681;</i>
            </div>
            <div class="planItem planMoney">
                <span class="labels">回款金额</span>
                <input type="text" v-model="data.plan[key].plan_money">
            </div>
            <div class="planItem planType">
                <span class="labels">计划类型</span>
                <!-- <input type="text" v-model="data.plan[key].plan_type"><i class="icon iconfont">&#xe681;</i> -->
                <select v-model="data.plan[key].plan_type">
                    <option value="1">常规</option>
                    <option value="2">预收款</option>
                    <option value="3">质保金</option>
                    <option value="4">尾款</option>
                </select>
            </div>
            <div class="planItem planRemark">
                <span class="labels">备注</span>
                <input type="text" placeholder="30字以内备注信息" v-model="data.plan[key].plan_remark">
            </div>
        </div>

        <div class="addPlan" @click="addPlan">
            +添加回款计划
        </div>
        <div class="tixing">
            <span>到期提醒</span>
            <span>提前
                 <select style="border:none;" v-model="data.contract.advance_remind">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                </select>
            天</span>
            <img @click="changreminder" v-if="!data.contract.expiration_reminder" :src="imghost+'switch_off@2x.png'" alt="">
            <!-- 打开显示图片 -->
            <img @click="changreminder" v-else :src="imghost+'switch_on@2x.png'" alt="">
        </div>
        <div class="ok" @click="subedit">
            确 定
        </div>
    </div>
</template>
<script>
    import {host, imghost} from '../../../../config/config'
    import ccl from '../../../../common/ccl.js'
    export default{
        data(){
            return {
                imghost,
                data:{contract:{},plan:[]},
            }
        },
        mounted(){
            this.initData()
        },
        methods:{
            initData(){
                this.$http('POST', '/contract/get_contract_info.php',{id:this.$route.params.id}).then(res => {
                    if(res.data.plan.length==0)res.data.plan.push({})
                    this.data = res.data
                }).catch(err => {

                })
            },
            addPlan(){
                this.data.plan.push({})
            },
            subedit(){
                let newForm = new FormData()
                newForm.append('id',this.$route.params.id)
                newForm.append('advance_remind',this.data.contract.advance_remind)
                newForm.append('expiration_reminder',this.data.contract.expiration_reminder)
                newForm.append('returnPlan',JSON.stringify(this.data.plan))

                this.$http("FORM", 'paymentPlan/put_plan.php' ,newForm).then(res => {
                    if(res.code==0){
                        this.$router.go(-1)
                    }else{
                        ccl.alert({text:res.msg})
                    }
                })
            },
            changreminder(){
                this.data.contract.expiration_reminder = Number(!this.data.contract.expiration_reminder)
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../../assets/main";
    
    #huikuanPlan {
        input {
            border: none;
        }
        .allMoney {
            height: 0.6rem;
            padding: 0.5rem 0.5rem 0 0.5rem;
            font-size: 0.6rem;
            color: #5a6879;
            text-align: right;
            line-height: 0.6rem;
            span {
                color: #3891f9;
            }
        }
        .huikuanItem {
            margin-top: 0.5rem;
            padding: 0 0.5rem;
            background-color: #fff;
            div {
                border-bottom: 1px solid #eee;
            }
            div.planItem {
                padding: 0.3rem 0 0.3rem 0.5rem;
                line-height: 0.6rem;
                i {
                    float: right;
                    line-height: 1.2rem;
                }
                select {
                    border:none;
                    width:60%;
                }
            }
            .labels {
                display: inline-block;
                color: #999;
                font-size: 0.7rem;
                width: 30%;
            }
            .itemNum {
                height: 1.25rem;
                font-size: 0.6rem;
                line-height: 1.25rem;
                padding-left: 0.5rem;
                border-bottom: 1px solid #eee;
                position: relative;
                i {
                    position: absolute;
                    top: 0.05rem;
                    right: 0;
                    font-size: 0.75rem;
                    color: $redColor;
                }
            }
        }
        .addPlan {
            position: relative;
            text-align: center;
            height: 1.5rem;
            line-height: 1.5rem;
            color: #3891f9;
            padding: 0 0.5rem;
            span {
                position: absolute;
                top: 0;
                right: 0.5rem;
            }
        }
        .tixing {
            position: relative;
            padding: 0.5rem;
            background-color: #fff;
            span:first-child {
                display: inline-block;
                font-size: 0.65rem;
                color: #999;
                width: 30%;
            }
            span:last-child {
                display: inline-block;
                font-size: 0.6rem;
                width: 30%;
            }
            input {
                border: none;
                width: 4rem;
                height: 1rem;
                position: absolute;
                right: 0;
                top: 0.5rem;
                z-index: 12;
                opacity: 0;
            }
            img {
                width: 2rem;
                position: absolute;
                right: 0.5rem;
                top: 0.5rem;
                z-index: 10;
            }
        }
        .ok {
            width: 80%;
            height: 2rem;
            border-radius: 5px;
            background-color: #3891f9;
            text-align: center;
            line-height: 2rem;
            color: #fff;
            font-size: 0.8rem;
            margin: 4rem auto 0;
        }
        .tiaoguo {
            margin: 0.8rem auto 0;
            text-align: center;
            height: 0.6rem;
            line-height: 0.6rem;
            color: #666;
        }
    }
</style>
