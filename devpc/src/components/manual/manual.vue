<template>
	<div>
		<div class="centerModal sdtjModal">
			<div class="modalInner">
				<div class="header">
					<h3>添加回款计划</h3>
					<i class="icon iconfont" @click="closeThisComponent">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="tishi">提示：合同金额:<span class="jine">{{this.sendHuikuanMoney | numberFormat}}</span> 该客户可<span class="lan" @click="qiehuanzidong">自动生成</span>回款计划</div>
					<div class="addPlan">
						<table>
							<thead>
								<tr>
									<th>期次</th>
									<th>计划回款时间</th>
									<th>计划类型</th>
									<th>计划金额</th>
									<th>备注</th>
									<th><i class="icon iconfont jia" @click="addReturnPlanDom">&#xe616;</i></th>

								</tr>
							</thead>
							<tbody>
								<tr v-for="item,key in returnPlanMap">
									<td>{{key+1}}</td>
									<td><input type="date" v-model="item.plan_date"></td>
									<td><select v-model="item.plan_type">
										<option value="1">常规</option>
										<option value="2">预收款</option>
										<option value="3">质保金</option>
										<option value="4">尾款</option>
									</select></td>
									<td><input type="text" v-model="item.plan_money"></td>
									<td><input type="text" v-model="item.plan_remark"></td>
									<td>
										<!-- <i class="icon iconfont jia">&#xe616;</i> -->
										<i class="icon iconfont dele" @click="removeReturnPlanDom(key)">&#xe610;</i>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="tixing">
							到期提醒<select ref="tixing">
								<option value="7">提前7天</option>
								<option value="6">提前6天</option>
								<option value="5">提前5天</option>
								<option value="4">提前4天</option>
								<option value="3">提前3天</option>
								<option value="2">提前2天</option>
								<option value="1">提前1天</option>

							</select>
						</div>
					</div>
				</div>
				<div class="footer">
					<span @click="closeManualAndNewContractComponents">暂不添加</span>
					<button class="btn confirm" @click="sendData">确定</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../config/config.js'
	export default{
		data(){
			return {
				host,
				imghost,
				sendReturnPlan:{},
				returnPlanMap:[
					{
						plan_date:'',
						plan_type:1,
						plan_money:'',
						plan_remark:'',
					},
				],
			}
		},
		props:['sendHuikuanDate','sendHuikuanMoney','sendHuikuanMoneyed','sendHuikuanMaDate','sendContractId'],
		methods:{
			//关闭手动添加回款计划
			closeThisComponent(){
				this.$emit('closeManual')
			},
			//切换为自动生成回款计划
			qiehuanzidong(){

				this.$emit('qiehuanzidonghuikuan')
			},
			//点击添加回款计划
			addReturnPlanDom(){

				let returnPlan={

					plan_date:'',
					plan_type:1,
					plan_money:'',
					plan_remark:'',
				}
				this.returnPlanMap.push(returnPlan)
			},
			//点击删除回款计划
			removeReturnPlanDom(key){
				this.returnPlanMap.splice(key,1)
			},
			//关闭手动回款计划和新建合同组件
			closeManualAndNewContractComponents(){
				
				this.$emit('closeManualAndNewContractComponents')
			},
			//提交数据
			sendData(){

				let sumReturnMoney = 0

				if(this.sendContractId==''){
					alert('合同Id不能为空!')
					return
				}

				for(let i=0;i<this.returnPlanMap.length;i++)
				{
					sumReturnMoney+=Number(this.returnPlanMap[i].plan_money)

					if(this.returnPlanMap[i].plan_date=='')
					{
						alert('回款计划时间不能为空!')
						return
					}

					if(this.returnPlanMap[i].plan_date < this.sendHuikuanDate)
					{
						alert('回款计划时间不能早于合同时间!')
						return
					}
					if(this.returnPlanMap[i].plan_money=='')
					{
						alert('回款计划金额不能为空!')
						return 
					}
				}

				if(Number(sumReturnMoney) > Number(this.sendHuikuanMoney)){
					alert('回款计划总额不能超过合同金额!')
					return
				}

				let returnPlan = JSON.stringify(this.returnPlanMap)
				let advance_remind = this.$refs.tixing.value ?　this.$refs.tixing.value　: ''
				
				let newForm = new FormData()
				newForm.append('contract_id', this.sendContractId)
				newForm.append('returnPlan',returnPlan)
				newForm.append('advance_remind',advance_remind)

				this.$http("FORM",'/paymentPlan/add_plan.php',newForm).then(res=>{

					if(res.code==0)
					{
						this.$emit('closeManualAndNewContractComponents')
					}

				}).catch(err => {
                	
                })
			},
		}

	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main.scss";
	.tishi {
		padding: 15px 20px 20px;
		text-align: right;
		color: #5a6879;
		.jine {
			margin: 0 5px;
		}
		.lan {
			color: $mainColor;
		}
	}
	.addPlan {
		margin-bottom: 30px;
		padding: 0 20px;
		border-radius: 4px;
		min-height: 240px;
		overflow: hidden;
		table {
			width: 100%;
			border: $borderStyle;
			
			border-collapse:collapse;
			i {
				font-size: 14px;
			}
			.jia {
				margin-right: 3px;
				color: $mainColor;
			}
			.dele {
				color: $redColor;
			}

			thead {
				background: #eef1f6;
				tr {
					th{
						white-space: nowrap;
						font-weight: normal;
						text-align: center;
						border: $borderStyle;
						padding: 6px;
					}
				}
			}
			tbody {
				tr{
					td {
						text-align: center;
						white-space: nowrap;
						padding: 6px;
						input,select {
							height: 26px;
							border: $borderStyle;
							border-radius: 3px;
						}
					}
					td:nth-child(2) {
						input {
							width: 130px;
						}
					}
					td:nth-child(4) {
						input {
							width: 120px;
						}
					}
				}
			}
		}
		.tixing {
			margin-top: 20px;
			color: #5a6879;
			select {
				margin-left: 10px;
				width: 130px;
				height: 26px;
				border: $borderStyle;
				border-radius: 3px;
				color: #121827;
			}
		}
	}
   
</style>
