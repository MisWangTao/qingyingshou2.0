<template>
	<div>
		<div class="centerModal xzkhModal">
			<div class="modalInner">
				<div class="header">
					<h3>选择客户</h3>
					<i class="icon iconfont" @click="closeSelectCustom">&#xe60f;</i>
				</div>
				<div class="searchInput">
					<div class="ipt">
						<i class="icon iconfont">&#xe637;</i>
						<input type="text" placeholder="请输入搜索内容" value="">
					</div>
				</div>
				<div class="body">
					<div class="selectCustomers">
						<div class="row">
							<div class="col-xs-5">客户名称</div>
							<div class="col-xs-3">合同金额</div>
							<div class="col-xs-4">应收余额</div>
						</div>
						<div class="row" v-for="(item,key) in customList" @click="chooseCutom(item)">
							<div class="col-xs-5">{{item.custom_name}}</div>
							<div class="col-xs-3">{{item.sum_contract_money | numberFormat}}</div>
							<div class="col-xs-4">{{item.sum_contract_money- item.sum_verification_money | numberFormat}}</div>
						</div>

					</div>
				</div>
				<!-- <div class="footer">
					<button class="btn cancel">取消</button>
					<button class="btn confirm">确定</button>
				</div> -->
			</div>
		</div>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../../../config/config.js'
	export default{
		data(){
			return {
				host,
				imghost,
				customList:[],
				chooseId:'',
				chooseName:'',
			}
		},
		mounted(){
		    this.getCustomer()
        },
		methods:{
			getCustomer(){
				this.$http("GET",'/custom/get_custom_list.php').then(res=>{

					this.customList = res.data

				}).catch(err => {
                
                })
			},
			closeSelectCustom(){

				this.$emit('closeSelectCustom')
			},
			chooseCutom(custom){

				let customInfo = {custom_id:custom.id,custom_name:custom.custom_name}
				this.$emit('checkedcustomInfo',customInfo)
			}
		}
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../../assets/main.scss";
   .searchInput {
		margin: 16px auto 10px;
		padding: 0 40px;
		overflow: hidden;
	   	.ipt {
	   		
	   		float: right;
	   		position: relative;
	   		input {
	   			padding: 0 10px 0 28px;
				width: 300px;
				height: 30px;
				border: $borderStyle;
				border-radius: 3px;
				background: $titleBg;
	   		}
	   		i {
	   			position: absolute;
	   			top: 8px;
	   			left: 6px;
	   			font-size: 16px;
	   			color: #d7dee5;
	   		}
	   	}
   }
   .selectCustomers {
   		background: #ffffff;
	   	border-top: 2px solid $mainColor;
	   	.row {
	   		overflow: hidden;
	   		background: #f9f9f9;
	   		line-height: 34px;
	   		padding: 0 10px;
	   		.col-xs-5 {
	   			padding-left: 30px;
	   		}
	   		.col-xs-4,.col-xs-3 {
	   			text-align: right;
	   		}
	   		.col-xs-4 {
	   			padding-right: 40px;
	   		}
		}
		.row:first-child {
			background: $titleBg;
			height: 40px;
			line-height: 40px;
			border-bottom: $borderStyle;
			.col-xs-5 {
				padding-left: 80px;
			}
			.col-xs-3 {
				padding-right: 20px;
			}
			.col-xs-4 {
				padding-right: 50px;
			}
		}

		.row:nth-child(2n) {
			background: #ffffff;
		}
		.row:hover {
			background: #e7eef9;
		}
   }
</style>
