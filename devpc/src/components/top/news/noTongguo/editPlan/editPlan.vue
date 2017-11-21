<template>
	<div>
		<div class="centerModal">
			<div class="modalInner">
				<div class="header">
					<h3>编辑回款计划</h3>
					<i @click="closeEdit" class="icon iconfont">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="top">
						变更后，合同金额：<span>￥{{allMoney | numberFormat}}</span>　　回款金额：<span>￥{{return_money | numberFormat}}</span>
					</div>
					<div class="table">
						<table>
							<thead>
								<tr>
									<th>期次</th>
									<th>计划回款时间</th>
									<th>计划类型</th>
									<th>计划金额</th>
									<th>实际回款</th>
									<!--<th><i class="icon iconfont lan">&#xe616;</i></th>-->
								</tr>
							</thead>
							<tbody>
								<!-- 不可编辑删除 -->
								<tr v-for="item,key in returnPlan">
									<td>{{key+1}}</td>
									<td>{{item.change_plan_date}}</td>
									<td>
                                        {{item.change_plan_type == '1' ? '常规' : item.change_plan_type == '2' ? '预收款' :
                                        item.change_plan_type == '3' ? '质保金' : item.change_plan_type == '1' ? '尾款' : ''}}
									</td>
									<td>
										￥{{item.change_plan_money | numberFormat}}
									</td>
									<td>￥{{item.changed_plan_money | numberFormat}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="footer">
					<button @click="closeEdit" class="btn cancel">取消</button>
					<button @click="closeEdit" class="btn confirm">确定</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import {host, imghost} from '../../../../../config/config.js'
	export default{
		data(){
			return {
				host,
				imghost,
                return_money : '',
			}
		},
        props:['returnPlan','allMoney'],
        mounted(){
		    this.I(this.returnPlan)
		    this.initData()
        },
		methods:{
            initData(){
                let sum = 0;
                for(let i=0; i<this.returnPlan.length; i++){
                    if(this.returnPlan[i].changed_plan_money>0){
                        sum += Number(this.returnPlan[i].changed_plan_money)
                    }
                }
                this.return_money = sum;
                this.I(this.return_money)
            },
		    closeEdit(){
		        this.$emit('closeEdit')
            }
        }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../../../assets/main";
	.centerModal {
		z-index: 22;
		.modalInner {
			margin: 180px auto 0;
			width: 600px;
			.body{
				padding: 0 20px 30px;
				.top {
					margin: 16px 0;
					color: $huiColor;
					span {
						margin: 0 4px;
					}
				}
				.table {
					width: 100%;
					table {
						width: 100%;
						border: $borderStyle;
						border-collapse:collapse;
						color: #1f2a44;
						thead {
							background: #eef1f6;
							tr {
								th{
									white-space: nowrap;
									font-weight: normal;
									text-align: center;
									border: $borderStyle;
									padding: 6px;
									i {
										font-size: 14px;
										cursor: pointer;
									}
									.lan {
										color: $mainColor;
									}
								}
							}
						}
						tbody {
							tr{
								td {
									text-align: left;
									padding: 6px 4px;
									white-space: nowrap;
									input,select {
										height: 22px;
										border-radius: 3px;
										border: $iptBorder;
									}
									i {
										font-size: 13px;
										cursor: pointer;
									}
									.hui {
										color: $huiColor;
									}
									.lan {
										color: $mainColor;
									}
									.red {
										color: $redColor;
									}
								}
								td:first-child {
									text-align: center;
								}
								td:nth-child(2) input {
									width: 130px;
								}
								td:nth-child(3) select {
									width: 80px;
									height: 24px;
								}
								td:nth-child(4) input {
									width: 100px;
								}
							}
						}
					}
				}
			}
		}
	}

</style>
