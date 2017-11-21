<template>
	<div>
		<div class="centerModal xjhkModal">
			<div class="modalInner">
				<div class="header">
					<h3>新建回款</h3>
					<i class="icon iconfont" @click="closenewpayment">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="newContract">
						<div class="row">
							<div class="col-xs-3"><span>*</span>客户名称</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请选择客户名称" value="" v-model="checkedcustomname" @focus="changshowcustomlist(1)" @blur="changshowcustomlist(0)" />
								<span class="choose" @click="chooseustome">选择</span>
								<ul class="preset" v-show="isshowcustomlist">
									<li :class="{active:checkedcustomid==item.id}"
										v-for="item,key in customlist" 
										v-show="checkedcustomname && item.custom_name.indexOf(checkedcustomname)>-1" >{{item.custom_name}}</li>
								</ul>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3"><span>*</span>结算方式</div>
							<div class="col-xs-9">
								<select v-model="data.payment">
									<option value="1">现金</option>
									<option value="2">银行转账</option>
									<option value="3">支票</option>
									<option value="4">其他</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3"><span>*</span>回款金额</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请输入回款金额" value="" v-model="data.arrival_amount"/>
							</div>
						</div>
						
						<div class="row">
							<div class="col-xs-3"><span>*</span>回款日期</div>
							<div class="col-xs-9">
								<input type="date" value="" v-model="data.arrival_date"/>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">单据编号</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请输入单据编号" value="" v-model="data.bill"/>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">备注</div>
							<div class="col-xs-9">
								<input type="text" placeholder="30字以内备注信息" value="" v-model="data.remark"/>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">附件</div>
							<div class="col-xs-9 file">
								<table v-show="this.filesMap.length>0">
									<thead>
										<tr>
											<th>文件名称</th>
											<th>文件大小</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="item,key in filesMap">
											<td>{{item.name}}</td>
											<td>{{item.size}}</td>
											<td>
												<i class="icon iconfont yulan">&#xe660;</i>
												<i class="icon iconfont xiazai">&#xe62a;</i>
												<i class="icon iconfont dele" @click="delImg(key)">&#xe612;</i>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="upload"><p>+点击添加附件</p>
								<input type="file" multiple="true" @change="upload"/></div>
							</div>
						</div>
					</div>
				</div>
				<div class="footer">
					<button class="btn cancel" @click="preservation">保存</button>
					<button class="btn confirm" @click="subnewpayment">确定</button>
				</div>
			</div>
		</div>

		<selectCustomer v-show="showSelectCustom" @closeSelectCustom="hiddenSelectCustom" @checkedcustomInfo="ChooseCustomer"></selectCustomer>
	
	</div>
</template>

<script>
	import {host, imghost} from '../../../config/config.js'
	import axios from 'axios'
	import selectCustomer from './selectCustomer/selectCustomer.vue'
	export default{
		components: {
            selectCustomer,
        },
		data(){
			return {
				host,
				imghost,
				customlist:[],
				showSelectCustom:false,
				checkedcustomname:'',
				checkedcustomid:0,
				isshowcustomlist:false,
				data:{
					files:[],
				},
				filesMap:[],
			}
		},
		mounted(){
			this.getcustomlist()
		},
		methods:{
			closenewpayment(){
				this.$emit('closeNewPayment')
			},
			getcustomlist(){
				this.$http('GET', '/custom/get_custom_list.php').then(res => {
	                this.customlist = res.data
	            })
			},
			hiddenSelectCustom(){
				this.showSelectCustom = false
			},
			ChooseCustomer(custom){
				this.checkedcustomname = custom.custom_name
				this.checkedcustomid = custom.custom_id
				this.showSelectCustom = false
			},
			chooseustome(){
				this.showSelectCustom = true
			},
			changshowcustomlist(index){
				this.isshowcustomlist = index
			},
			preservation(){

				let newForm = new FormData()

				for(let key in this.data){

					if(key=='files')
					{
						if (this.data.files && this.data.files.length > 0) {
		                    for (let i = 0; i < this.data.files.length; i++) {
		                        newForm.append("image" + i, this.data.files[i])
		                    }
		                }
					}else{
						newForm.append(key,this.data[key])
					}
				}
				newForm.append('custom_id',this.checkedcustomid)

                this.$http('FORM', '/receivables/add_receivable.php', newForm).then(res => {

                    if (res.code == 0){
                    	this.$emit('closeNewPayment')
                    }
                })
			},
			subnewpayment(){
				let newForm = new FormData()
				for(let key in this.data){
					if(key=='files')
					{
						if (this.data.files && this.data.files.length > 0) {
		                    for (let i = 0; i < this.data.files.length; i++) {
		                        newForm.append("image" + i, this.data.files[i])
		                    }
		                }
					}else{
						newForm.append(key,this.data[key])
					}
				}
				newForm.append('custom_id',this.checkedcustomid)

                this.$http('FORM', '/receivables/add_receivable.php', newForm).then(res => {

                    if (res.code == 0){
                    	this.$emit('closeNewPaymentandwriteOff',res.data.rece_id)
                    }
                })
				
			},
			upload(e){
				let files = e.target.files
				for(let i=0;i<files.length;i++)
				{
					this.filesMap.push(files[i])
					this.data.files.push(files[i])
				}
			},
			delImg(key){
				this.filesMap.slice(key,1)
			},
		}
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../assets/main";
 	.centerModal {
		.modalInner {
			.body{
				.newContract {
					.row {
						.chanpin {
							.none {
								width: 94%;
								height: 50px;
								border: $borderStyle;
								border-radius: 3px;
								position: relative;
								div {
									padding-left: 10px;
									line-height: 24px;
									height: 24px;
								}
								.div1 {
									color: #cfd3d9;
									border-bottom: 1px dashed #bfcbd9;
								}
								.choose {
									position: absolute;
									top: 2px;
									right: 10px;
									font-size: 13px;
									color: $mainColor;
									cursor: pointer;
								}
							}
						}
                        #customParent{
                            position:relative;
                            .customModel{
                                z-index:20;
                                position:absolute;
                                left:15px;
                                top:31px;
                                border-radius:5px;
                                width:calc(94% - 15px);
                                height:150px;
                                border:1px solid #999;
                                background-color:#fff;
                                overflow: auto;
                                p{
                                    height:20px;
                                    padding-left:10px;
                                    
                                }
                            }
                        }
						.col-xs-9{
							position: relative;
							.hkzq {
								width: 94%;
								height: 30px;
								border: $borderStyle;
								border-radius: 3px;
								position: relative;
								background: #ffffff;
								select {
									display: block;
									float: left;
									width: 80px;
									border: 0;
									-webkit-appearance: textfield;

								}
								input {
									width: 89%;
								}
								span {
									line-height: 30px;
									display: block;
									float: left;
								}
							}
							table {
								tr {
									td {
										white-space: nowrap;
										line-height: 24px;
										span {
											display: block;
											float: left;
											margin-right: 3px;
										}
									}
									td:nth-child(1) input {
										width:90px;
									}
									td:nth-child(2) input {
										width: 60px;
									}
									td:nth-child(3) input {
										width: 30px;
									}
									td:nth-child(4) input {
										width: 30px;
									}
								}
								input {
									display: inline-block;
									height: 24px;
									padding: 0 3px;
								}
								i {
									font-size: 12px;
									cursor: pointer;
								}
							}
							.preset {
								position: absolute;
								top: 32px;
								left: 15px;
								width: 91%;
								background: #ffffff;
								z-index: 11;
								
								li {
									padding-left: 15px;
									list-style: none;
									line-height: 28px;
								}
								.active {
									background: #e7eef9;
								}
							}
							.genjinren {
								position: absolute;
								top: 32px;
								left: 16px;
								z-index: 13;
								height: 160px;
								overflow: auto;
								background: $baiColor;
								box-shadow: 0 0px 6px rgba(0,0,0,0.35);
								.level {
									width: 280px;
									height: 160px;
									float: left;
									border-right: 1px solid #d0d3dc;
									ul {
										padding-left: 24px;
										li {
											line-height: 28px;
											i {
												margin: 0 2px;
												cursor: pointer;
											}
											i:first-child{
												font-size: 16px;
												color: #d0d3dc;
											}
											i:nth-child(2) {
												font-size: 14px;
												color: $mainColor;
											}
										}
									}
								}
								.persons {
									float: left;
									width: 150px;
									height: 160px;
									ul {
										padding: 10px 0 20px 30px;
										li {
											line-height: 30px;
											cursor: pointer;
											i {
												color: $mainColor;
											}
										}
									}
								}
							}
						}
					}
					.atte {
						margin-bottom: -4px;
						padding-left: 430px;
						span {
							color: $mainColor;
						}
					}
				}
			}
		}
	}
</style>
