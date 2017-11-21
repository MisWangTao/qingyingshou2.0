<template>
	<div>
		<div class="fade">
			<div class="madol">
				<div class="top">
					<h3>{{data.custom_name}}</h3>
					<div class="right">
						<div class="bradge" v-if="data.states==1" @click="showappoint"><i class="icon iconfont">&#xe61b;</i>指定</div>
						<div class="bradge" v-if="data.states==1" @click="showwriteOff"><i class="icon iconfont">&#xe6b7;</i>核销</div>
						<div class="bradge" v-if="data.states==1"><i class="icon iconfont">&#xe61e;</i>删除</div>
						<div @click="closeDetail" class="bradge"><i class="icon iconfont">&#xe60f;</i>关闭</div>
					</div>
				</div>
				<div class="middle">
					<div class="htbh">
						<span>客户编号</span>
						<span>{{data.custom_number}}</span>
					</div>
					<div class="name">
						<span>合同数量</span>
						<span>{{data.count}}</span>
					</div>
					<div class="state">
						<span>合同总金额</span>
						<span>{{data.total_money}}</span>
					</div>
					<div class="date">
						<span>回款金额</span>
						<span>{{data.shoukuan}}</span>
					</div>
					<div class="gjr">
						<span>本次回款</span>
						<span>{{data.arrival_amount}}</span>
					</div>
				</div>
				<div class="main">
					<div class="tabSelect">
						<div :class="{active:showindex==1}" @click="changeshowindex(1)">到账信息</div>
						<div :class="{active:showindex==2}" @click="changeshowindex(2)" v-if="data.states!=1">核销信息</div>
					</div>
					<div class="tabCont">
						<div class="xinxi" v-show="showindex==1">
							<div class="container">
								<div class="row">
									<div class="col-xs-6">
										<p>回款方式:</p>
										<p>{{data.payment_method | echopaymethod}}</p>
									</div>
									<div class="col-xs-6">
										<p>单据编号：</p>
										<p>1234</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<p>回款金额：</p>
										<p><span>{{data.arrival_amount}}</span></p>
									</div>
									<div class="col-xs-6">
										<p>回款日期：</p>
										<p>{{data.arrival_date}}</p>
									</div>
								</div>
								<div class="row">
									<div class="col-1">备注：</div>
									<div class="col-11">{{data.remarks}}</div>
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
												<tr v-for="item,key in data.files">
													<td>{{item.old_name+item.ext}}</td>
													<td>{{item.filesize}}kb</td>
													<td>
														<span>预览</span> |
														<span>下载</span>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="paymentPlan" v-show="showindex==2">
							<div class="title">
								<div class="count">
									合同数:<span>{{data.hexiao.length}}</span>
								</div>
								<div class="jine">
									
									核销金额:<span>￥{{data.zhxje}}</span>
								</div>
							</div>
							<div class="container" v-for="item,key in data.hexiao">
								<div class="col-xs-6">
									<p>合同名称:</p>
									<p>{{item.contract_name}}</p>
								</div>
								<div class="col-xs-6">
									<p>合同编号：</p>
									<p>{{item.contract_number}}</p>
								</div>

								<div class="col-xs-6">
									<p>合同日期：</p>
									<p>{{item.contract_date}}</p>
								</div>
								<div class="col-xs-6">
									<p>负责人：</p>
									<p>{{item.realname}}</p>
								</div>
								<div class="col-xs-6">
									<p>合同金额：</p>
									<p>{{item.contract_money}}</p>
								</div>
								<div class="col-xs-6">
									<p>应收余额：</p>
									<p>{{item.contract_money-item.zdz | numberFormat}}</p>
								</div>
								<div class="col-xs-6">
									<p>本次核销金额：</p>
									<p>{{item.returning_money}}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<appoint v-if="isshowappoint" @closeappoint="closeappoint" :data="data" :id="id"></appoint>
		<writeOff v-if="isshowwriteOff && id" :id="id" @hiddenoptionContract="hiddenoptionContract"></writeOff>
	</div>
</template>

<script>
	import {host, imghost} from '../../../config/config.js'
	import appoint from './appoint/appoint.vue'
	import writeOff from '../../../components/writeOff/writeOff.vue'
	export default{
		data(){
			return {
				host,
				imghost,
                showEdit :false,
                data:{hexiao:[]},
                showindex:1,
                isshowappoint:false,
                isshowwriteOff:false,
			}
		},
		props:{id:{type:String}},
        components:{
            appoint,
            writeOff
        },
        mounted(){
        	this.initData()
        },
        methods:{
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

                this.$http('POST', '/receivables/get_receivable_details.php',{id:this.id}).then(res=>{
                    this.data = res.data
                }).catch(err=>{
                
                })
            },
            changeshowindex(index){
            	this.showindex = index
            },
            showappoint(){
            	this.isshowappoint = true
            },
            closeappoint(){
            	this.isshowappoint = false
            },
            showwriteOff(){
            	this.isshowwriteOff = true
            },
            hiddenoptionContract(){
            	this.isshowwriteOff   = false
            }
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
				padding: 18px 10px;
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
						width: 240px;
						color: #1f2a44;
					}
				}
				.row {
					// margin-top: 10px;
					overflow: hidden;
					line-height: 28px;
				}
				.col-1 {
					float: left;
					width: 100px;
					padding-left: 10px;
					color: #5a6879;
				}
				.col-11 {
					float: left;
					width: 560px;
					color: #1f2a44;
					table {
						margin-bottom: 8px;
						width: 100%;
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
				.count {
					float: left;
				}
				.jine {
					margin-left: 30px;
					float: left;
				}
			}
			.container {
				margin: 0 20px;
				padding: 8px 0;
				overflow: hidden;
				border-bottom: 1px dashed #bfcbd9;
				.col-xs-6 {

					line-height: 26px;
					p {
						float: left;
					}
					p:first-child {
						width: 100px;
						color: $huiColor;
					}
					p:nth-child(2) {
						width: 230px;
						color: $wordColor;
					}
				}
			}
			.container:last-child {
				border: 0;
			}
		}
	}
 
</style>
