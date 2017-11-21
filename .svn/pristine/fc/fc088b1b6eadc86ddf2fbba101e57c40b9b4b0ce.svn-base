<template>
	<div>
		<div class="fade rlhkxxModal">
			<div class="madol">
				<div class="top">
					<h4>预计回款信息</h4>
					<i class="icon iconfont" @click="closeyujiReturnInfo">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="infor">
						<div class="row">
							<div class="left">客户名称:</div>
							<div class="right">{{data.custom_name}}</div>
						</div>
						<div class="row">
							<div class="left">预计回款金额:</div>
							<div class="right"><span>￥{{data.arrival_amount}}</span></div>
						</div>
						<div class="row">
							<div class="left">预计回款日期:</div>
							<div class="right">{{data.arrival_date}}</div>
						</div>
						<div class="row">
							<div class="left">跟进人:</div>
							<div class="right">{{data.realname}}</div>
						</div>
						<div class="row">
							<div class="left">合同信息:</div>
							<div class="right htlists">
								共核销{{data.contract.length}}个合同

								<div class="container" v-for="item,key in data.contract">
									<div class="row">
										<div class="col-xs-4">合同名称：</div>
										<div class="col-xs-8">{{item.contract_name}}</div>
									</div>
									<div class="row">
										<div class="col-xs-4">合同日期：</div>
										<div class="col-xs-8">{{item.contract_date}}</div>
									</div>
									<div class="row">
										<div class="col-xs-4">合同金额：</div>
										<div class="col-xs-8">￥{{item.contract_money}}</div>
									</div>
									<div class="row">
										<div class="col-xs-4">应收余额：</div>
										<div class="col-xs-8">￥</div>
									</div>
									<div class="row">
										<div class="col-xs-4">本次核销金额：</div>
										<div class="col-xs-8">￥{{item.returning_money}}</div>
									</div>
								</div>

							</div>
						</div>
					</div>
					<!-- 未到账 -->
					<div class="state">
						<div class="title">
							当前状态：<span class="dai">未到账</span>
						</div>
						<div class="txt">
							<textarea></textarea>
						</div>
						<div class="btns">
							<button class="btn cancel" @click="weidaozhang">暂未到账</button>
							<button class="btn claim" @click="showpaymentInfor">确认到账</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<paymentInfor :newsId="this.newsId" :id="this.id" v-show="ispaymentInfor" @closepaymentInfor="closepaymentInfor"></paymentInfor>
	</div>
</template>

<script>
	import {host, imghost} from '../../../../config/config.js'
	import paymentInfor from './paymentInfor/paymentInfor.vue'
	export default{
		data(){
			return {
				host,
				imghost,
				ispaymentInfor:false,
				data:{contract:[]}
			}
		},
		components:{
			paymentInfor
		},
		props:['id','newsId'],
		mounted(){
			this.iniData()
		},
		methods:{
			iniData(){
				this.$http('GET','/salesmanreceivables/get_fore_detail.php?id='+this.newsId).then( res => {
					if(res.code==0){
						this.data = res.data
					}
				})
			},
			closeyujiReturnInfo(){
				this.$emit('closeDetail')
			},
			showpaymentInfor(){
				this.ispaymentInfor = true
			},
			closepaymentInfor(){
				this.ispaymentInfor = false
			},
			weidaozhang(){
                this.$http('POST', '/receivables/financial_confirmation.php',{forid:this.id,is_arrival:0}).then(res => {
                    if(res.code==0){
                    	alert(res.msg)
                        this.$emit('closeDetail')
                    }else {
                        alert(res.msg)
                    }
                }).catch(err => {

                })
            },
		}
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../../assets/main";
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
							span {
								color: $mainColor;
							}
						}
						.htlists {
							.container {
								padding: 0;
								margin: 5px 0 10px;
								.row {
									line-height: 22px;
									.col-xs-4 {
										color: $huiColor;
									}
									.col-xs-8 {
										color: $wordColor;
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
