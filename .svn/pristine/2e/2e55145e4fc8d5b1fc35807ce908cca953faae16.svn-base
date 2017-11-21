<template>
	<div>
		<div class="centerModal tjhkjhModal">
			<div class="modalInner fadeBar">
				<div class="header">
					<h3>添加回款计划</h3>
					<i @click="closePlan" class="icon iconfont">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="editPayment">
						<div class="row">
							<div class="col-xs-3">计划日期</div>
							<div class="col-xs-9">
								<input type="date" v-model="addPlanData.date" value="">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">回款金额</div>
							<div class="col-xs-9">
								<input type="text" v-model="addPlanData.money" value="">
							</div>
						</div>

						<div class="row">
							<div class="col-xs-3">计划类型</div>
							<div class="col-xs-9">
								<select v-model="addPlanData.type">
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
								<textarea v-model="addPlanData.remark">备注信息</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="footer">
					<button @click="closePlan" class="btn cancel">取消</button>
					<button @click="sendData" class="btn confirm">确定</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import {host, imghost} from '../../../../config/config.js'
	export default{
		data(){
			return {
				host,
				imghost,
                addPlanData:{}
			}
		},
		props:['id'],
        methods:{
		    closePlan(){
		        this.$emit('closePlan')
            },
            sendData(){
		        if(this.addPlanData.date == '' || this.addPlanData.date == undefined){
		            return;
                }
		        if(this.addPlanData.money == '' || this.addPlanData.money == undefined){
		            return;
                }
                this.addPlanData.contract_id = this.id

                let returnPlanObj = {}
                returnPlanObj.plan_money = this.addPlanData.money 
                returnPlanObj.plan_type = this.addPlanData.type 
                returnPlanObj.plan_date = this.addPlanData.date 
                returnPlanObj.plan_remark = this.addPlanData.remark
                let returnPlan = []
                returnPlan.push(returnPlanObj)
                // console.log(returnPlan)
                // return; 
                this.$http('POST','/paymentPlan/add_plan.php',{contract_id:this.id,returnPlan:JSON.stringify(returnPlan)}).then(res=>{
                    if(res.code == 0){
                    	this.$emit('closePlan')
                    }
                })
            }
        }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../../assets/main";
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
							input,select,textarea {
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
