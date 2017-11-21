<template>
	<div>
		<div class="centerModal yiyiModal">
			<div class="modalInner">
				<div class="header">
					<h3>我有异议</h3>
					<i class="icon iconfont">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="objection">
						<div class="tishi">该回款信息已被他人认领，提出异议：</div>
						<div class="row">
							<div class="col-xs-3">补充说明</div>
							<div class="col-xs-9">
								<textarea></textarea>
							</div>
						</div>
						<div class="row">
	                        <div class="col-xs-3">发给谁</div>
	                        <div class="col-xs-9 person">
	                            <div class="img">
	                                <img :src="imghost+'logo_defaullt@2x.png'" alt="">
	                                <p>王二小</p>
	                            </div>
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
	@import "../../../assets/main.scss";
	.centerModal {
		.modalInner {
			margin: 180px auto 0;
			width: 480px;
			
			.body {
				min-height: 240px;
				.objection {
					.tishi {
						padding: 15px 54px;
						color: #000000;
					}
					.row {
						margin-bottom: 16px;
						padding: 0 20px;
						overflow: hidden;
						.col-xs-3 {
							padding: 0 20px 0 0;
							text-align: right;
							color: $huiColor;
							line-height: 32px;
						}
						.col-xs-9 {
							textarea {
								padding: 0 10px;
								width: 280px;
								height: 80px;
								color: #121827;
								border: $borderStyle;
								border-radius: 3px;
							}
							
						}
						.person {
						    .img {
                                width: 60px;
                                cursor: pointer;
                                text-align: center;
                                img {
                                    display: inline-block;
                                    width: 30px;
                                    height: 30px;
                                    border-radius: 50%;
                                }
                                p {
                                    line-height: 20px;
                                    color: #000;
                                }
                            }
                        }
					}
				}
			}
		}
	}

</style>
