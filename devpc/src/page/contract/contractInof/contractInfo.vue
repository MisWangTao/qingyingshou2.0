<template>
	<div>
		<div class="fade">
			<div class="madol">
				<div class="top">
					<h3>设备销售合同开垦的肯定看</h3>
					<div class="right">
						<div @click="changeShowDetail" class="bradge"><i class="icon iconfont">&#xe68c;</i>编辑</div>
						<div @click="showBiangengs" class="bradge"><i class="icon iconfont">&#xe63d;</i>变更</div>
						<div class="bradge"><i class="icon iconfont">&#xe63d;</i>打印</div>
						<div @click="delContract" class="bradge"><i class="icon iconfont">&#xe61e;</i>删除</div>
						<div @click="closeDetail" class="bradge"><i class="icon iconfont">&#xe60f;</i>关闭</div>
					</div>
				</div>
				<div class="middle">
					<div class="htbh">
						<span>合同编号</span>
						<span>{{detailData.contract.contract_number}}</span>
					</div>
					<div class="name">
						<span>合同名称</span>
						<span>{{detailData.contract.contract_name}}</span>
					</div>
					<div class="state">
						<span>合同状态</span>
						<span>正常</span>
					</div>
					<div class="date">
						<span>合同日期</span>
						<span>{{detailData.contract.contract_date}}</span>
					</div>
					<div class="gjr">
						<span>跟进人</span>
						<span>{{detailData.contract.realname}}</span>
					</div>
				</div>
				<div class="xinzeng" v-show="detailData.contract.contract_type==3"><span @click="openKuangjiaPlanComponent" >+新增合同款项</span></div>
				<div class="main">
					<div class="tabSelect">
						<div :class="{active:showindex==1}" @click="changeshowindex(1)">合同信息</div>
						<div :class="{active:showindex==2}" @click="changeshowindex(2)">回款计划</div>
						<div :class="{active:showindex==3}" @click="changeshowindex(3)">合同动态</div>
					</div>
					<div class="tabCont">
						<div class="xinxi" v-show="showindex==1">
							<div class="title">基本信息</div>
							<div class="container">
								<div class="col-xs-6">
									<p>合同名称:</p>
									<p>{{detailData.contract.contract_name}}</p>
								</div>
								<div class="col-xs-6">
									<p>合同编号：</p>
									<p>{{detailData.contract.contract_number}}</p>
								</div>
								<div class="col-xs-6">
									<p>客户名称：</p>
									<p>{{detailData.contract.custom_name}}</p>
								</div>
								<div class="col-xs-6">
									<p>跟进人：</p>
									<p>{{detailData.contract.realname}}</p>
								</div>
								<div class="col-xs-6">
									<p>合同日期：</p>
									<p>{{detailData.contract.contract_date}}</p>
								</div>
								<div class="col-xs-6">
									<p>到期日期：</p>
									<p>{{detailData.contract.maturity_date}}</p>
								</div>
								<div class="col-xs-6">
									<p>联系人：</p>
									<p>张小萌</p>
								</div>

								<div class="col-xs-6">
									<p>联系电话：</p>
									<p>156526563</p>
								</div>
								<div class="col-xs-6">
									<p>回款周期：</p>
									<p>月结</p>
								</div>
								<div class="col-xs-6">
									<p>首次回款日期：</p>
									<p>{{detailData.contract.first_date_payment}}</p>
								</div>
								<div class="col-xs-6">
									<p>每期金额：</p>
									<p>￥{{detailData.contract.each_money}}</p>
								</div>
								<div class="col-xs-6">
									<p>周期提醒：</p>
									<p>提前{{detailData.contract.advance_remind}}天</p>
								</div>

								<div class="col-xs-6">
									<p>合同金额：</p>
									<p><span>￥{{detailData.contract.contract_money | numberFormat}}</span></p>
								</div>
								<div class="col-xs-6">
									<p>应收余额：</p>
									<p>￥{{detailData.contract.ysye}}</p>
								</div>
								<div class="col-xs-6">
									<p>回款金额：</p>
									<p>￥{{detailData.contract.arrival_amount}}</p>
								</div>
								<div class="col-xs-6">
									<p>开票金额：</p>
									<p>￥56623.00</p>
								</div>

							</div>
							<div class="title">其他信息</div>
							<div class="container">
								<div class="row">
									<div class="col-1">备注：</div>
									<div class="col-11">{{detailData.contract.remark}}</div>
								</div>
								<div class="row">
									<div class="col-1">附件：</div>
									<div class="col-11">
										<table>
											<thead>
												<tr>
													<th>文件名称</th>
													<th>文件大小</th>
													<th>操作</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="item,key in detailData.files">
													<td>{{item.name+item.ext}}</td>
													<td>569kb</td>
													<td>
														<span>预览</span> |
														<span>下载</span>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="row">
									<div class="col-1">产品信息：</div>
									<div class="col-11">
										<table>
											<thead>
												<tr>
													<th>产品名称</th>
													<th>单价</th>
													<th>计价单位</th>
													<th>数量</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>产品产品产品1</td>
													<td>230000.00</td>
													<td>台</td>
													<td>100</td>
												</tr>
												<tr>
													<td colspan="4">
														暂无产品信息
													</td>
												</tr>
											</tbody>
										</table>
										<div class="count">
											合计：0.00元
											共： 0个
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="paymentPlan" v-show="showindex==2">
							<div v-for="item,key in detailData.plan">
								<div class="title">
									<h4>第{{key+1}}期</h4>
									<span v-show="detailData.contract.contract_type == 1">
										<i @click="showEditPlans(item,key+1)" class="icon iconfont">&#xe608;</i>
										<i @click="del_plan(item.id)" class="icon iconfont">&#xe61e;</i>
									</span>
								</div>
								<div class="planLists" >
									<div class="lists">
										<p class="p1 jihua">计划</p>
										<p class="date"><span>{{item.plan_date}}</span></p>
										<p class="jhhk">计划回款：<span>{{item.plan_money}}</span></p>
										<p class="type">类型：<span>常规</span></p>
										<p class="beizhu">备注：<span>{{item.plan_remark}}</span></p>
									</div>
									<div class="lists" v-for="i,k in item.plan_detail">
										<p class="p1 shiji">实际</p>
										<p class="date"><span>{{i.returning_time}}</span></p>
										<p class="jhhk">实际回款：<span>{{i.returning_money}}</span></p>
									</div>
								</div>
								
							</div>
							<div class="addBtn" v-show="detailData.contract.contract_type == 1">
								<button @click="showAddplans">+添加回款计划</button>
							</div>
						</div>
						<div class="timeAxis" v-show="showindex==3">
							<div class="line"></div>
							<div class="step active" v-for="item,key in detailData.dongtai">
								<div class="datetime">
									<span class="date">{{item.time1}}</span>
									<span>{{item.time2}}</span>
								</div>
								<div class="duigou">
									<i class="icon iconfont">&#xe614;</i>
								</div>
								<div class="details">
									王小明在合同<span>白桦林居就是看看斯帝罗兰</span>中添加了一笔回款，金额<span>200</span>元
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <editContract :id="id" @closeAll="closeAllModel" @closeEdit="closeModel" v-if="showEdit"></editContract>
        <editPaymentPlan :maxMoney="maxMoney" :id="id" @closePlan="closePlans" @closeEditPlan="hideEditPlan" :planData="JSON.stringify(planData)" v-if="showEditPlan"></editPaymentPlan>
        <biangeng :id="id" :detailData="detailData" @closeBiangeng="closeShowbiangeng" v-if="showBiangeng"></biangeng>
        <addMoney :id="id" :contractData="detailData.contract.contract_date" :maturityDate="detailData.contract.maturity_date" @uploadContractMoney="uploadContractMoney" v-if="showAddKuangjiaComponents" @closeKuangjiaPlanComponents="hiddenKuangjiaPlanComponent"></addMoney>
        <addPlan :id="id" @closePlan="showAddplan=false" v-if="showAddplan"></addPlan>
	</div>
</template>

<script>
	import {host, imghost} from '../../../config/config.js'
    import editContract from './editContract/editContract.vue'
    import biangeng from './biangeng/biangeng.vue'
    import addMoney from './addMoney/addMoney.vue'
    import addPlan from './addPlan/addPlan.vue'
    import editPaymentPlan from '../../../components/editPaymentPlan/editPaymentPlan.vue'
	export default{
		data(){
			return {
				host,
				imghost,
                showEdit :false,
                detailData:{contract:{},dongtai:[],files:[],plan:[]},
                showindex:1,
                showBiangeng : false,
                showAddKuangjiaComponents:false,
                showEditPlan:false,
                planData: {},
                showAddplan : false,
                maxMoney : 0,
			}
		},
		props:{id:{type:String}},
        components:{
            editContract,
            biangeng,
            addMoney,
            editPaymentPlan,
            addPlan
        },
        mounted(){
            this.initData()
        	console.log(this.detailData)
        },
        methods:{
            showBiangengs(){
                this.showBiangeng = true
            },
            showAddplans(){
                this.showAddplan = true;
            },
            showEditPlans(item,key){
                this.maxMoney = Number(this.detailData.contract.contract_money)
                for(let i=0; i<this.detailData.plan.length; i++){
                    if(i != key-1){
                        this.maxMoney = this.maxMoney - Number(this.detailData.plan[i].plan_money)
                    }
                }
                this.planData = item
                this.planData.index = key
                this.showEditPlan = true
            },
            closePlans(val){
                this.$set(this.detailData,'plan',val)
                this.showEditPlan = false
            },
            del_plan(planId){
                let plan_id = planId;
                let contract_id = this.id
                this.$http('POST','/paymentPlan/del_contract_plan.php',{'plan_id':plan_id,'contract_id':contract_id}).then(res=>{
                
                }).catch(err=>{
                
                })
            },
            hideEditPlan(){
                this.showEditPlan = false
            },
            closeShowbiangeng(){
                this.showBiangeng = false
            },
            changeShowDetail(){
                this.showEdit = true
            },
            closeModel(){
                this.showEdit = false
            },
            closeAllModel(val){
                this.showEdit = false
                this.$emit('closeDetail',val)
            },
            closeDetail(){
                this.$emit('closeDetail')
            },
            initData(){
                this.$http('POST','/contract/get_contract_info.php',{'id':this.id}).then(res=>{
                    this.detailData = res.data
                }).catch(err=>{

                })
            },
            delContract(){
                let arr =[];
                arr.push(this.id);
                this.$http('POST','/contract/del_contract.php',{contract_id:JSON.stringify(arr)}).then(res=>{

                    if(res.code==0){
                        this.$emit('closeDetail')
                    }else{
                        alert(res.msg)
                    }

                }).catch(err=>{

                })
            },
            changeshowindex(index){
            	this.showindex = index
            },
            //添加框架合同款
            openKuangjiaPlanComponent(){
            	this.showAddKuangjiaComponents = true

            },
            hiddenKuangjiaPlanComponent(){
            	this.showAddKuangjiaComponents = false
            },
            uploadContractMoney(val){
            	this.showAddKuangjiaComponents = false
            	this.detailData.contract.contract_money=Number(this.detailData.contract.contract_money)+Number(val)
            }
        },
        watch:{
        
        }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../assets/main";
	.middle{
		.htbh {
			width: 120px;
		}
		.name {
			width: 240px;
		}
		.state {
			width: 90px;
		}
		.date {
			width: 110px;
		}
	}
	.xinzeng {
		border-top: 10px solid #eaeef5;
		background: #ffffff;
		color: $mainColor;
		text-align: center;
		line-height: 32px;
	}
	.tabCont {
		.xinxi {
			.title {
				line-height: 30px;
				padding-left: 20px;
				height: 30px;
				background: #f5f9ff;
				color: #1f2a44;
			}
			.container {
				overflow: hidden;
				font-size: 14px;
				.col-xs-6 {
					float: left;
					padding: 0 10px;
					line-height: 28px;
					p {
						display: block;
						float: left;
						span {
							color: $mainColor;
						}
					}
					p:nth-child(1) {
						width: 100px;
						color: #5a6879;
					}
					p:nth-child(2) {
						width: 230px;
						color: #1f2a44;
					}
				}
				.row {
					margin-top: 10px;
					overflow: hidden;
					line-height: 28px;
				}
				.col-1 {
					float: left;
					width: 13%;
					padding-left: 10px;
					color: #5a6879;
				}
				.col-11 {
					float: left;
					width: 85%;
					color: #1f2a44;
					table {
						margin-bottom: 8px;
						width: 85%;
						border: $borderStyle;
						border-collapse:collapse;
						thead {
							background: #eef1f6;
							tr {
								th{
									white-space: nowrap;
									font-weight: normal;
									text-align: center;
									border: $borderStyle;
									padding: 2px 6px;
								}
							}
						}
						tbody {
							tr{
								td {
									text-align: center;
									border: $borderStyle;
									padding: 2px 12px;
								}
								td:last-child {

									span {
										color: $mainColor;
										cursor: pointer;
									}

								}
							}

						}

					}
					.count {
						z-index: 2;
						margin-top: -10px;
						padding-left: 2%;
						background: #fff;
						width: 83%;
						border: 1px dashed #ccc;
					}
				}
			}
		}
		.paymentPlan {
			.title {
				line-height: 30px;
				padding-left: 20px;
				height: 30px;
				background: #f5f9ff;

				h4 {
					float: left;
					color: #1f2a44;
					letter-spacing: 2px;
				}
				span {
					display: block;
					float: right;
					padding-right: 40px;
					i {
						margin-left: 10px;
						cursor: pointer;
						font-weight: bold;
						font-size: 15px;
						color: #5a6879;
					}
					i:first-child:hover{
						color: $mainColor;
					}
					i:nth-child(2):hover{
						color: #ff1b1b;
					}
				}
			}
			.planLists {
				.lists {
					position: relative;
					padding: 10px 20px;
					overflow: hidden;
					p {
						float: left;
						color: #666666;
						span {
							color: #000000;
						}
					}
					.p1 {
						position: absolute;
						left: 20px;
						top: 10px;
						width: 50px;
						height: 20px;
						text-align: center;
						color: #fff;
					}
					.date {
						margin-left: 70px;
					}
					.jhhk,.type,.beizhu {
						margin-left: 22px;
					}
					.beizhu {
						width: 240px;
					}
					.jihua {
						background: #fd8a57;
					}
					.shiji {
						background: #60a5f6;
					}
				}
			}
			.addBtn {
				text-align: center;
				margin-top: 16px;
				button {
					width: 130px;
					height: 30px;
					color: $mainColor;
					border: 1px solid $mainColor;
					background: #fff;
					border-radius: 3px;
				}
			}
		}
		.timeAxis {
			padding: 20px;
			position: relative;
			.line {
				position: absolute;
				top: 30px;
				left: 130px;
				width: 2px;
				background: #f0f4f9;
				height: 50%;
				z-index: 2;
			}
			.step {
				margin-bottom: 20px;
				overflow: hidden;
				.datetime {
					text-align: right;
					width: 80px;
					float: left;
					line-height: 24px;
					span {
						display: block;
						color: #1f2a44;
					}
				}
				.duigou {
					position: relative;
					margin: 10px 16px 0;
					float: left;
					width: 30px;
					height: 30px;
					background: #f0f4f9;
					border-radius: 50%;
					text-align: center;
					line-height: 30px;
					z-index: 4;
					i {
						font-size: 24px;
						color: #fff;
						font-weight: bold;
					}
				}
				.details {
					color: #1f2a44;
					margin-top: 16px;
					span {
						margin: 0 3px;
						color: $mainColor;
					}
				}
			}
			.active {
				.datetime{
					.date {
						color: $mainColor;
					}
				}
				.duigou {
					background: $lvColor;
				}
			}
		}
	}

</style>
