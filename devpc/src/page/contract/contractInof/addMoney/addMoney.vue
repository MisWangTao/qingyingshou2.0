<template>
	<div>
		<div class="centerModal">
			<div class="modalInner">
				<div class="header">
					<h3>添加合同款</h3>
					<i class="icon iconfont" @click="closeKuangjiaPlanComponents">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="newContract">
						<div class="row">
							<div class="col-xs-3"><span>*</span>合同金额</div>
							<div class="col-xs-9">
								<input type="text" v-model="hetongInfo.hetongMoney" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">计划回款时间</div>
							<div class="col-xs-9">
								<input type="date" v-model="hetongInfo.planDate"/>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">备注</div>
							<div class="col-xs-9">
								<textarea v-model="hetongInfo.remark"></textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">附件</div>
							<div class="col-xs-9 file" >
								<table v-show="this.filesMap.length>0">
									<thead>
										<tr>
											<th>文件名称</th>
											<th>文件大小</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="item,key in filesMap">
											<td>{{item.name}}</td>
											<td>{{item.size}}</td>
											<td>
												<i class="icon iconfont yulan">&#xe660;</i>
												<i class="icon iconfont xiazai">&#xe62a;</i>
												<i class="icon iconfont dele" @click="delImg(key)">&#xe612;</i>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="upload"><p>+点击添加附件</p>
								<input type="file" multiple="true" @change="upload"/></div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">到期提醒</div>
							<div class="col-xs-9">
								<select v-model="hetongInfo.advance_remind">
									<option value="7">提前7天</option>
									<option value="6">提前6天</option>
									<option value="5">提前5天</option>
									<option value="4">提前4天</option>
									<option value="3">提前3天</option>
									<option value="2">提前2天</option>
									<option value="1">提前1天</option>
									<option value="0">不提醒</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="footer">
					<button class="btn cancel">取消</button>
					<button class="btn confirm" @click="sendData">确定</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../../../config/config.js'
	import axios from 'axios'
	export default{
		data(){
			return {
				host,
				imghost,
				filesMap:[],
				hetongInfo:{
					files:[],
				},
				returnPlan:{},
			}
		},
		methods:{
			closeKuangjiaPlanComponents(){
				this.$emit('closeKuangjiaPlanComponents')
			},
			//选择图片
            upload(e){
                let files = e.target.files
                console.log(files) 
                for (let i = 0; i < files.length; i++) {
                    this.filesMap.push(files[i])
                    this.hetongInfo.files.push(files[i])
                }
            },
            delImg(key){
            	this.filesMap.splice(key, 1)
            },
			sendData(){
			let returnPlan = []

			this.returnPlan.plan_date = this.hetongInfo.planDate
			this.returnPlan.plan_money = this.hetongInfo.hetongMoney
			this.returnPlan.plan_type = 1
			this.returnPlan.plan_remark = this.hetongInfo.remark
			let advance_remind = this.hetongInfo.advance_remind
			let contract_id = this.id
		    let reminder = 0;
		    returnPlan.push(this.returnPlan)
            if(advance_remind!=0)
            {
            	reminder = 1 ;
            }
			if(this.returnPlan.plan_date<this.contractData)
			{
				alert('回款日期不能早于业务日期!');
				return
			}
			if(this.returnPlan.plan_date>this.maturityDate)
			{
				alert('回款日期不能晚于业务日期!');
				return
			}
			let newForm = new FormData()
            newForm.append('returnPlan', JSON.stringify(returnPlan))
            newForm.append('currentcy_id', 1)
            newForm.append('contract_id', contract_id)
            newForm.append('expiration_reminder', reminder)
            newForm.append('advance_remind', advance_remind)
			 if (this.hetongInfo.files && this.hetongInfo.files.length > 0) {
                for (let i = 0; i < this.hetongInfo.files.length; i++) {
                    newForm.append("image" + i, this.hetongInfo.files[i])
                }
            }

			this.$http('FORM', '/paymentPlan/add_plan.php', newForm).then(res => {

                    if (res.code == 0) {
                    	this.$emit('uploadContractMoney',this.returnPlan.plan_money)
                    }
                }).catch(err => {
                    this.I(err)
                })

		    },

		},
		props:['id','contractData','maturityDate'],
		mounted(){
			
		},

	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../../assets/main";
	.centerModal {
		.modalInner {
			margin: 150px auto 0;
			.body{
				.newContract {
					.row {
						.chanpin {
							.none {
								width: 94%;
								height: 50px;
								border: $borderStyle;
								border-radius: 3px;
								position: relative;
								div {
									padding-left: 10px;
									line-height: 24px;
									height: 24px;
								}
								.div1 {
									color: #cfd3d9;
									border-bottom: 1px dashed #bfcbd9;
								}
								.choose {
									position: absolute;
									top: 2px;
									right: 10px;
									font-size: 13px;
									color: $mainColor;
									cursor: pointer;
								}
							}
						}
                        #customParent{
                            position:relative;
                            .customModel{
                                z-index:20;
                                position:absolute;
                                left:15px;
                                top:31px;
                                border-radius:5px;
                                width:calc(94% - 15px);
                                height:150px;
                                border:1px solid #999;
                                background-color:#fff;
                                overflow: auto;
                                p{
                                    height:20px;
                                    padding-left:10px;
                                    
                                }
                            }
                        }
						.col-xs-9{
							position: relative;
							.hkzq {
								width: 94%;
								height: 30px;
								border: $borderStyle;
								border-radius: 3px;
								position: relative;
								background: #ffffff;
								select {
									display: block;
									float: left;
									width: 80px;
									border: 0;
									-webkit-appearance: textfield;

								}
								input {
									width: 89%;
								}
								span {
									line-height: 30px;
									display: block;
									float: left;
								}
							}
							table {
								tr {
									td {
										white-space: nowrap;
										line-height: 24px;
										span {
											display: block;
											float: left;
											margin-right: 3px;
										}
									}
									td:nth-child(1) input {
										width:90px;
									}
									td:nth-child(2) input {
										width: 60px;
									}
									td:nth-child(3) input {
										width: 30px;
									}
									td:nth-child(4) input {
										width: 30px;
									}
								}
								input {
									display: inline-block;
									height: 24px;
									padding: 0 3px;
								}
								i {
									font-size: 12px;
									cursor: pointer;
								}
							}
							.preset {
								position: absolute;
								top: 32px;
								left: 15px;
								width: 91%;
								background: #ffffff;
								z-index: 11;
								
								li {
									padding-left: 15px;
									list-style: none;
									line-height: 28px;
								}
								.active {
									background: #e7eef9;
								}
							}
							.genjinren {
								position: absolute;
								top: 32px;
								left: 16px;
								z-index: 13;
								height: 160px;
								overflow: auto;
								background: $baiColor;
								box-shadow: 0 0px 6px rgba(0,0,0,0.35);
								.level {
									width: 280px;
									height: 160px;
									float: left;
									border-right: 1px solid #d0d3dc;
									ul {
										padding-left: 24px;
										li {
											line-height: 28px;
											i {
												margin: 0 2px;
												cursor: pointer;
											}
											i:first-child{
												font-size: 16px;
												color: #d0d3dc;
											}
											i:nth-child(2) {
												font-size: 14px;
												color: $mainColor;
											}
										}
									}
								}
								.persons {
									float: left;
									width: 150px;
									height: 160px;
									ul {
										padding: 10px 0 20px 30px;
										li {
											line-height: 30px;
											cursor: pointer;
											i {
												color: $mainColor;
											}
										}
									}
								}
							}
						}
					}
					.atte {
						margin-bottom: -4px;
						padding-left: 430px;
						span {
							color: $mainColor;
						}
					}
				}
			}
		}
	}
 
</style>
