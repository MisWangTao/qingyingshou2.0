<template>
	<div>
		<div class="centerModal tjcpModal">
			<div class="modalInner">
				<div class="header">
					<h3>添加产品信息</h3>
					<i class="icon iconfont">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="addProduct">
						<table>
							<thead>
								<tr>
									<th colspan="2">产品名称</th>
									<th>单价</th>
									<th>计价单位</th>
									<th>数量</th>
									<th><i class="icon iconfont jia">&#xe616;</i></th>

								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1</td>
									<td>
										<input type="text" value="设备销售合同KT-0918">
										<i class="icon iconfont">&#xe63a;</i>
									</td>
									<td><input type="text" value="￥10000.00"></td>
									<td>
										<select>
											<option>台</option>
											<option>个</option>
											<option>架</option>
										</select>
									</td>
									<td><input type="text" value="5"></td>
									<td>
										<i class="icon iconfont jia">&#xe616;</i>
										<i class="icon iconfont dele">&#xe610;</i>
									</td>
								</tr>
								<tr>
									<td>2</td>
									<td>
										<input type="text" value="设备销售合同KT-0918">
										<i class="icon iconfont">&#xe63a;</i>
									</td>
									<td><input type="text" value="￥10000.00"></td>
									<td>
										<select>
											<option>台</option>
											<option>个</option>
											<option>架</option>
										</select>
									</td>
									<td><input type="text" value="5"></td>
									<td>
										<i class="icon iconfont jia">&#xe616;</i>
										<i class="icon iconfont dele">&#xe610;</i>
									</td>
								</tr>
								<tr>
									<td>3</td>
									<td>
										<input type="text" value="设备销售合同KT-0918">
										<i class="icon iconfont">&#xe63a;</i>
									</td>
									<td><input type="text" value="￥10000.00"></td>
									<td>
										<select>
											<option>台</option>
											<option>个</option>
											<option>架</option>
										</select>
									</td>
									<td><input type="text" value="5"></td>
									<td>
										<i class="icon iconfont jia">&#xe616;</i>
										<i class="icon iconfont dele">&#xe610;</i>
									</td>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
				<div class="footer">
					<button class="btn cancle">取消</button>
					<button class="btn confirm">确定</button>
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
			}
		},

	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main.scss";
	.centerModal {
		.modalInner {
			margin: 130px auto 0;
			width: 680px;
		}
	}
	.addProduct {
		margin: 30px 0;
		padding: 0 20px;
		border-radius: 4px;
		min-height: 240px;
		overflow: hidden;
		table {
			width: 100%;
			border: $borderStyle;
			
			border-collapse:collapse;
			i {
				cursor: pointer;
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
							padding: 0 5px;
							height: 26px;
							border: $borderStyle;
							border-radius: 3px;
						}
					}
					td:nth-child(2) {
						position: relative;
						input {
							padding-right: 20px;
							width: 200px;
						}
						i {
							position: absolute;
							top: 11px;
							right: 20px;
							cursor: pointer;
						}
					}
					td:nth-child(3) {
						input {
							width: 110px;
						}
					}
					td:nth-child(4) {
						select {
							width: 60px;
						}
					}
					td:nth-child(5) {
						input {
							width: 60px;
						}
					}
				}
			}
		}
	}
   
</style>
