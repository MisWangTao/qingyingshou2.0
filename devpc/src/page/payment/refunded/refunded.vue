<template>
	<div>
		<div class="fade">
			<div class="madol">
				<div class="top">
					<h3>客户名称</h3>
					<div class="right">
						<div class="bradge"><i class="icon iconfont">&#xe61e;</i>删除</div>
						<div class="bradge"><i class="icon iconfont">&#xe60f;</i>关闭</div>
					</div>
				</div>
				<div class="middle">
					<div class="htbh">
						<span>客户编号</span>
						<span>5565585</span>
					</div>
					<div class="name">
						<span>合同名称</span>
						<span>就是建立都懒得看快递来了</span>
					</div>
					<div class="jine">
						<span>退款金额</span>
						<span>￥236600.00</span>
					</div>
				</div>
				<div class="main">
					<img class="yituikuan" :src="imghost+'/tuikuan@2x.png'" alt="">
					<div class="tabSelect">
						<div class="active">退款信息</div>	
					</div>
					<div class="paymentPlan">
						<div class="container">
							<div class="row">
								<div class="col-xs-6">
									<p>合同名称:</p>
									<p>水电费菲尔</p>
								</div>
								<div class="col-xs-6">
									<p>合同编号</p>
									<p>5625856</p>
								</div>
							</div>
							<div class="row">

								<div class="col-xs-6">
									<p>合同日期</p>
									<p>2017-08-17</p>
								</div>
								<div class="col-xs-6">
									<p>跟进人</p>
									<p>张晓涵</p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<p>合同金额</p>
									<p>6352.00</p>
								</div>
								<div class="col-xs-6">
									<p>应收余额</p>
									<p>956.00</p>
								</div>
							</div>
						</div>
						<div class="container">
							<div class="row">
								<div class="col-xs-6">
									<p>变更业务类型</p>
									<p>变更合同金额并退款</p>
								</div>
								<div class="col-xs-6">
									<p>变更日期</p>
									<p>2017-05-06</p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<p>变更原因说明</p>
									<p>原因</p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<p>退款金额</p>
									<p><span>￥1234.00</span></p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<p>结算方式</p>
									<p>招商银行</p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<p>单据编号</p>
									<p>1234</p>
								</div>
							</div>
							<div class="row">
								<div class="col-1">备注</div>
								<div class="col-11"></div>
							</div>
							<div class="row">
								<div class="col-1">附件</div>
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
											<tr>
												<td>asdfgfdf.jpg</td>
												<td>568kb</td>
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
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import {host, imghost} from '../../../config/config.js'
	export default{
		data(){
			return {
				host,
				imghost,
			}
		},
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../assets/main";
	.fade {
		.madol {
			width: 650px;
			.middle{
				.htbh {
					width: 160px;
				}
				.name {
					width: 240px;
				}
				.jine {
					width: 100px;
					span:nth-child(2) {
						color: $redColor;
					}
				}
			}
		}
	}
	
	.main {
		position: relative;
		.yituikuan {
			position: absolute;
			top: 70px;
			right: 100px;
			width: 180px;
		}

	}
	.xinzeng {
		border-top: 10px solid #eaeef5;
		background: #ffffff;
		color: $mainColor;
		text-align: center;
		line-height: 32px;
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
			
			.row {
				overflow: hidden;
				line-height: 28px;
				.col-xs-6 {
					p {
						float: left;
					}
					p:first-child {
						width: 100px;
						color: $huiColor;
					}
					p:nth-child(2) {
						width: 180px;
						color: $wordColor;
					}
				}
				.col-xs-12 {
					p {
						float: left;
					}
					p:first-child {
						width: 100px;
						color: $huiColor;
					}
					p:nth-child(2) {
						width: 450px;
						color: $wordColor;
						span {
							color: $redColor;
						}
					}
				}
				.col-1 {
					float: left;
					width: 100px;
					color: $huiColor;
				}
				.col-11 {
					float: left;
					width: 450px;
					color: $wordColor;
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
										i {
											font-size: 16px;
											cursor: pointer;
										}
										span {
											cursor: pointer;
											color: $mainColor;
										}
									}
								}
							}
						}
				}
			}
		}
		.container:last-child {
			border: 0;
		}
	}
</style>
