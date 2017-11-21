<template>
	<div>
		<div class="centerModal xzkhModal">
			<div class="modalInner">
				<div class="header">
					<h3>选择客户</h3>
					<i class="icon iconfont" @click="closeSelectCustom">&#xe60f;</i>
				</div>
				<div class="searchInput">
					<i class="icon iconfont">&#xe637;</i><input type="text" placeholder="请输入搜索内容" value="">
				</div>
				<div class="body">
					<div class="selectCustomers">
						<div class="row">
							<div class="col-xs-2"></div>
							<div class="col-xs-4">客户名称</div>
							<div class="col-xs-3">客户编号</div>
							<div class="col-xs-3">客户性质</div>
						</div>
						<div class="row" v-for="(item,key) in customList" @click="changeChooseId(key,item.id,item.custom_name)">
							<div class="col-xs-2"><input type="checkbox" :ref="'checkId'+key"  :value="item.id" :checked="chooseId==item.id"></div>
							<div class="col-xs-4">{{item.custom_name}}</div>
							<div class="col-xs-3">{{item.custom_number}}</div>
							<div class="col-xs-3">{{item.custom_nature==1?'个人':item.custom_nature==2?'企业':item.custom_nature==3?'政府事业单位':''}}</div>
						</div>
					</div>
				</div>
				<div class="footer">
					<button class="btn cancel" @click="closeSelectCustom">取消</button>
					<button class="btn confirm" @click="chooseCutom">确定</button>
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
				customList:[],
				chooseId:'',
				chooseName:'',
			}
		},
		mounted(){
		    this.getCustomer()
        },
		methods:{
			//获取客户列表
			getCustomer(){
				this.$http("GET",'/custom/get_custom_list.php').then(res=>{

					this.customList = res.data

				}).catch(err => {
                
                })
			},
			closeSelectCustom(){

				this.$emit('closeSelectCustom')
			},
			chooseCutom(){
				if(this.chooseId=='')return

				let customInfo = {custom_id:this.chooseId,custom_name:this.chooseName}

				this.$emit('customInfo',customInfo)
			
			},
			changeChooseId(k,id,name){

				let nowRef = 'checkId'+k

				if(this.$refs[nowRef][0].checked==false)
				{
					this.chooseId = ''
					this.chooseName = ''
				}else{
					this.chooseId = id
					this.chooseName = name
				}
				
			}
		}

	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main.scss";
   .searchInput {
		width: 500px;
		margin: 16px auto 10px;
		position: relative;
   		input {
   			padding: 0 10px 0 28px;
			width: 100%;
			height: 30px;
			border: $borderStyle;
			border-radius: 3px;
			background: #e9f2fa;
   		}
   		i {
   			position: absolute;
   			top: 8px;
   			left: 6px;
   			font-size: 16px;
   			color: #d7dee5;
   		}
   }
   .selectCustomers {
   		background: #ffffff;
	   	border-top: 2px solid $mainColor;
	   	.row {
	   		overflow: hidden;
	   		background: #f9f9f9;
	   		line-height: 34px;
	   		.col-xs-2 {
	   			text-align: center;
	   			input {
	   				vertical-align: middle;
	   				display: inline-block;
	   				width: 14px;
	   				height: 14px;
	   			}
	   		}
	   		.col-xs-3:last-child {
	   			text-align: center;
	   		}
		}
		.row:first-child {
			background: #e9f2fa;
			height: 40px;
			line-height: 40px;
			border-bottom: $borderStyle;
			.col-xs-2 {
				height: 40px;
			}
		}
		.row:nth-child(2n) {
			background: #ffffff;
		}
   }
</style>
