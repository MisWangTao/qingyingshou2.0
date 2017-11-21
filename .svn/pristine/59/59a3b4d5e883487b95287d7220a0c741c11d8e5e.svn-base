<template>
	<div id="contractInfo">
        <!-- <div @click="goEdit">编辑</div> -->
		<div class="contractInfoTop" @click="showcontractDetail">
			<div>
				{{data.contract.contract_name}}
				<span>{{data.contract.contract_date}}</span>
			</div>
			<p>{{data.contract.custom_name}}</p>
			<p>合同金额（元）：<span>{{data.contract.contract_money | numberFormat}}</span></p>
			<p>应收余额（元）：<span>{{(data.contract.contract_money-data.contract.verification_money) | numberFormat}}</span></p>
			<i class="icon iconfont tel">&#xe605;</i>
		</div>
		<div class="addPayment" v-if="data.contract.contract_type==3" @click="addPayment"><span>+新增合同款</span></div>
		<div class="contractInfoBottom">
			<div class="infoNav">
				<span @click="changshowindex(1)"><strong :class="{active:showindex==1}"><img :src="imghost+'huikuan_selected@2x.png'" alt="" />回款</strong></span>
				<span @click="changshowindex(2)"><strong :class="{active:showindex==2}"><img :src="imghost+'dongtai_default@2x.png'" alt="" />动态</strong></span>
			</div>
			<div class="infoTab">
				<div class="editPlan" v-show="showindex==1">
					<div class="title" v-if="data.contract.contract_type==1" @click="editreturnPlan">修改回款计划</div>
			
					<div class="itemPlan" v-for="item,key in data.plan">
						<p class="planing">
							<span>第{{key+1}}期</span>
							<span v-if="item.plan_money == item.planed_money">已完成</span>
							<span v-else>未完成</span>
						</p>
						<div class="itemPlanCont">
							<div class="div1">
								<span class="jihua">计划</span>
								<span class="date">{{item.plan_date}}</span>
								<span class="type">{{item.plan_type}}</span>
								<span class="jine">计划回款:{{item.plan_money}}</span>
							</div>
							<div class="div2">
								{{item.plan_remark}}
							</div>
							<div class="div1" v-for="i,k in item.plan_detail">
								<span class="shiji">实际</span>
								<span class="date">{{i.returning_time}}</span>
								<span class="type"></span>
								<span class="jine">回款:{{i.returning_money}}</span>
							</div>
						</div>
					</div>

				</div>
				<div class="timeAxis" v-show="showindex==2">
					<div class="line">
						<div class="lineBorder"></div>
					</div>
					<div class="startImg"><img :src="imghost+'start@2x.png'" alt="" /></div>
					<div class="step" v-for="item,key in this.data.dongtai">
						<div class="date"><h3>{{splitDate(item.time,1)}}</h3><span>{{splitDate(item.time,2)}}</span></div>
						<div class="details"><i class="icon iconfont">&#xe617;</i>
						<p>{{item.name}}
						<span class="span1">创建</span>了合同：
						<span class="span2">{{item.desc}}</span></p></div>
					</div>
					<!--<p>{{item.name}}<span class="span1">到账</span>了一笔回款，<span class="span2">金额5000元。</span></p></div>-->
					<!--<div class="step">
						<div class="date"><h3>7-06</h3><span>14:16</span></div>
						<div class="details"><i class="icon iconfont">&#xe617;</i>
						<p>张小萌<span class="span1">编辑</span>了合同，<span class="span2">联系人王小明更改为张小萌。</span></p></div>
					</div>
					<div class="step">
						<div class="date"><h3>7-06</h3><span>14:16</span></div>
						<div class="details"><i class="icon iconfont">&#xe617;</i>
						<p>张小萌<span class="span1">创建</span>了合同：<span class="span2">设备销售合同SK58355</span></p></div>
					</div>-->
				</div>
			</div>
		</div>
	</div>
</template>
<script>
    import {mapMutations} from 'vuex'
	import { host,imghost } from '../../../config/config.js'
	import  ccl from '../../../common/ccl.js'
	export default{
		data(){
			return {
				host,
				imghost,
				data:{contract:{},plan:[],dongtai:[]},
				showindex:1,
			}
		},
		mounted(){
			this.initData()
		},
		methods:{
            ...mapMutations([
                'SETEDITCONTRACT','CLEARSELECTCUSROM'
            ]),
			initData(){

				const _this = this

				ccl.setRight({
					text:'编辑',
					onSuccess: () => _this.goEdit()
				})

				this.$http('POST', '/contract/get_contract_info.php',{id:this.$route.params.id}).then(res => {
                    this.data = res.data
                }).catch(err => {

                })
                
			},
            goEdit(){
			    this.SETEDITCONTRACT({})
                this.CLEARSELECTCUSROM()
			    let id = this.$route.params.id
                this.$router.push('/editContract/' + id)
            },
			changshowindex(index){
				this.showindex = index
			},
			showcontractDetail(){
				this.$router.push('/contractDetail/'+this.$route.params.id)
			},
			editreturnPlan(){
				this.$router.push('/editplan/'+this.$route.params.id)
			},
			addPayment(){
				this.$router.push('/addPayment/'+this.$route.params.id)
			},
			splitDate(date,type){
				let dates = date.split(" ")
				
				if(type==1){
					let yuefen = dates[0]
					yuefen = yuefen.split("-")
					return yuefen[1]+'-'+yuefen[2]
				}else if(type==2){
					let shijian = dates[1]
					shijian = shijian.split(":")
					return shijian[0]+':'+shijian[1]
				}
			}
		}
	}
</script>
<style lang="scss" scoped>
@import "../../../assets/main.scss";
	#contractInfo{
		padding-bottom: 3rem;
		.addPayment {
			padding: 0 0 0.5rem;
			text-align: center;
			span {
				color: $mainColor;
				font-size: 0.75rem;
			}
		}
		.contractInfoTop{
			margin:0.5rem;
			box-shadow:3px;
			background-color:#fff;
			border-radius:5px;
			line-height: 1.2rem;
			padding: 0.5rem 0.5rem 0.75rem;
			position: relative;
			div{
				font-size:0.75rem;
				color:#0c1c2c;
				span{
					display:inline-block;
					border-left: $qianStyle;
					color:#97a8be;
					font-size:0.6rem;
					height:0.6rem;
					padding-left: 0.5rem;
					margin-left:0.5rem;
					line-height:0.6rem;
				}
			}
			p{
				font-size:0.65rem;
				color:#5a6879;
				span {
					color: $mainColor;
				}
			}
			.tel {
				position: absolute;
				top: 2.5rem;
				right: 0.5rem;
				font-size: 1.8rem;
				color: #3891f9;
			}
		}
		.contractInfoBottom{
			border-top:1px solid #eee;
			border-bottom:1px solid #eee;
			.infoNav{
				height:1.75rem;
				display:flex;
				background: $baiColor;
				border: $qianStyle;
				span{
					padding:0 10%;
					flex-grow:1;
					strong{
						display:block;
						width:100%;
						height:100%;
						line-height:1.75rem;
						text-decoration:none;
						text-align:center;
						font-size:0.7rem;
						color:#9eabba;
						font-weight:100;
					}
					img {
						width: 0.9rem;
						margin-right: 0.2rem;
						vertical-align: top;
						margin-top: 0.4rem;
					}
					strong.active{
						color:#3891f9;
						border-bottom:2px solid #3891f9;
						img {
							width: 1rem;
						}
					}
				}
				span:first-child{
					border-right:1px solid #eee;
				}
			}
			.infoTab{
				
				background-color:#fff;
				.editPlan {
					
					.title{
							padding-right: 0.5rem;
						font-size: 0.7rem;
						line-height: 1.6rem;
						text-align:right;
						color:#3891f9;
					}
					.planing{
						font-size:0.6rem;
						padding: 0 0.5rem;
						line-height: 1.6rem;
						color:#000;
						background-color:#F0F7FF;
						span:last-child{
							float:right;
						}
					}
					.itemPlanCont {
						background: #ffffff;
						padding: 0.5rem 0.5rem;
						.div1 {
							color: #121213;
							overflow: hidden;
							padding: 0.2rem 0;
							span {
								display: block;
								float: left;
							}
							.jihua,.shiji {
								width: 1.8rem;
								height: 0.8rem;
								line-height: 0.8rem;
								
								text-align: center;
								

							}
							.jihua {
								color: #fe5206;
								border: 1px solid #fe5206;
							}
							.shiji {
								color: $mainColor;
								border: $lanBorder;
							}
							.date {
								margin: 0 1.5rem 0 1.1rem;
							}
							.type {

							}
							.jine {
								float: right;
							}
						}
						.div2 {
							color: #999999;
							padding: 0.2rem 0 0.2rem 3rem;
						}
					}
				}
				.timeAxis {
					padding: 1rem 0.5rem;
					position: relative;
					.line {
						position: absolute;
						top: 1rem;
						left: 2.75rem;
						bottom: 1rem;
						z-index: 2;
						.lineBorder{
							width: 0.07rem;
							height: 100%;
							background: #e9f0f7;
						}

					}
					.startImg {
						position: absolute;
						bottom: 0.2rem;
						left: 1.7rem;
						img {
							width: 1.2rem;
						}
					}
					.step {
						padding: 0.5rem 0;
						.date {
							h3 {
								display: inline-block;
								color: #ff7010;
								font-size: 0.8rem;
								font-weight: bold;
							}
							span {
								margin-left: 0.8rem;
								color: #bbb;
								font-size: 0.6rem;
							}
						}
						.details {
							padding-left: 1.9rem;
							line-height: 1.2rem;
							font-size: 0.7rem;
							color: #666;
							i {
								position: relative;
								z-index: 3;
								color: #333;
								font-size: 0.8rem;
								float: left;
								display: inline-block;
							}
							
							p {
								
								margin-left: 1.2rem;
								.span1 {
									color: $mainColor;
								}
								.span2 {
									color: #999999;
								}
							}
						}
					}
				}
			}
		}
	}
	@media screen and (max-width: 341px) {
		#contractInfo .contractInfoBottom .infoTab .editPlan .itemPlanCont .div1 .date {
			margin: 0 0.6rem 0 .3rem;
		}
		#contractInfo .contractInfoBottom .infoTab .editPlan .itemPlanCont .div2{
			padding: 0 0 0 2.2rem;

		}
	}
	@media screen and (max-width: 376px) and (min-width: 346px) {
		#contractInfo .contractInfoBottom .infoTab .editPlan .itemPlanCont .div1 .date {
			margin: 0 1.2rem 0 1rem;
		}
	}
</style>
