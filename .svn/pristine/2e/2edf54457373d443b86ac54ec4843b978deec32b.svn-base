<template>
    <div>
        <div class="centerModal bjhkjhModal">
            <div class="modalInner fadeBar">
                <div class="header">
                    <h3>编辑回款计划</h3>
                    <i @click="closeEdit" class="icon iconfont">&#xe60f;</i>
                </div>
                <div class="body">
                    <div class="editPayment">
                        <div class="row">
                            <div class="col-xs-3">第{{editData.index}}期</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">计划日期</div>
                            <div class="col-xs-9">
                                <input type="date" v-model="editData.plan_date" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">回款金额</div>
                            <div class="col-xs-9">
                                <input type="text" v-model="editData.plan_money" value="">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-3">计划类型</div>
                            <div class="col-xs-9">
                                <select v-model="editData.plan_type">
                                    <option value="1">常规</option>
                                    <option value="2">预收款</option>
                                    <option value="3">质保金</option>
                                    <option value="4">尾款</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">备注</div>
                            <div class="col-xs-9">
                                <textarea v-model="editData.plan_remark">备注信息</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button @click="closeEdit" class="btn cancel">取消</button>
                    <button @click="sendData" class="btn confirm">确定</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {host, imghost} from '../../config/config.js'
    export default{
        data(){
            return {
                host,
                imghost,
                editData: {}
            }
        },
        props: ['planData','id','maxMoney'],
        mounted(){
            this.initData()
        },
        methods: {
            initData(){
                let str = this.planData
                this.editData = JSON.parse(str)
                this.I(this.editData)
            },
            closeEdit(){
                this.$emit('closeEditPlan')
            },
            sendData(){
                let plan_id = this.editData.id
                let plan_date = this.editData.plan_date
                let plan_money = this.editData.plan_money //不提交
                let planed_money = this.editData.planed_money
                let plan_type = this.editData.plan_type
                let plan_remark = this.editData.plan_remark
                this.I(this.maxMoney)
                if(Number(planed_money) > Number(plan_money)){
                    
                    return;
                }
                if(Number(plan_money) > this.maxMoney){
                    return;
                }
                let obj = {}
                obj.plan_id = plan_id;
                obj.plan_date = plan_date;
                obj.plan_type = plan_type;
                obj.plan_remark = plan_remark;
                obj.plan_money = plan_money;
                obj.contract_id = this.id;
                
                this.$http('POST','/paymentPlan/pc_put_plan.php',obj).then(res=>{
                    if(res.code == 0){
                        this.$emit('closePlan',res.data)
                    }
                })
            }
        }
        
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
    @import "../../assets/main";
    
    .centerModal {
        .fadeBar {
            position: absolute;
            top: 20%;
            right: 150px;
            width: 450px;
            .body {
                .editPayment {
                    padding: 0 15px 30px;
                    .row {
                        margin-top: 10px;
                        overflow: hidden;
                        
                        .col-xs-3 {
                            padding-right: 15px;
                            text-align: right;
                            color: $huiColor;
                            line-height: 32px;
                        }
                        .col-xs-9 {
                            padding: 0 15px;
                            position: relative;
                            color: #1f2a44;
                            input, select, textarea {
                                padding: 0 10px;
                                width: 260px;
                                height: 30px;
                                color: #121827;
                                border: $borderStyle;
                                border-radius: 3px;
                            }
                            select {
                                width: 280px;
                            }
                            textarea {
                                height: 50px;
                            }
                        }
                    }
                }
            }
        }
    }

</style>
