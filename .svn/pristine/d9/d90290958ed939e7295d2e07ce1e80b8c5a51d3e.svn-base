<template>
	<div>
		<div class="centerModal yichangModal">
			<div class="modalInner">
				<div class="header">
					<h3>异常处理</h3>
					<i class="icon iconfont">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="yichang">
						<div class="row">请选择异常处理操作</div>
						<div class="row">
							<div class="ipt">
								<input type="checkbox" name="" value="">
							</div>
							<div class="value">
								<p>已确认原核销记录正确，恢复原正常状态</p>
							</div>
						</div>
						<div class="row">
							<div class="ipt">
								<input type="checkbox" name="" value="">
							</div>
							<div class="value">
								<p>已确认原核销记录错误，删除原核销记录并重新指给业务员</p>
								<div class="toPerson">指给谁<p>
									<span>刘在石<i class="icon iconfont">×</i></span>
								</p></div>
							</div>
						</div>
						<div class="row">
							<div class="ipt">
								<input type="checkbox" name="" value="">
							</div>
							<div class="value">
								<p>已确认原核销记录错误，删除原核销记录并重新核销</p>
							</div>
						</div>
					</div>

				</div>
				<div class="footer">
					<button class="btn cancel">取消</button>
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
			margin: 180px auto 0;
			width: 520px;
			.body {
				.yichang{
					padding: 10px 20px 30px;
					.row {
						margin-top: 16px;
						padding: 0 20px;
						color: $huiColor;
						overflow: hidden;
						.ipt {
							width: 40px;
							float: left;
							input {
								margin-top: 3px;
								width: 16px;
								height: 16px;
							}
						}
						.value {
							width: 400px;
							float: left;
							color: $wordColor;
							.toPerson {
								p {
									display: inline-block;
									width: 260px;
									height: 26px;
									color: #121827;
									border: $borderStyle;
									border-radius: 3px;
									background: $baiColor;
									line-height: 26px;
									span {
										margin-left: 12px;
										margin-top: 4px;
										display: inline-block;
										font-size: 12px;
										height: 16px;
										line-height: 16px;
										padding: 1px 2px;
										background: #e7eef9;
									}
								}
							}
						}
					}
				}
			}
		}
	}

</style>
