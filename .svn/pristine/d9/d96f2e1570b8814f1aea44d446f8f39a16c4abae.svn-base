<template>
	<div class="optionContract">
		<searchInput @searchVal="search"></searchInput>
		<div class="container-fluid">

			<div class="container" v-for="item,key in datalist" v-show='isShow(item) >= 0'>
				<div class="left">
					<input type="checkbox"  v-model="checked[item.id]"/>
				</div>
				<div class="right">
					<h4>{{item.contract_name}}</h4><span>2017-08-01</span>
					<div class="jine">合同金额：{{item.contract_money | numberFormat}}</div>
					<div class="jine">应收余额：{{item.yuer | numberFormat}}</div>
  					<div>本次核销金额<p>￥<input type="number" value="" v-model.number="money[item.id]" ></p></div>
				</div>
			</div>

		</div>
		<div class="botBtn">
			<button class="but" @click="submit">确定</button>
		</div>
	</div>
</template>
<script>
	import searchInput from '../searchInput/searchInput.vue'
	import {mapState} from 'vuex'
	import {host, imghost} from '../../config/config.js'
	export default{
		components: {
			searchInput,
		},
		data(){
			return {
				datalist:[],
				searchVal:'',
				money:[],
				checked:[]
			}
		},
		computed: {
            ...mapState([
                'optionContract'
            ]),
            
        },
		mounted(){
      		this.initData()
	    },
		methods: {
			initData(){


				this.$http("GET", 'receivables/get_custom_contract_list.php?custom_id='+this.$route.params.id).then(res => {
				  	this.datalist = res.data
				  	for(let i in this.optionContract.contract){
				  		this.checked[this.optionContract.contract[i].contract_id] = true
				  		this.money[this.optionContract.contract[i].contract_id]  = this.optionContract.contract[i].returning_money
				  	}
				}).catch(err => {

				})
			},
			search(val){
				this.searchVal = val
			},
			isShow(item){
				return item.contract_name.indexOf(this.searchVal)
			},
			submit(){

				let contracts = [],number=0
				for(let i in this.money){
					if(this.money[i]){

						const  oldcontract = this.datalist.filter( e => { return e.id==i } )[0]
						let    contract = {}

						for(let l in oldcontract){
							contract[l] = oldcontract[l]
						}
						contract.returning_money = this.money[i]
						contract.contract_id     = i
						
						contracts.push(contract)
						number++
					}
				}

				this.optionContract.contract = contracts
				this.optionContract.number   = number
				this.$router.go(-1)
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
<style lang="scss" scoped>
	@import "../../assets/main.scss";
	.optionContract {
		padding-bottom: 4rem;
		.container-fluid {
			padding: 0.3rem 0.5rem;
			background: $baiColor;
			.container {
				padding: 0.5rem 0 0.7rem;
				border-bottom: $qianStyle;
				overflow: hidden;
				.left{
					width: 7%;
					float: left;
				}
				.right{
					width: 93%;
					float: left;
					line-height: 1.4rem;
					h4{
						display: inline-block;
						color: #0c1c2c;


					}
					span {
							float: right;
							color: #798088;
						}
					.jine {
						color: #5a6879;
					}
					p {
						margin-left: 0.5rem;
						display: inline-block;
						border-bottom: $borderStyle;
						input {
							width: 5.2rem;
							border: 0;
						}
					}
				}
			}
		}
		.botBtn {
			position: fixed;
			bottom: 0;
			left: 0;
			width: 100%;
			z-index: 9;
			.but {
				display: block;
				width: 100%;
				padding: 0.4rem 0.5rem;
				background: $mainColor;
				border: $lanBorder;
				color: $baiColor;
				font-size: 0.7rem;
				letter-spacing: 4px;
			}
		}
	}
</style>
