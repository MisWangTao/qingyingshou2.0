<template>
	<div>
		<div class="fade bgsqModal">
			<div class="madol">
				<div class="top">
					<h4>变更申请</h4>
					<i @click="closeDetail" class="icon iconfont">&#xe60f;</i>
				</div>
				<div class="apply">
					<img v-show="changeData.change_info.change_status == '1'" class="zhang" :src="imghost+'weitongguo@2x.png'" alt="未通过">
					<img v-show="changeData.change_info.change_status == '2'" class="zhang" :src="imghost+'tongguo-@2x.png'" alt="通过">
					<div class="container">
						<div class="col-xs-12">
							<p>合同名称:</p>
							<p>{{changeData.contract_info.contract_name}}</p>
						</div>
						<div class="col-xs-12">
							<p>客户名称：</p>
							<p>{{changeData.contract_info.custom_name}}</p>
						</div>
						<div class="col-xs-6">
							<p>合同编号：</p>
							<p>{{changeData.contract_info.contract_number}}</p>
						</div>
						<div class="col-xs-6">
							<p>跟进人：</p>
							<p>{{changeData.contract_info.genjinren}}</p>
						</div>
						<div class="col-xs-6">
							<p>合同金额：</p>
							<p>{{changeData.contract_info.contract_money | numberFormat}}</p>
						</div>
						<div class="col-xs-6">
							<p>回款金额：</p>
							<p>{{changeData.contract_info.huikuan_money | numberFormat}}</p>
						</div>
						<div class="col-xs-12">
							<p>合同日期:</p>
							<p>{{changeData.contract_info.contract_date}}</p>
						</div>
						<div class="col-xs-12">
							<p>变更业务类型:</p>
							<p>{{changeData.change_info.change_type == 1 ? '变更合同金额': changeData.change_info.change_type == 2 ? '变更合同金额并退款' :'仅退款'}}</p>
						</div>
						<div class="col-xs-12">
							<p>变更原因说明:</p>
							<p>{{changeData.change_info.change_reason}}</p>
						</div>
						<div class="col-xs-12">
							<p>变更日期:</p>
							<p>{{changeData.change_info.change_date}}</p>
						</div>
						<div class="col-xs-12" v-show="changeData.contract_info.contract_type == 2 && changeData.change_info.change_type != 3">
							<p>到期日期：</p>
							<p class="bgJine">￥{{changeData.change_info.maturity_date}}</p>
						</div>
						<div class="col-xs-12" v-show="changeData.contract_info.contract_type != 2 && changeData.change_info.change_type != 3">
							<p>变更金额：</p>
							<p class="bgJine">￥{{changeData.change_info.change_money}}</p>
						</div>
						<div class="col-xs-12" v-show="changeData.contract_info.contract_type == 2 && changeData.change_info.change_type != 3">
							<p>变更后每期金额：</p>
							<p class="bgJine">￥{{changeData.change_info.each_money}}</p>
						</div>
						<div class="col-xs-12" v-show="changeData.change_info.change_type == '3'">
							<p>退款金额：</p>
							<p class="tkJine">￥{{changeData.change_info.refund_money}}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-1">产品信息：</div>
						<div class="col-11">
							<table>
								<thead>
									<tr>
										<th colspan="2">产品名称</th>
										<th>单价</th>
										<th>计价单位</th>
										<th>数量</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>1</td>
										<td>产品产品产品1</td>
										<td>230000.00</td>
										<td>台</td>
										<td>100</td>
									</tr>
									<tr>
										<td>2</td>
										<td>产品产品产品1</td>
										<td>230000.00</td>
										<td>台</td>
										<td>100</td>
									</tr>
									<tr>
										<td>3</td>
										<td>产品产品产品1</td>
										<td>230000.00</td>
										<td>台</td>
										<td>100</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row">
						<div class="col-1">回款计划：</div>
						<div class="col-11 hkjh">
							共<span>{{changeData.returnPlan.length}}</span>笔回款计划<span @click="changePlanDetail" class="span2">[点击查看]</span>
						</div>
					</div>
					<div class="row">
						<div class="col-1">备注：</div>
						<div class="col-11">备注信息</div>
					</div>
					<div class="row">
						<div class="col-1">附件：</div>
						<div class="col-11">
							<table v-show="changeData.files.length>0">
								<thead>
									<tr>
										<th>文件名称</th>
										<th>文件大小</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="item,key in changeData.files">
                                        <td>{{item.name}}</td>
                                        <td>{{item.size}}</td>
										<td>
											<i class="icon iconfont yulan">&#xe660;</i>
											<i class="icon iconfont xiazai">&#xe62a;</i>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!-- 未通过 -->
					<div class="state" v-show="changeData.change_info.change_status != '2'">
						<div class="title">当前状态：<span class="red">未通过</span></div>
						<div class="txt"><textarea v-model="message"></textarea></div>
						<div class="buttons" v-show="changeData.change_info.change_status == '0'">
							<button @click="showTrue = true" class="btn lvBtn">通过</button>
							<button @click="noTongguo" class="btn redBtn">不通过</button>
						</div>
					</div>
					<!-- 已通过 -->
					<div class="state" v-show="changeData.change_info.change_status == '2'">
						<div class="title">当前状态：<span class="lv">已通过</span></div>
						<div class="txt"><p>已确认信息无误，退款已处理!</p></div>
					</div>
					
				</div>
			</div>
		</div>
        <refundDescription :change_info="changeData.change_info" :message="message" :newsId="newsId"
                           :contract_info="changeData.contract_info" @closeTrue="closeShowtrue" v-if="showTrue"></refundDescription>
        <editPlan :allMoney="allMoney" @closeEdit="showPlanDetail = false" :returnPlan="changeData.returnPlan" v-if="showPlanDetail"></editPlan>
	</div>
</template>

<script>
	import {host, imghost} from '../../../../config/config.js'
    import refundDescription from '../../../refundDescription/refundDescription.vue'
    import editPlan from './editPlan/editPlan.vue'
	export default{
		data(){
			return {
				host,
				imghost,
                changeData:{
                    contract_info:{},
                    change_info:{},
                    files:[],
                    returnPlan:[],
                },
                showTrue : false,
                message : '',
                showPlanDetail : false,
                allMoney : 0,
			}
		},
        mounted(){
		    this.initData()
        },
        components:{
            refundDescription,
            editPlan
        },
        props:['id','newsId'],
        methods:{
            initData(){
                let id = this.id;
                this.$http('POST','/change/get_edit_details.php',{'change_id':id}).then(res=>{
                    this.changeData = res.data
                    if(res.data.contract_info.contract_type == '2'){
                        this.allMoney = res.data.change_info.each_money * res.data.returnPlan.length
                    }else{
                        this.allMoney = Number(res.data.change_info.change_money) + Number(res.data.contract_info.contract_money)
                    }
                }).catch(err=>{
                
                })
            },
            changePlanDetail(){
                this.showPlanDetail = true;
            },
            closeShowtrue(val){
                if(val){
                    this.$set(this.changeData.change_info, 'change_status', val)
                }
                this.showTrue = false
            },
            closeDetail(){
                this.$emit('closeDetail')
            },
            noTongguo(){
                let sendData = {}
                sendData.id = this.changeData.change_info.id;
                sendData.news_id = this.newsId;
                sendData.message = this.message;
                this.$http('POST','/change/finance_deal_change.php',sendData).then(res=>{
                    this.$set(this.changeData.change_info, 'change_status', 1)
                }).catch(err=>{
                
                })
            }
        }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../../assets/main";
	.fade {
		z-index: 19;
		.madol {
			width: 560px;
			.top {
				background: $danlanColor;
				border-bottom: $qianStyle;
				overflow: hidden;
				position: relative;
				h4 {
					text-align: center;
					font-size: 18px;
					line-height: 40px;
					font-weight: normal;
					color: #1f2a44;
				}
				i {
					position: absolute;
					font-size: 18px;
					top: 10px;
					right: 10px;
					cursor: pointer;
				}
			}
			.apply {
				padding: 10px 0 20px;
				height: 530px;
				overflow: auto;
				position: relative;
				.zhang {
					position: absolute;
					top: 0;
					right: 0;
					width: 120px;
				}
				.container {
					overflow: hidden;
					font-size: 14px;
					.col-xs-6,.col-xs-12{
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
							color: #1f2a44;
						}
					}
					.col-xs-12 {
						p:nth-child(2) {
							width: 380px;
						}
						p:nth-child(2).bgJine {
							color: $mainColor;
						}
						p:nth-child(2).tkJine {
							color: $redColor;
						}
					}
				}
				.row {
					margin-top: 10px;
					padding: 0 10px;
					overflow: hidden;
					line-height: 28px;
					.col-1 {
						float: left;
						width: 100px;
						padding-left: 10px;
						color: #5a6879;
					}
					.col-11 {
						float: left;
						width: 404px;
						color: #1f2a44;
						table {
							margin-bottom: 8px;
							width: 100%;
							font-size: 12px;
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
										i {
											cursor: pointer;
										}
										.yulan {
											font-size: 13px;
											color: $huiColor;
										}
										.xiazai {
											margin-left: 4px;
											font-size: 15px;
											color: $mainColor;
										}

									}
								}
								
							}

						}
					}
					.hkjh {
						span {
							margin: 0 4px;
						}
						.span2 {
							color: $mainColor;
							cursor: pointer;
						}
					}
				}
				.state {
					.title {
						background: $titleBg;
						padding: 0 20px;
						line-height: 34px;
						.red {
							color: $redColor;
						}
						.lv {
							color: $lvColor;
						}
					}
					.txt {
						padding: 0 20px;
						textarea {
							width: 100%;
							border: $iptBorder;
							height: 50px;
							border-radius: 3px;
						}
					}
					p {
						color: $huiColor;
						line-height: 30px;
					}
					.buttons {
						margin-top: 16px;
						text-align: center;
						.btn {
							color: $baiColor;
							border: 0;
							width: 80px;
							height: 32px;
							margin: 0 15px;
							border-radius: 3px;
						}
						.lvBtn {
							background: #09bb07;
						}
						.redBtn {
							background: #da433e;
						}
					}
				}
				
			}
		}
	}
 
</style>
