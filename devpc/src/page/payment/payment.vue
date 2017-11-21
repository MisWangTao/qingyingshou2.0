<template>
	<div class="wrap">
		<div class="main-content">
			<div class="header">
				<div class="row">
					<div class="left">
						<input class="xinjian" type="button" value="新建回款" @click="newbuild" >
						<input class="xinjian" type="button" value="预计回款"  @click="openYujiComponents">
						<span class="port"><i class="icon iconfont">&#xe6d9;</i>导入</span>
						<span class="port"><i class="icon iconfont">&#xe60d;</i>导出</span>
					</div>
					<div class="right">
						<span class="screen"><i class="icon iconfont">&#xe611;</i>筛选</span>
						<div class="searchInput">
							<input type="search" placeholder="请输入搜索内容...">
							<i class="icon iconfont">&#xe637;</i>
						</div>
					</div>
				</div>
				<div class="row condition" v-show="false">
					<div class="col">合同状态
						<select>
							<option>未完成</option>
							<option>已完成</option>
						</select>
					</div>
					<div class="col">合同日期
						<select>
							<option>全部</option>
							<option>今天</option>
							<option>本周</option>
							<option>本月</option>
							<option>本季度</option>
							<option>本年</option>
						</select>
					</div>
					<div class="col">逾期状态
						<select>
							<option>全部</option>
							<option>逾期</option>
							<option>未逾期</option>
						</select>
					</div>
				</div>
			</div>
			<div class="middle contract">
				<table>
					<thead>
						<tr>
							<th>客户名称</th>
							<th>回款日期<i class="icon iconfont">&#xe60e;</i></th>
							<th>回款金额<i class="icon iconfont">&#xe60e;</i></th>
							<th>回款方式</th>
							<th>状态</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item,key in datalist" @click="showDetail(item.id)">
							<td>{{item.custom_name}}</td>
							<td>{{item.arrival_date}}</td>
							<td>{{item.arrival_amount}}</td>
							<td>{{item.payment_method_id | echopaymethod}}</td>
							<td>{{item.states | echopaymentstates}}</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="line"></div>
			<div class="bottom">
				<div class="left">
<!-- 					汇总 |
					<p>合同金额(元):<span>126623.00</span></p>
					<p>到账金额(元):<span>126723.00</span></p>
					<p>应收余额(元):<span>125623.00</span></p> -->
				</div>
				<div class="right">
					<p>共96条</p>
					<ul>
						<li><i class="icon iconfont">&#xe61c;</i></li>
						<li class="active">1</li>
						<li>2</li>
						<li>3</li>
						<li>4</li>
						<li>5</li>
						<li>...</li>
						<li>9</li>
						<li>10</li>
						<li><i class="icon iconfont">&#xe61d;</i></li>
					</ul>
					<p>前往<input type="text" value="1">页</p>
				</div>
			</div>
		</div>
		<paymentdetail v-if="showDetails" @closeDetail="hideDetail" :id="detailId"></paymentdetail>
		<newPayment v-if="shownewpayment" @closeNewPayment="hideNewPayment" @closeNewPaymentandwriteOff="closeNewPaymentandwriteOff"></newPayment>
		<writeOff v-if="showwriteOff && writeOffid" :id="writeOffid" @hiddenoptionContract="hiddenoptionContract"></writeOff>
		<!--预计回款-->
		<yujiReturn v-if="showYujiReturnComponents" @closeYujiReturnComponents="hiddenYujiReturnComponents"></yujiReturn>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../config/config.js'
	import paymentdetail from './paymentdetail/paymentdetail.vue'
	import newPayment from './newPayment/newPayment.vue'
	import yujiReturn from './yujiReturn/yujiReturn.vue'
	import selectCustomer from './newPayment/selectCustomer/selectCustomer.vue'
	import writeOff from '../../components/writeOff/writeOff.vue'
	import axios from 'axios'
	export default{
		data(){
			return {
				host,
				imghost,
				datalist:[],
				detailId:'',
				showDetails:false,
				shownewpayment:false,
				showwriteOff:false,
				writeOffid:0,
				showYujiReturnComponents:false,
			}
		},
		components: {
			paymentdetail,
			newPayment,
			selectCustomer,
			writeOff,
			yujiReturn
        },
        mounted(){
        	this.initData()
        },
        methods:{
        	initData(){
        		this.$http('GET', '/receivables/get_receicalble_list.php').then(res => {
	                this.datalist = res.data
	            })
        	},
        	showDetail(id){
            	this.detailId = id
                this.showDetails = true
            },
            hideDetail(){
            	this.showDetails = false
            },
            newbuild(){
            	this.shownewpayment = true
            },
            hideNewPayment(){
            	this.shownewpayment = false
            },
            closeNewPaymentandwriteOff(id){
            	this.shownewpayment = false
            	this.showwriteOff   = true
            	this.writeOffid = id
            },
            //打开预计回款组件
            openYujiComponents(){
            	this.showYujiReturnComponents = true
            },
            //关闭预计回款组件
            hiddenYujiReturnComponents(){
            	this.showYujiReturnComponents = false
            },
            hiddenoptionContract(){
            	this.showwriteOff   = false
            }
        }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main.scss";
	.contract {
		table {
			thead {
				th {

				}
			}
			tbody {
				tr {
					td {
						text-align: center;
					}
				}
			}
		}
	}
	.main-content {
		.middle {
			table {
				tbody {
					tr {
						 td:nth-child(2) {
						 	border: 0;
						 }
					}
				}
			}
		}  
	}
   
</style>
