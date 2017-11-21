<template>
	<div>
		<div class="centerModal bjhkjhModal">
			<div class="modalInner">
				<div class="header">
					<h3>编辑回款计划</h3>
					<i @click="closeEdit" class="icon iconfont">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="top">
						变更后，合同金额：<span>￥{{allMoney | numberFormat}}</span>　　回款金额：<span>￥{{Number(huiMoney)-Number(tuiMoney) | numberFormat}}</span>
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
									<th><i @click="addPlan" class="icon iconfont lan">&#xe616;</i></th>
								</tr>
							</thead>
							<tbody>
								<!-- 不可编辑删除
								<tr>
									<td></td>
									<td></td>
									<td>
										常规
									</td>
									<td>
										￥{{item.plan_money | numberFormat}}
									</td>
									<td>￥{{item.planed_money | numberFormat}}</td>
									<td>
										<i class="icon iconfont lan">&#xe616;</i>
										<i class="icon iconfont hui">&#xe610;</i>
									</td>
								</tr>-->
								<!-- 可编辑删除 -->
								<tr v-for="item,key in editData">
									<td>{{key+1}}
									<td><input type="date" v-model="item.plan_date"></td>
									<td>
										<select v-model="item.plan_type">
											<option value="1">常规</option>
											<option value="2">预收款</option>
											<option value="3">质保金</option>
											<option value="4">尾款</option>
										</select>
									</td>
									<td>
										<input type="text" v-model="item.plan_money">
									</td>
									<td>￥{{item.planed_money | numberFormat}}</td>
									<td>
										<i @click="addPlan" class="icon iconfont lan">&#xe616;</i>
										<i @click="del_plan(item,key)" class="icon iconfont red">&#xe610;</i>
									</td>
								</tr>
                                <!--<tr>
                                    <td>3</td>
                                    <td><input type="date" value="2017-08-15"></td>
                                    <td>
                                        <select>
                                            <option>常规</option>
                                            <option>预收款</option>
                                            <option>质保金</option>
                                            <option>尾款</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" value="￥5552.00">
                                    </td>
                                    <td>￥0.00</td>
                                    <td>
                                        <i class="icon iconfont lan">&#xe616;</i>
                                        <i class="icon iconfont red">&#xe610;</i>
                                    </td>
                                </tr>-->
							</tbody>
						</table>
					</div>
				</div>
				<div class="footer">
					<button @click="closeEdit" class="btn cancel">取消</button>
					<button @click="closeEditBaocun" class="btn confirm">确定</button>
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
                editData : [],
			}
		},
        props:['planData','allMoney','contract_date','huiMoney','tuiMoney'],
        mounted(){
		    this.initData()
        },
		methods:{
            initData(){
                let sum = '0.00';
                this.I(this.planData)
                for(let i=0; i<this.planData.length; i++){
                    let obj={};
                    for(let j in this.planData[i]){
                        obj[j] = this.planData[i][j]
                    }
                    this.editData.push(obj)
                    if(this.planData[i].planed_money > 0){
                        sum = Number(sum)+Number(this.planData[i].planed_money)
                    }
                }
                this.return_money = sum;
            },
            changeEditData(newVal,oldVal){
                let newArr = []
                for(let i=0;i<newVal.length;i++){
                    if(newVal[i].plan_date != '' && newVal[i].plan_money != ''){
                        let obj = {};
                        for(let j in newVal[i]){
                            obj[j] = newVal[i][j]
                            obj['index'] = i;
                        }
                        newArr.push(obj)
                    }
                }
                newArr.sort(function(a,b){
                    return a.plan_date>b.plan_date? 1 : -1
                })
                let lastMoney = Number(this.huiMoney) -Number(this.tuiMoney)
                for(let z=0; z<newArr.length; z++){
                    if(Number(lastMoney) > Number(newArr[z].plan_money)){
                        newArr[z].planed_money = newArr[z].plan_money;
                        lastMoney = Number(lastMoney) - Number(newArr[z].plan_money)
                    }else{
                        newArr[z].planed_money = lastMoney;
                        lastMoney = '0.00'
                    }
                    let ind = newArr[z].index;
                    for(let ii in newArr[z]){
                        this.editData[ind][ii] = newArr[z][ii]
                    }
                }
                for(var o=0;o<this.editData.length;o++){
                    if(this.editData[o].plan_date == '' || this.editData[o].plan_money == ''){
                        this.editData[o].planed_money = '0.00'
                    }
                }
            },
		    closeEdit(){
		        this.$emit('closeEdit')
            },
            closeEditBaocun(){
		        this.I(this.editData)
		        this.I(this.contract_date)
                let all= 0;
		        for(let i=0;i<this.editData.length;i++){
		            this.I(this.editData[i].plan_date)
		            if(this.editData[i].plan_date == ''){
                        this.layer.alert('回款计划日期不能为空')
                        return;
                    }
		            if(this.editData[i].plan_date < this.contract_date){
                        this.layer.alert('回款计划日期不能早于合同日期')
                        return;
                    }
		            if(this.editData[i].plan_money == ''){
                        this.layer.alert('回款计划金额不能为空')
                        return;
                    }
		            if(Number(this.editData[i].plan_money) > Number(this.allMoney)){
                        this.layer.alert('回款计划金额不能大于合同金额')
                        return;
                    }
                    if(Number(this.editData[i].plan_money) < Number(this.editData[i].planed_money)){
                        this.layer.alert('回款计划金额不能小于核销金额')
                        return;
                    }
                    all+=Number(this.editData[i].plan_money)
                }
                if(all > Number(this.allMoney)){
                    this.layer.alert('回款计划金额总和不能大于合同金额')
                    return;
                }
		        this.$emit('closeEdit',this.editData)
            },
            addPlan(){
                let obj = {}
                obj.plan_date = ''
                obj.plan_detail = ''
                obj.plan_money = ''
                obj.plan_remark = ''
                obj.planed_money = '0.00'
                obj.plan_type = '1'
                this.editData.push(obj)
            },
            del_plan(item,key){
                if(item.planed_money > 0){
                    this.editData.splice(key,1)
                    let lastMoney = Number(item.planed_money);
                    for(let i=key; i<this.editData.length;i++){
                        if(lastMoney > 0){
                            if(this.editData[i].plan_money > lastMoney){
                                this.editData[i].planed_money = lastMoney
                                lastMoney = 0;
                            }else{
                                lastMoney = lastMoney - Number(this.editData[i].plan_money);
                                this.editData[i].planed_money = this.editData[i].plan_money;
                            }
                        }
                    }
                }else if(item.planed_money == 0){
                    this.editData.splice(key,1)
                }
            }
        },
        watch:{
            editData:{
                handler(newVal,oldVal){
                    this.changeEditData(newVal,oldVal)
                },
                deep:true
            }
        }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../../../assets/main";
	.centerModal {
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
