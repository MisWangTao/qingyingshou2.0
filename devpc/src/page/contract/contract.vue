<template>
	<div class="wrap">
		<div class="main-content">
			<div class="header">
				<div class="row">
					<div class="left">
						<input class="xinjian" type="button" value="新建" @click="addNewContract()">
						<span class="port"><i class="icon iconfont">&#xe6d9;</i>导入</span>
						<span class="port"><i class="icon iconfont">&#xe60d;</i>导出</span>
						<span @click="del_contract" class="port dele"><i class="icon iconfont">&#xe601;</i>删除</span>
					</div>
					<div class="right">
						<span class="screen"><i class="icon iconfont">&#xe611;</i>筛选</span>
						<div class="searchInput">
							<input type="search" v-model="searchVal" placeholder="请输入搜索内容...">
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
							<th><input @click="changeAll" :checked="isShowall" type="checkbox"></th>
							<th>客户名称</th>
							<th>合同名称</th>
							<th>合同日期<i class="icon iconfont">&#xe60e;</i></th>
							<th>合同金额<i class="icon iconfont">&#xe60e;</i></th>
							<th>回款金额<i class="icon iconfont">&#xe60e;</i></th>
							<th>应收余额<i class="icon iconfont">&#xe60e;</i></th>
							<th><i class="icon iconfont">&#xe613;</i></th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(item,key) in contractData" @click="showDetail(item.id)">
							<td @click.stop><input :checked="chooseId.indexOf(item.id)>=0" @click="changeId(item.id)" type="checkbox"></td>
							<td>{{item.custom_name}}</td>
							<td>{{item.contract_name}}</td>
							<td>{{item.contract_date}}</td>
							<td>￥{{item.contract_money | numberFormat}}</td>
							<td>￥{{item.verification_money | numberFormat}}</td>
							<td>￥{{(item.contract_money - item.verification_money) | numberFormat}}</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="line"></div>
			<div class="bottom">
				<div class="left">
					汇总 |
					<p>合同金额(人民币):<span>{{statistics && statistics.htje | numberFormat}}</span></p>
					<p>到账金额(人民币):<span>{{statistics && statistics.arrival_amount | numberFormat}}</span></p>
					<p>应收余额(人民币):<span>{{statistics && statistics.ysye | numberFormat}}</span></p>
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
		<!-- 合同详细信息部分弹框 -->
		<contractInfo v-if="showDetails" @closeDetail="hideDetail" :id="detailId"></contractInfo>

		<!-- 新建合同弹框 -->
		<newContract v-if="showNewContract" @closeNewContract="hiddenNewContract" @closeAutoMacticAndNewContractComponents="closeAutoMacticAndNewContractComponents" @closeManualAndNewContractComponents="closeManualAndNewContractComponents"></newContract>
		<!-- 选择客户部分弹框 -->
		<!-- <selectCustomers v-show="false"></selectCustomers> -->
		
		<!-- 添加产品信息部分弹框 -->
		<addProduct v-show="false"></addProduct>

	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../config/config.js'
	import contractInfo from './contractInof/contractInfo.vue'
	// import selectCustomers from '../../components/selectCustomers/selectCustomers.vue'
	
	import addProduct from '../../components/addProduct/addProduct.vue'
	import newContract from './newContract/newContract.vue'
	import axios from 'axios'
	export default{
		data(){
			return {
				host,
				imghost,
                allData:[],
                chooseId : [],
                searchVal : '',
                statistics:[],
                showNewContract:false,
                showDetails : false,
                detailId:'',
                
			}
		},
        computed:{
            contractData(){
                let arr = [];
                let val = this.searchVal;
                this.allData.map((item)=>{
                    if(item.custom_name.indexOf(val)>=0 || item.custom_name.indexOf(val) >= 0){
                        arr.push(item)
                    }
                })
                return arr
            },
            isShowall(){
                let objVal = []
                this.contractData.map((item)=>{
                    return objVal.push(item.id)
                })
                let aa = 1;
                for(let i=0;i<objVal.length; i++){
                    if(this.chooseId.indexOf(objVal[i])<0){
                        aa = 2
                    }
                }
                return aa == 1 ? true : false
        
            },
        },
        mounted(){
            this.initData()
        },
		components: {
            contractInfo,
            newContract,
            // selectCustomers
            addProduct
        },
        methods: {
            initData(){
                this.$http("GET", '/contract/get_contract_list.php').then(res => {

                    this.allData = res.data
                    this.statistics = res.result
                }).catch(err => {
                
                })
            },
            del_contract(){


                if(this.chooseId.length>0){
                    this.$http('POST','/contract/del_contract.php',{contract_id:JSON.stringify(this.chooseId)}).then(res=>{
                    	
                    	if(res.code==0){
                    		this.allData = this.allData.filter( item => {return this.chooseId.indexOf(item.id)==-1} )
                    		this.chooseId = []
                    	}else{
                    		alert(res.msg)
                    	}

                    }).catch(err=>{
        
                    })
                }

            },
            changeAll(e){
                if(e.target.checked == true){
                    this.chooseId = []
                    this.contractData.map((item)=>{
                        return this.chooseId.push(item.id)
                    })
                }else{
                    this.chooseId = []
                }
            },//全选
            showDetail(id){
            	this.detailId = id
                this.showDetails = true;
            },
            hideDetail(val){
                if(val){
                    this.allData = val
                }
                this.showDetails = false
            },
            changeId(id){
                if(this.chooseId.indexOf(id)>-1){
                    this.chooseId.splice(this.chooseId.indexOf(id),1)
                }else{
                    this.chooseId.push(id)
                }
            },//单选
            addNewContract(){
            	this.showNewContract = true;
            },
            hiddenNewContract(){
            	this.showNewContract = false;
            },
            //关闭新建合同和自动回款计划组件
            closeAutoMacticAndNewContractComponents(){
            	this.showNewContract = false;
            },
            //关闭手动回款计划和新建合同组件
            closeManualAndNewContractComponents(){
            	this.showNewContract = false;
            },
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
					td:nth-child(2){
						color: #014d90;
					}
					td:nth-child(2):hover {
						color: $mainColor;
					}
					td:nth-child(2),td:nth-child(3) {
						text-align: left;
						max-width: 220px;
						padding-left: 20px;
						white-space: normal;
					}
					td:nth-child(5),td:nth-child(6),td:nth-child(7) {
						text-align: right;
						padding-right: 20px;
					}
				}
			}
		}
	}
 
</style>
