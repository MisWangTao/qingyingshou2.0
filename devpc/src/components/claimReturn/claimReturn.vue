<template>
	<div>
		<div class="fade rlhkxxModal">
			<div class="madol">
				<div class="top">
					<h4>认领回款信息</h4>
					<i class="icon iconfont">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="infor">
						<div class="row">
							<div class="left">客户名称:</div>
							<div class="right">西安朋客信息科技有限公司</div>
						</div>
						<div class="row">
							<div class="left">回款方式:</div>
							<div class="right">银行转账</div>
						</div>
						<div class="row">
							<div class="left">账号:</div>
							<div class="right">5626556+6356+6</div>
						</div>

						<div class="row">
							<div class="left">金额:</div>
							<div class="right"><span>￥55566.00</span></div>
						</div>
						<div class="row">
							<div class="left">回款日期:</div>
							<div class="right">2017-08-13</div>
						</div>
						<div class="row">
							<div class="left">操作人:</div>
							<div class="right">张大大</div>
						</div>
						<div class="row">
							<div class="left">备注:</div>
							<div class="right">备注新信息</div>
						</div>
						<div class="row">
							<div class="left">附件:</div>
							<div class="right">
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
											<td>DDDFGFWASDFEWSDFff.jpg</td>
											<td>256kb</td>
											<td>
												<i class="icon iconfont yulan">&#xe660;</i>
												<i class="icon iconfont xiazai">&#xe62a;</i>
											</td>
										</tr>
										<tr>
											<td>说明.doc</td>
											<td>256kb</td>
											<td>
												<i class="icon iconfont yulan">&#xe660;</i>
												<i class="icon iconfont xiazai">&#xe62a;</i>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- 待认领 -->
					<div class="state">
						<div class="title">
							当前状态：<span class="dai">待认领</span>
						</div>
						<div class="txt">
							<textarea></textarea>
						</div>
						<div class="btns">
							<button class="btn cancel">取消</button>
							<button class="btn claim">我要认领</button>
						</div>
						<img :src="imghost+'others@2x.png'" alt="">
					</div>
					<div class="state">
						<div class="title">
							当前状态：<span class="yi">他人认领</span>
							<p>2017-08-17 12:23:56</p>
						</div>
						<div class="yiyi">
							<span>我有异议></span>
						</div>
					</div>
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
			}
		},
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main";
	.fade {
		.madol {
			width: 500px;
			.top {
				position: relative;
				h4 {
					text-align: center;
					font-size: 16px;
					line-height: 40px;
				}
				i {
					position: absolute;
					top: 13px;
					right: 10px;
					font-weight: 600;
					font-size: 16px;
				}
			}
			.body{
				.infor{
					padding: 10px 40px;
					.row {
						overflow: hidden;
						line-height: 28px;
						.left {
							width: 22%;
							float: left;
							color: $huiColor;
						}
						.right {
							width: 78%;
							float: left;
							color: $wordColor;
							table {
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
											padding: 0 6px;
										}
									}
								}
								tbody {
									tr{
										td {
											white-space: nowrap;
											text-align: center;
											border: $borderStyle;
											padding: 0 6px;
											font-size: 12px;
										}
										td:first-child {
											text-align: left;
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
												font-size: 14px;
												color: $mainColor;
											}

										}
									}

								}

							}
						}
					}
				}
				.state {
					img {
						position: fixed;
						top: 150px;
						right: 160px;
						width: 180px;
						z-index: 19;
					}
					.title {
						padding: 0 20px;
						background: $titleBg;
						line-height: 34px;
						.dai {
							color: $chengColor;
						}
						.yi {
							color: $lvColor;
						}
						p {
							display: inline-block;
							float: right;
							font-size: 12px;
							color: $huiColor;
						}
					}
					.txt {
						padding: 12px 20px;
						textarea {
							padding: 0 10px;
							width: 440px;
							height: 40px;
							border: $iptBorder;
							border-radius: 3px;
						}
					}
					.btns {
						text-align: center;
						.btn {
							margin: 0 16px;
							display: inline-block;
							padding: 4px 18px;
							border-radius: 3px;
						}
						.cancel {
							border: 1px solid #3891f9;
							background: #fff;
							color: #3891f9;
						}
						.claim {
							border: 1px solid #3891f9;
							background: #3891f9;
							color: #fff;
						}
					}
					.yiyi {
						padding: 0 20px;
						text-align: right;
						line-height: 28px;
						span {
							cursor: pointer;
						}
					}
					
				}
			}
		}
	}

</style>
