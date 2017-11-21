<template>
	<div>
		<div class="centerModal">
			<div class="modalInner">
				<div class="header">
					<h3>指定业务员</h3>
					<i class="icon iconfont" @click="closeappoint">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="appoint">
						<div class="row">
							<div class="col-xs-3">客户名称</div>
							<div class="col-xs-9">{{data.custom_name}}</div>
						</div>
						<div class="row">
							<div class="col-xs-3">回款方式</div>
							<div class="col-xs-9">{{data.payment_method | echopaymethod}}</div>
						</div>
						<div class="row">
							<div class="col-xs-3">回款金额</div>
							<div class="col-xs-9"><span class="lan">￥{{data.arrival_amount}}</span></div>
						</div>
						<div class="row">
							<div class="col-xs-3">回款日期</div>
							<div class="col-xs-9">{{data.arrival_date}}</div>
						</div>
						<div class="row">
							<div class="col-xs-3">发给谁<i class="icon iconfont">&#xe800;</i></div>
							<div class="col-xs-9">
								<div class="people">
									<span>刘德华<i>×</i></span>
									<span>陈奕迅<i>×</i></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">发给谁<i class="icon iconfont">&#xe800;</i></div>
							<div class="col-xs-9">
								<select multiple='multiple' v-model="checkedusers">
									<option v-for="(item,key) in userlist" :value="item.user_id">{{item.realname}}</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="footer">
					<button class="btn cancel" @click="closeappoint">取消</button>
					<button class="btn confirm" @click="subzhiding">确定</button>
				</div>
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
				userlist:[],
				checkedusers:[]
			}
		},
		props:['data','id'],
		mounted(){
			this.I(this.data)
			this.iniData()
		},
		methods:{
			closeappoint(){
				this.$emit('closeappoint')
			},
			iniData(){
				this.$http('POST','/custom/get_custom_responsible_list.php',{custom_id:this.data.custom_id}).then(res=>{
	                this.userlist = res.data
	            })
			},
			subzhiding(){

                if(this.checkedusers.length==0){
                	alert("请选择指派人")
                	return
                }
                let id = this.id
                var newForm = new FormData()
                newForm.append('id',id)
                newForm.append('userids',JSON.stringify(this.checkedusers))
                
                this.$http('FORM','/receivables/financer_assign_business.php',newForm).then(res=>{
                    if(res.code == 0){
                        this.$emit('closeappoint')
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
	@import "../../../../assets/main.scss";
	.centerModal {
		z-index: 15;
		.modalInner {
			margin: 180px auto 0;
			width: 420px;
			.body {
				min-height: 180px;
				.appoint {
					padding: 20px 20px 30px;
					.row {
						overflow: hidden;
						line-height: 28px;
						.col-xs-3 {
							text-align: right;
							color: $huiColor;
						}
						.col-xs-9 {
							padding-left: 20px;
							color: $wordColor;
							.lan {
								color: $mainColor;
							}
							.people {
								width: 260px;
								height: 28px;
								border-radius: 3px;
								border: $iptBorder;
								background: $baiColor;
								span {
									margin-left: 6px;
									padding: 1px 2px;
									font-size: 12px;
									background: $lanBg;
									i {
										font-style: normal;
										font-size: 14px;
										cursor: pointer;
										
									}
								}
							}
						}
					}
				}
			}
		}
	}

</style>
