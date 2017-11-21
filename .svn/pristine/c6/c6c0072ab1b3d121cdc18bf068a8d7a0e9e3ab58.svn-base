<template>
	<div>
		<div class="centerModal xjkhModal">
			<div class="modalInner">
				<div class="header">
					<h3>新建客户</h3>
					<i @click="hideModel" class="icon iconfont">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="newCustomer">
						<div class="row">
							<div class="col-xs-3"><span>*</span>客户名称</div>
							<div class="col-xs-7">
								<input type="text" v-model="newCustomData.custom_name" placeholder="请输入客户名称" value="" />
							</div>
							<div class="col-xs-2">
								<span><i class="icon iconfont">&#xe659;</i>工商查询</span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">客户编号</div>
							<div class="col-xs-9">
								<input type="text" v-model="newCustomData.custom_number" placeholder="请输入客户编号" value="" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">客户性质</div>
							<div class="col-xs-9">
								<!-- <input type="text" placeholder="请选择客户性质号" value="" /> -->
								<select v-model="newCustomData.custom_nature">
									<option>政府事业单位</option>
									<option>企业</option>
									<option>个人</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">所属行业</div>
							<div class="col-xs-9">
								<select v-model="newCustomData.industry_id">
									<option value="1">金融</option>
									<option value="2">电信</option>
									<option value="3">教育</option>
									<option value="4">高科技</option>
									<option value="5">政府</option>
									<option value="6">制造业</option>
									<option value="7">服务</option>
									<option value="8">能源</option>
									<option value="9">零售</option>
									<option value="10">媒体</option>
									<option value="11">娱乐</option>
									<option value="12">咨询</option>
									<option value="13">非盈利事业</option>
									<option value="14">公共事业</option>
									<option value="15">其他</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">办公地址</div>
							<div class="col-xs-9">
								<input type="text" v-model="newCustomData.custom_address" placeholder="请输入办公地址" value="" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3"><span>*</span>负责人</div>
							<div class="col-xs-9">
								<input type="text" v-model="newCustomData.fuzeren" placeholder="请选择负责人" value="" />
								<span class="choose">选择</span>
							</div>
						</div>
						<!-- <div class="row">
							<div class="col-xs-3">联系人</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请输入或选择联系人" value="" />
								<span class="choose">选择</span>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">联系电话</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请输入联系电话" value="" />
							</div>
						</div> -->
						<div class="title">
							<h4>开票信息</h4>
						</div>
						
						<!-- <div class="row">
							<div class="col-xs-3">所属部门</div>
							<div class="col-xs-9">
								<input type="text" placeholder="跟进人所属部门" value="" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">账期</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请选择账期" value="" />
								<span class="choose">选择</span>
							</div>
						</div> -->
						<div class="row">
							<div class="col-xs-3">发票抬头</div>
							<div class="col-xs-9">
								<input type="text" v-model="newCustomData.invoice_header" placeholder="请输入发票抬头" value="" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">纳税人识别号</div>
							<div class="col-xs-9">
								<input type="text" v-model="newCustomData.payer_id" placeholder="请输入纳税人识别号" value="" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">开户银行</div>
							<div class="col-xs-9">
								<input type="text" v-model="newCustomData.bankName" placeholder="请输入开户银行信息" value="" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">银行账号</div>
							<div class="col-xs-9">
								<input type="text" v-model="newCustomData.bank_number" placeholder="请输入银行账号" value="" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">电话</div>
							<div class="col-xs-9">
								<input type="text" v-model="newCustomData.tel" placeholder="请输入电话号码" value="" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">地址</div>
							<div class="col-xs-9">
								<input type="text" v-model="newCustomData.address" placeholder="请输入电话号码" value="" />
							</div>
						</div>
					</div>
				</div>
				<div class="footer">
					<button class="btn cancel" @click="hideModel">取消</button>
					<button class="btn confirm" @click="sendData">确定</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../../config/config.js'
	export default{
		data(){
			return {
				host,
				imghost,
                newCustomData : {
                    fuzeren : JSON.stringify([{"id":"6088","realname":"34**42","ding_id":"22492740","ding_name":"测试**6"},{"id":"6086","realname":"闫*","ding_id":"15518250","ding_name":"测试**5"}])
                }
			}
		},
        methods:{
		    sendData(){
		        if(this.newCustomData.custom_name == '' || this.newCustomData.custom_name == undefined){
		            this.layer.alert('客户名称不能为空')
		            return;
                }
                this.$http('POST','/custom/add_custom.php',this.newCustomData).then(res=>{
                    if(res.code == 0){
                        this.$emit('newCustomData',res.data)
                        this.newCustomData = {}
                    }else{
                        alert(res.msg)
                    }
                }).catch(err=>{
                
                })
            },
            hideModel(){
                this.$emit('hideModel')
            }
        }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../assets/main";

 
</style>
