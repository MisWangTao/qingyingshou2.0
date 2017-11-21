<template>
	<div>
		<div class="centerModal hxModal">
			<div class="modalInner">
				<div class="header">
					<h3>核销</h3>
					<i class="icon iconfont" @click="hiddenoptionContract">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="writeOff">
						<div class="title">回款详情</div>
						<div class="hkdetail">
							<div class="col-xs-6">
								<p>客户名称</p>
								<p>{{data.custom_name}}</p>
							</div>
							<div class="col-xs-6">
								<p>回款方式</p>
								<p>{{data.payment_method}}</p>
							</div>
							<div class="col-xs-6">
								<p>单据编号</p>
								<p>{{data.bill_number}}</p>
							</div>
							<div class="col-xs-6">
								<p>回款金额</p>
								<p><span>￥{{data.arrival_amount}}</span></p>
							</div>
							<div class="col-xs-6">
								<p>回款日期</p>
								<p>{{data.arrival_date}}</p>
							</div>
							<div class="col-xs-12">
								<p>备注</p>
								<p>{{data.remarks}}</p>
							</div>
							<div class="col-xs-12">
								<p>附件</p>
								<div class="file">
									<table>
										<thead>
											<tr>
												<th>文件名称</th>
												<th>文件大小</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
											<tr v-for="item,key in data.files">
												<td>{{item.old_name+item.ext}}</td>
												<td>{{item.filesize}}</td>
												<td><span>预览</span>|<span>下载</span></td>
											</tr>
										</tbody>
									</table>
		  
								</div>
							</div>
						</div>
						<div class="title">核销详情</div>
						<div class="hexiaoDetail">
							<div class="top">
								<p>选择合同</p>
								<p>已选择<span>{{checkedcontractlist.length}}</span>个合同<span @click="chooseptionContract">[点击选择]</span></p>
							</div>

							<div class="container" v-for="item,key in checkedcontractlist">
								<div class="col-xs-7">
									<p>合同名称</p>
									<p>{{item.contract_name}}</p>
								</div>
								<div class="col-xs-5">
									<p>合同日期</p>
									<p>{{item.contract_date}}</p>
								</div>
								<div class="col-xs-7">
									<p>合同金额</p>
									<p>￥{{item.contract_money}}</p>
								</div>
								<div class="col-xs-5">
									<p>应收余额</p>
									<p>￥{{item.yuer}}</p>
								</div>

								<div class="col-xs-7">
									<p>本次核销金额</p>
									<p><span>￥{{item.returning_money | numberFormat}}</span></p>
								</div>
								<div class="col-xs-6">
									<p></p>
									<p></p>
								</div>
								<div class="col-xs-6">
									<p></p>
									<p></p>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="footer">
					<button class="btn cancel" @click="hiddenoptionContract">取消</button>
					<button class="btn confirm" @click="submitwriteoff">确定</button>
				</div>
			</div>
		</div>
		<optionContract :customid="data.custom_id" v-if="showoptionContract" @closeoptionContract="closeoptionContract" @submitoptionContract="submitoptionContract"></optionContract>
	</div>
</template>

<script>
	import {host, imghost} from '../../config/config.js'
	import optionContract from '../optionContract/optionContract.vue'
	export default{
		components: {
            optionContract,
        },
        props:['id','newsId'],
		data(){
			return {
				host,
				imghost,
				data:{},
				showoptionContract:false,
				checkedcontractlist:[]
			}
		},
		mounted(){
			this.iniData()
		},
		methods:{
			iniData(){
				this.I(this.id)
				this.$http('POST','/receivables/get_receivable_details.php',{id:this.id}).then( res => {
					if(res.code==0){
						this.data = res.data
					}
				})
			},
			chooseptionContract(){
				this.showoptionContract = true
			},
			closeoptionContract(){
				this.showoptionContract = false
			},
			submitoptionContract(checkedcontractlist){
				this.checkedcontractlist = checkedcontractlist
				this.showoptionContract = false
			},
			hiddenoptionContract(){
				this.$emit('hiddenoptionContract')
			},
			submitwriteoff(){
				let newForm = new FormData()
                let apiurl  = ''

                if(this.newsId){
                	newForm.append('newsid',this.newsId)
                	apiurl = 'receivables/business_claim.php'
                }else{
                	newForm.append('id',this.id)
                	apiurl = 'receivables/business_claim_caiwu.php'
                }
                newForm.append('contract',JSON.stringify(this.checkedcontractlist))

                this.$http("FORM", apiurl ,newForm).then(res => {
                    if(res.code==0){
                    	this.$emit('hiddenoptionContract')
                    }else{
                    	alert(res.msg)
                    }
                })
			}
		}
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main";
	.centerModal {
		.modalInner {
			.body {
				background: #ffffff;
				.writeOff {
					.title {
						background: $danlanColor;
						line-height: 40px;
						font-size: 16px;
						padding: 0 20px;
						overflow: hidden;
					}
					.hkdetail {
						overflow: hidden;
						padding: 8px 30px;
						.col-xs-6,.col-xs-12 {
							p{
								line-height: 28px;
							}
							p:first-child {
								float: left;
								width: 70px;
								color: $huiColor;
							}
							p:nth-child(2) {
								float: left;
								width: 210px;
								color: $wordColor;
								span {
									color: $mainColor;
								}
							}
						}
						.col-xs-12 {
							p:nth-child(2) {
								width: 490px;
							}
						}
						.file {
							float: left;
							width: 490px;
							table {
								width: 100%;
								border: $borderStyle;
								border-collapse:collapse;
								thead {
									background: #eef1f6;
									tr {
										th{
											white-space: nowrap;
											font-weight: normal;
											text-align: center;
											border: $borderStyle;
											padding: 6px;
										}
									}
								}
								tbody {
									tr{
										td {
											text-align: center;
											border: $borderStyle;
											padding: 6px 12px;
											i {
												font-size: 16px;
												cursor: pointer;
											}
											span {
												margin: 0 4px;
												color: $mainColor;
												cursor: pointer;
											}
										}
										td:first-child {
											text-align: left;
										}
									}
								}
							}
						}
					}
					.hexiaoDetail {
						padding: 8px 30px;
						.top {
							overflow: hidden;
							p {
								float: left;
							}
							p:first-child {
								width: 70px;
								color: $huiColor;
							}
							p:nth-child(2) {
								width: 200px;
								color: $wordColor;
								span {
									margin: 0 4px;
									color: $mainColor;
								}
								span:last-child {
									cursor: pointer;
								}
							}
						}
						.container {
							margin: 0 60px 0 70px;
							padding: 12px 0;
							overflow: hidden;
							border-bottom: 1px dashed #dbe2ee;
							.col-xs-7,.col-xs-5 {
								p {
									line-height: 28px;
								}
								p:first-child {
									float: left;
									width: 90px;
									color: $huiColor;
								}
								p:nth-child(2) {
									float: left;
									color: $wordColor;
									span {
										color: $mainColor;
									}
								}
							}
							.col-xs-5 {
								p:first-child {
									width: 70px;
								}
							}
						}
						.container:last-child {
							border: 0;
						}
					}
				}
			}
		}
	}
				
 
</style>
