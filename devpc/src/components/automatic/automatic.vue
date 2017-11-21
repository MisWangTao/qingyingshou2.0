<template>
	<div>
		<div class="centerModal zdtjModal">
			<div class="modalInner">zdtjModal
				<div class="header">
					<h3>添加回款计划</h3>
					<i class="icon iconfont" @click="closeThisComponent">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="tishi">提示：根据客户账期自动生成回款计划<span @click="changeShowXiugai" class="lan">[点击修改]</span></div>
					<div class="xiugai" v-show="showXiugai">
						<div class="type">
							<div class="ipt"><span @click="changeIndex(1)" :class="{'active':index==1}"><i class="icon iconfont">&#xe614;</i></span></div>
							<div class="advant">
								<p>一次性收账 账期<input type="text" v-model="yicixing" value="30">天
									<br>
								<span>根据账期，自动生成收款计划</span></p>
							</div>
						</div>
						<div class="type">
							<div class="ipt"><span v-model="gundong" @click="changeIndex(2)" :class="{'active':index==2}"><i class="icon iconfont">&#xe614;</i></span></div>
							<div class="advant">
								<p>滚动收款<span>滚动生成收款计划</span></p>
								<p>
									<select v-model="first">
										<option value="1">周结</option>
										<option value="2">月结</option>
										<option value="3">季结</option>
										<option value="4">年结</option>
									</select>
									<select v-if="first==1" v-model="zhou">
										<option value="1">周一</option>
										<option value="2">周二</option>
										<option value="3">周三</option>
										<option value="4">周四</option>
										<option value="5">周五</option>
										<option value="6">周六</option>
										<option value="7">周日</option>
									</select>
									<select v-if="first==4" v-model="month">
										<option value="1">1月</option>
										<option value="2">2月</option>
										<option value="3">3月</option>
										<option value="4">4月</option>
										<option value="5">5月</option>
										<option value="6">6月</option>
										<option value="7">7月</option>
										<option value="8">8月</option>
										<option value="9">9月</option>
										<option value="10">10月</option>
										<option value="11">11月</option>
										<option value="12">12月</option>
									</select>
									<select v-if="first==3" v-model="months">
										<option value="1">第一个月</option>
										<option value="2">第二个月</option>
										<option value="3">第三个月</option>
									</select>
									<select v-if="first!=1" v-model="day">
											<option value="1">1日</option>
				                            <option value="2">2日</option>
				                            <option value="3">3日</option>
				                            <option value="4">4日</option>
				                            <option value="5">5日</option>
				                            <option value="6">6日</option>
				                            <option value="7">7日</option>
				                            <option value="8">8日</option>
				                            <option value="9">9日</option>
				                            <option value="10">10日</option>
				                            <option value="11">11日</option>
				                            <option value="12">12日</option>
				                            <option value="13">13日</option>
				                            <option value="14">14日</option>
				                            <option value="15">15日</option>
				                            <option value="16">16日</option>
				                            <option value="17">17日</option>
				                            <option value="18">18日</option>
				                            <option value="19">19日</option>
				                            <option value="20">20日</option>
				                            <option value="21">21日</option>
				                            <option value="22">22日</option>
				                            <option value="23">23日</option>
				                            <option value="24">24日</option>
				                            <option value="25">25日</option>
				                            <option value="26">26日</option>
				                            <option value="27">27日</option>
				                            <option value="28">28日</option>
				                            <option value="29">29日</option>
				                            <option value="30">30日</option>
				                            <option value="31">31日</option>
									</select>
								</p>
							</div>
						</div>
					</div>
					<div class="addPlan">
						<table>
							<thead>
								<tr>
									<th>计划日期</th>
									<th>计划类型</th>
									<th>计划金额</th>
									<th>备注</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td >{{changeDate}}</td>
									<td >常规</td>
									<td >{{this.sendHuikuanMoney}}</td>
									<td ><input type="text" placeholder="30字以内备注" v-model="returnPlan.remark"></td>
								</tr>
							</tbody>
						</table>
						<div class="shoudong"><span @click="qiehuanshoudong">手动添加回款计划</span></div>
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
					<span @click="closeAutoMacticAndNewContractComponents">暂不添加</span>
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
				returnPlan:{},
                showXiugai : false,
                index :1,
                yicixing:'7',
                gundong:0,
                first:'1',
                zhou:'1',
                month:'1',
                months:'1',
                day:'1',
			}
		},
		computed:{
			//根据选择收账方式来改变世界
			changeDate(){
                let conDate = this.sendHuikuanDate; //合同时间
                let arrDate = this.sendHuikuanMaDate; //合同时间
                
                
				let startTimestamp = Date.parse(this.sendHuikuanDate)
				let endTimestamp = Date.parse(this.sendHuikuanMaDate)
				let returnDate = ''
				//手动
				if(!this.gundong)
				{
					if(this.yicixing!=0)
					{
						if(endTimestamp)
						{
							if( (startTimestamp+this.yicixing*3600*24*1000)>endTimestamp)
							{
								returnDate = this.getNowDate(endTimestamp)
							}else{
								returnDate = this.getNowDate(startTimestamp+this.yicixing*3600*24*1000)
							}
						}else{
							returnDate = this.getNowDate(startTimestamp+this.yicixing*3600*24*1000)
						}
						
						return returnDate
					}else{
						returnDate = this.getNowDate(startTimestamp)

						return returnDate
					}
				}else{
				//滚动
					if(this.first==1)
					{
						//合同时间为星期几
						let xingqi = new Date(this.sendHuikuanDate).getDay()
						//选择的时间为星期几this.zhou
						let cha =  (this.zhou - xingqi) > 0 ? (this.zhou - xingqi) : (this.zhou - xingqi) + 7

						returnDate = this.getNowDate(startTimestamp+cha*3600*24*1000)

						if(endTimestamp)
						{
							if(returnDate > this.getNowDate(endTimestamp))
							{
								returnDate = this.getNowDate(endTimestamp)
							}else{
								returnDate = returnDate
							}
						}else{
							returnDate = returnDate
						}
						return returnDate
					}else if(this.first == 2){
                        let day = this.day < 10 ? '0'+this.day : this.day
                        if(Number(day) > Number(conDate.slice(-1))){
                            return conDate.slice(0,-2) + day
                        }else{
                            let m = conDate.slice(5,7)
                            let y = conDate.slice(0,4)
                            if((Number(m)+1)>12){
                                m = '0' + ((Number(m)+1)-12)
                                y = Number(y) + 1
                            }else{
                                m = Number(m)+1 <10 ? '0'+(Number(m)+1) : Number(m)+1
                            }
                            let newDate = y + '-' + m + '-' + day
                            return newDate
                        }
                    }else if(this.first == 3){
                        let mon = this.months
                        let day = this.day
                        let y = conDate.slice(0,4)
                        let m = conDate.slice(5,7)
                        if(m%3>Number(mon) || (m%3 == mon && Number(conDate.slice(-2))>=Number(day))){
                            let nowmo = (Math.floor(m/3+1)*3+Number(mon) ) <10 ? ('0' + (Math.floor(m/3+1)*3+Number(mon))) : (Math.floor(m/3+1)*3+ Number(mon ))
                            let dd = day < 10 ? '0' + day : day
                            let newDate = y + '-' + nowmo + '-' + dd
                            return newDate
                        }else{
                            let nowmo = (Math.floor(m/3)*3+Number(mon) ) <10 ? ('0' + (Math.floor(m/3)*3+Number(mon))) : (Math.floor(m/3)*3+ Number(mon ))
                            let dd = day < 10 ? '0' + day : day
                            let newDate = y + '-' + nowmo + '-' + dd
                            return newDate
                        }
                    }else if(this.first == 4){
                        let mon = this.month < 10 ? '0' + this.month : this.month
                        let day = this.day < 10 ? '0' + this.day : this.day
                        let y = conDate.slice(0,4)
                        let m = conDate.slice(5,7)
                        let huiDate = y + '-' + mon + '-' +day
                        this.I(huiDate)
                        if(huiDate > conDate){
                            return huiDate
                        }else{
                            return Number(y)+1 + '-' + mon + '-' + day
                        }
                    }
					
				}
				
			}
		},
		props:['sendHuikuanDate','sendHuikuanMoney','sendHuikuanMoneyed','sendHuikuanMaDate','sendContractId'],
		methods:{
			//关闭自动回款计划
			closeThisComponent(){

				this.$emit('closeAutoMatic')
			},
            changeShowXiugai(){
			    this.showXiugai = !this.showXiugai
            },
			qiehuanshoudong(){

				this.$emit('qiehuanshoudonghuikuan')
			},
            changeIndex(val){
			    this.index = val
			    if(val==1)
			    {
			    	this.gundong = false
			    }else{
			    	this.gundong = true
			    }
            },
			sendData(){
				
				this.returnPlan.plan_date = this.changeDate ? this.changeDate : ''
				this.returnPlan.plan_money = this.sendHuikuanMoney ? this.sendHuikuanMoney : ''
				this.returnPlan.plan_type = 1
				this.returnPlan.plan_remark = this.returnPlan.remark ? this.returnPlan.remark : ''
				let advance_remind = this.$refs.tixing.value ? this.$refs.tixing.value : ''
				let returnPlan = []
				returnPlan.push(this.returnPlan)
				if(this.sendContractId==''){
					alert('合同Id不能为空!')
				}
				if(this.returnPlan.plan_date=='')
				{
					alert('回款计划时间不能为空!')
					return
				}
				if(this.returnPlan.plan_money=='')
				{
					alert('回款计划金额不能为空!')
					return
				}

				let newForm = new FormData()
				newForm.append('contract_id', this.sendContractId)
				newForm.append('returnPlan',JSON.stringify(returnPlan))
				newForm.append('advance_remind',advance_remind)

				this.$http("FORM",'/paymentPlan/add_plan.php',newForm).then(res=>{

					if(res.code==0)
					{
						this.$emit('closeAutoMacticAndNewContractComponents')
					}

				}).catch(err => {
                
                })
			},
			//关闭新建合同和自动回款计划组件
			closeAutoMacticAndNewContractComponents(){
				this.$emit('closeAutoMacticAndNewContractComponents')
			},
			 getNowDate(date){
                let newDate = date ? new Date(date) : new Date()
                let year = newDate.getFullYear()
                let month = newDate.getMonth()+1
                let day = newDate.getDate()
                let m = month < 10 ? '0' + month : month
                let d = day < 10 ? '0' + day : day
                return year + '-' + m + '-' + d
            },

		}


	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main.scss";
	.centerModal{
		.modalInner {
			width: 630px;
		}
	}
	.tishi {
		padding: 15px 20px 10px;
		color: #5a6879;
		.lan {
			color: $mainColor;
		}
	}
	.xiugai {
		padding: 0 20px 20px;
		.type {
			margin: 10px 0;
			padding: 0 40px;
			overflow: hidden;
			.ipt {
				float: left;
				input {
					margin-top: 16px;
					width: 16px;
					height: 16px;
				}
                span{
                    display:inline-block;
                    border:1px solid #999;
                    width:16px;
                    height:16px;
                    margin-top:16px;
                    border-radius:50%;
                    line-height:16px;
                    color:#fff;
                }
                .active{
                    background: #3891f9;
                    border: 1px solid #3891f9;
                }
			}
			.advant {
				float: left;
				font-size: 15px;
				margin-left: 30px;
				p {
					line-height: 24px;
					color: #121827;
					span {
						font-size: 12px;
						color: #999999;
					}
					input {
						margin: 0 5px;
						width: 60px;
						height: 20px;
						border: $borderStyle;
						border-radius: 3px;
					}
					select {
						margin-right: 5px;
						height: 20px;
						border: $borderStyle;
						border-radius: 3px;
					}
				}
			}

		}
	}
	.addPlan {
		margin-bottom: 30px;
		padding: 0 20px;
		border-radius: 4px;
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
						padding: 4px 6px;
						border: $borderStyle;
						input{
							height: 26px;
							border: 0;
						}
					}
					td:nth-child(4) {
						input {
							width: 130px;
							background: #f8fbfe;
						}
					}
				}
			}
		}
		.shoudong {
			text-align: right;
			color: $mainColor;
			margin-top: 10px;
			span {
				cursor: pointer;
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
