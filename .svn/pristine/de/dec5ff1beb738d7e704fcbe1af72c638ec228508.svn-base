<template>
	<div>
		<div class="centerModal xzhtModal">
			<div class="modalInner">
				<div class="header">
					<h3>选择合同</h3>
					<i class="icon iconfont" @click="closeoptionContract">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="searchInput">
						<input type="text" placeholder="请输入搜索内容" value="">
						<i class="icon iconfont">&#xe637;</i>
					</div>
					<div class="contractItems">

						<div class="lists" v-for="item,key in contractlist">
							<div class="chk">
								<input type="checkbox" name="" value="" v-model="checked[item.id]" >
							</div>
							<div class="infor">
								<div class="row">
									<div class="col-xs-8">{{item.contract_name}}</div>
									<div class="col-xs-4">2017-08-05</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										合同金额<span>￥{{item.contract_money | numberFormat}}</span>
									</div>
									<div class="col-xs-6">
										应收余额<span>￥{{item.yuer | numberFormat}}</span>
									</div>
								</div>
								<div class="row">
									本次核销金额<p>￥<input type="text" value="" v-model="money[item.id]" ></p>
								</div>
							</div>
						</div>

					</div>
				</div>
				<div class="footer">
					<button class="btn cancel"  @click="closeoptionContract">取消</button>
					<button class="btn confirm" @click="submitoptionContract">确定</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import {host, imghost} from '../../config/config.js'
	export default{
		props:{customid:{type:String}},
		data(){
			return {
				host,
				imghost,
				contractlist:[],
				money:[],
				checked:[]
			}
		},
		mounted(){

			this.iniData()
		},
		methods:{
			iniData(){
				this.$http('GET','/receivables/get_custom_contract_list.php?custom_id='+this.customid).then( res => {
					if(res.code==0){
						this.contractlist = res.data

						// for(let i in this.optionContract.contract){
					 //  		this.checked[this.optionContract.contract[i].contract_id] = true
					 //  		this.money[this.optionContract.contract[i].contract_id]  = this.optionContract.contract[i].returning_money
					 //  	}
					}
				})
			},
			submitoptionContract(){

				let contracts = []
				for(let i in this.money){
					if(this.money[i]){

						const  oldcontract = this.contractlist.filter( e => { return e.id==i } )[0]
						let    contract = {}

						for(let l in oldcontract){
							contract[l] = oldcontract[l]
						}
						contract.returning_money = this.money[i]
						contract.contract_id     = i
						
						contracts.push(contract)

					}
				}

				this.$emit('submitoptionContract',contracts)
			},
			closeoptionContract(){
				this.$emit('closeoptionContract')
			}
		},
		watch: {
			money:function(val,oldval){

				for(let i in val){
					if(val[i]){
						this.checked[i] = true
					}
				}
			},
			checked:function(val,oldval){
				for(let i in val){
					if(val[i]==false){
						this.money[i]=''
					}
				}
			}
		}
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main";
	.centerModal {
		.modalInner {
			width: 540px;
			margin: 150px auto 0;
			.body {
				padding: 0 0 20px;
				background: #ffffff;
				min-height: 300px;
				.searchInput {
					width: 480px;
					margin: 12px auto;
					position: relative;
					input {
						padding-left: 26px;
						width: 454px;
						height: 30px;
						color: #121827;
						border: $borderStyle;
						border-radius: 3px;
						background: #f5f9ff;
					}
					i {
						position: absolute;
						top: 7px;
						left: 5px;
						font-size: 16px;
						color: #d7dee5;
					}

				}
				.contractItems {
					padding: 0 30px;
					max-height:300px;
					overflow: auto;
					.lists {
						margin-top: 16px;
						overflow: hidden;
						padding: 0 12px;
						.chk {
							float: left;
							width: 36px;
							input {
								margin-top: 5px;
								width: 16px;
								height: 16px;
							}
						}
						.infor {
							width: 400px;
							float: left;
							.row {
								overflow: hidden;
								color: $huiColor;
								line-height: 28px;
								.col-xs-8 {
									color: #000;
								}
								.col-xs-4 {
									text-align: right;
								}
								.col-xs-6 {
									span {
										color: #000;
									}
								}
								.col-xs-6:nth-child(2) {
									text-align: right;
								}
								span {
									margin-left: 16px;
								}
								p {
									margin-left: 12px;
									display: inline-block;
									width: 130px;
									border-bottom: $qianStyle;
									line-height: 20px;
									color: $wordColor;
									input {
										display: inline-block;
										width: 110px;
										border: 0;
									}
								}
								.active {
									border-bottom: 1px solid $mainColor;;
									color: $mainColor;
									input {
										color: $mainColor;
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
