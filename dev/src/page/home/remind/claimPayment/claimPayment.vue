<template>
	<div class="contract claim">
		<div class="seal" v-if="data.otherassist"><img :src="imghost+'others@2x.png'" alt="他人认领"></div>
		<div class="container-fluid">
			<div class="container">
				<div class="row">
					<div class="col-xs-3">客户名称</div>
					<div class="col-xs-9">{{data.custom_name}}</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-xs-3">结算方式</div>
					<div class="col-xs-9">{{data.payment_method | echopaymethod}}</div>
				</div>
			</div>
<!-- 			<div class="container">
				<div class="row">
					<div class="col-xs-3">账号</div>
					<div class="col-xs-9">{{data.values}}</div>

				</div>
			</div> -->
			<div class="container">
				<div class="row">
					<div class="col-xs-3">回款金额</div>
					<div class="col-xs-9"><span>{{data.arrival_amount}}</span></div>

				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-xs-3">回款日期</div>
					<div class="col-xs-9">{{data.arrival_date}}</div>

				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-xs-3">操作人</div>
					<div class="col-xs-9">{{data.caozuoren}}</div>

				</div>
			</div>
		</div>
		<div class="container-fluid">
			<div class="container">
				<div class="row">
					<div class="col-xs-3">备注</div>
					<div class="col-xs-9"><textarea>{{data.remarks}}</textarea></div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-xs-3">附件</div>
					<div class="col-xs-9">
						<div class="file">
							<div class="col-xs-4" v-for="item,key in data.files">
								<div>
									<img :src="item.src"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container-fluid state">
			<div class="title">
				<h4>当前状态：
					<span class="dai" v-if="!data.otherassist">待认领</span>
					<span class="renling" v-if="data.otherassist">他人认领</span>
				</h4>
				<p>{{data.updatetime}}</p>
			</div>
			<div class="txt">
				<textarea class="disable"></textarea>
			</div>
			<div class="yiyi" v-if="data.otherassist" @click="yiyi"><p>我有异议></p></div>
			<div class="input-group" v-if="!data.otherassist">
				<input class="ipt1" type="button" value="回退" @click="huitui">
				<input class="ipt2" type="button" value="我要认领" @click="renling">
			</div>
		</div>
		<!-- 我有异议部分弹框 -->
		<div class="modal" v-show="showyiyi">
			<div class="modalInner">
				<div class="modalHead">
					<h4>我有异议</h4>
					<i class="icon iconfont" @click="closeyiyi">&#xe60f;</i>
				</div>
				<div class="modalBody">
					<div class="objection">
						<p>该回款已被他人认领，提出异议：</p>
						<div class="txt">
							<textarea v-model="str" placeholder="请输入补充说明"></textarea>
						</div>
						<div class="assign">
							<div class="left">发给谁</div>
							<div class="right">
								<img :src="imghost+'wp2.jpg'"/>
								<span>{{data.caozuoren}}</span>
							</div>
						</div>
					</div>
					<div class="ipts">
						<input class="ipt1" type="button" value="取消" @click="closeyiyi" />
						<input class="ipt2" type="button" value="确定" @click="subyiyi" />
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	import {host, imghost} from '../../../../config/config.js'
	import {mapState,mapMutations} from 'vuex'
	export default{
		data(){
			return {
				host,
				imghost,
				filesData:[],//预览图片
				str: '',
				data:{},
				showyiyi:false,
			}
		},
		mounted(){
            this.initData()
        },
        computed: {
            
        },
        methods:{
        	...mapMutations([
                'CLEAROPTIONCONTRACT'
            ]),
        	initData(){

                this.$http("POST", 'receivables/business_claim_detail.php',{id:this.$route.params.id}).then(res => {
                    this.data = res.data
                }).catch(err => {

                })
            },
            yiyi(){

            	this.showyiyi = true
            },
            subyiyi(){

            	this.$http("POST", 'receivables/business_dissent.php',{newsid:this.$route.params.id,reason:this.str}).then(res => {
            		alert(res.msg)
                }).catch(err => {

                })             	
            },
            closeyiyi(){

            	this.showyiyi = false
            },
            huitui(){

			   	this.$http("POST", 'receivables/business_callback.php',{newid:this.$route.params.id}).then(res => {
                    
                }).catch(err => {

                })         	
            },
            renling(){
            	this.CLEAROPTIONCONTRACT()
            	this.$router.push('/hexiao/'+this.$route.params.id)
            }
        }
	}
</script>
<style lang="scss" scoped>
	@import "../../../../assets/main.scss";
	.seal {
		position: absolute;
		top: 10%;
		left: 26%;
		width: 8rem;
		z-index: 2;
		opacity: 0.8;
		img {
			width: 100%;
		}
	}
	.claim {
		.state {

			.title {
				border-top: 1px solid #e6e6e6;
				padding: 0.3rem 0.8rem;
				background: $bgColor;
				
				h4 {
					display: inline-block;
					color: #121213;
					.dai {
						color: $huangColor;
					}
					.renling {
						color: $lvColor;
					}
				}
				p {
					display: inline-block;
					float: right;
					color: #888888;
					font-size: 0.65rem;
				}
			}
			.txt {
				padding: 0.5rem 0.8rem;
				textarea {
					width: 100%;
					height: 3rem;
					border-radius: 2px;
					border: 1px solid #b7c2cf;
				}
				.disable {
					background: #f5f5f5;
				}
			}
			.yiyi {
				padding: 0 0.8rem;
				text-align: right;
				p {
					display: inline-block;
					color: $mainColor;
					font-size: 0.75rem;
					
				}
			}
		}
	}
	.objection {
		padding: 0 0.3rem;
		p {
			color: #121213;
		}
		.txt {
			margin-top: 0.3rem;
			padding: 0.1rem 0.2rem;
			border: $borderStyle;
			border-radius: 4px;
			textarea {
				border: 0;
				width: 100%;
				height: 2.4rem;
				
			}
		}
		.assign {
			overflow: hidden;
			margin-top: 0.3rem;
			.left {
				float: left;
				line-height: 1.4rem;
			}
			.right {
				width: 3rem;
				float: left;
				text-align: center;
				img {
					margin: 0 auto;
					display: block;
					width: 1.2rem;
					height: 1.2rem;
					border-radius: 50%;
				}
				span {
					color: #888;
				}
			}
		}
	}
	

</style>
