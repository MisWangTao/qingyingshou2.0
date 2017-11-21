<template>
	<div>
		<div class="centerModal">
			<div class="modalInner">
				<div class="header">
					<h3>预计回款</h3>
					<i class="icon iconfont" @click="closeYujiReturnComponents">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="newContract yujiReturn">
						<div class="row">
							<div class="col-xs-3"><span>*</span>客户名称</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请选择客户名称" value="" v-model="checkedcustomname" @focus="changshowcustomlist(1)" @blur="changshowcustomlist(0)" />
								<span class="choose" @click="selectCustomer">选择</span>
								<ul class="preset" v-show="isshowcustomlist">
									<li :class="{active:checkedcustomid==item.id}"
										v-for="item,key in customlist"
										v-show="checkedcustomname && item.custom_name.indexOf(checkedcustomname)>-1" >{{item.custom_name}}</li>
								</ul>
							</div>

						</div>
						<div class="row">
							<div class="col-xs-3"><span>*</span>预计回款金额</div>
							<div class="col-xs-9">
								<input type="text" placeholder="请输入预计回款金额" value="" v-model="senddata.arrival_amount" />
							</div>
						</div>
						
						<div class="row">
							<div class="col-xs-3"><span>*</span>预计回款日期</div>
							<div class="col-xs-9">
								<input type="date" value="2017-08-17"  v-model="senddata.arrival_date" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-3">选择核销合同</div>
							<div class="col-xs-9 xzhetong">
								已选择{{checkedcontractlist.length}}个合同<span @click="showoptionContract">[点击选择]</span>
								<div class="container" v-for="item,key in checkedcontractlist">
									<div class="left">
										<p>合同名称</p>
										<p>{{item.contract_name}}</p>
									</div>
									<div class="right">
										<p>合同日期</p>
										<p>{{item.contract_date}}</p>
									</div>
									<div class="left">
										<p>合同金额</p>
										<p>￥{{item.contract_money}}</p>
									</div>
									<div class="right">
										<p>应收余额</p>
										<p>￥{{item.yuer}}</p>
									</div>
									<div class="left">
										<p>本次核销金额</p>
										<p><span>￥{{item.returning_money}}</span></p>
									</div>
								</div>

							</div>
						</div>
						<div class="row">
                            <div class="col-xs-3">发给谁</div>
                            <div class="col-xs-9 person" @click="showtoperson">
                            	 <div class="add" v-if="!senduser.id">
	                                <i class="icon iconfont">&#xe602;</i>
                                    <p>点击添加</p>
	                            </div>
                                <div class="img" v-else>
                                    <img v-if="senduser.ding_avatar" :src="senduser.ding_avatar" alt="">
                                    <img v-else :src="imghost+'logo_defaullt@2x.png'" alt="">
                                    <p>{{senduser.realname}}</p>
                                </div>
                            </div>
                        </div>
						
					</div>
				</div>
				<div class="footer">
					<button class="btn cancel" @click="closeYujiReturnComponents">取消</button>
					<button class="btn confirm" @click="sub">提交</button>
				</div>
			</div>
		</div>
		<selectCustomer v-show="showSelectCustom" @closeSelectCustom="hiddenSelectCustom" @checkedcustomInfo="ChooseCustomer"></selectCustomer>
		<toPerson v-show="isshowtoPerson" @closetoPerson="closetoPerson" @subcheckeduser="subcheckeduser"></toPerson>

		<optionContract :customid="checkedcustomid" v-if="isshowoptionContract" @closeoptionContract="closeoptionContract" @submitoptionContract="submitoptionContract"></optionContract>

	</div>
</template>

<script>
	import {host, imghost} from '../../../config/config.js'
	import selectCustomer from '../newPayment/selectCustomer/selectCustomer.vue'
	import toPerson from '../../../components/toPerson/toPerson.vue'
	import optionContract from '../../../components/optionContract/optionContract.vue'
	import axios from 'axios'
	export default{
		data(){
			return {
				host,
				imghost,
				showSelectCustom:false,
				isshowtoPerson:false,
				senduser:{},
				isshowoptionContract:false,
				checkedcontractlist:[],
				isshowcustomlist:false,
				checkedcustomname:'',
				checkedcustomid:'',
				customlist:[],
				senddata:{}
			}
		},
		mounted(){
			this.getcustomlist()
		},
		components: {
            selectCustomer,
            toPerson,
            optionContract
        },
        methods:{
        	getcustomlist(){
				this.$http('GET', '/custom/get_custom_list.php').then(res => {
	                this.customlist = res.data
	            })
			},
        	//选择客户
        	selectCustomer(){
        		this.showSelectCustom = true
        	},
        	//关闭选择客户
        	hiddenSelectCustom(){
        		this.showSelectCustom = false
        	},
        	closeYujiReturnComponents(){
        		this.$emit('closeYujiReturnComponents')
        	},
        	ChooseCustomer(custom){
				this.checkedcustomname = custom.custom_name
				this.checkedcustomid = custom.custom_id
				this.showSelectCustom = false
			},
			changshowcustomlist(index){
				this.isshowcustomlist = index
			},
        	showtoperson(){
        		this.isshowtoPerson = true
        	},
        	closetoPerson(){
        		this.isshowtoPerson = false
        	},
        	subcheckeduser(user){
        		this.senduser = user
                this.I(this.senduser)
        		this.isshowtoPerson = false
        	},
        	closeoptionContract(){
				this.isshowoptionContract = false
			},
			submitoptionContract(checkedcontractlist){
				this.checkedcontractlist = checkedcontractlist
				this.isshowoptionContract = false
			},
			showoptionContract(){
				if(this.checkedcustomid){
					this.isshowoptionContract = true
				}
			},
			sub(){
				this.senddata.custom_id = this.checkedcustomid
				this.senddata.assist_id = this.senduser.id
                this.senddata.contract  = this.checkedcontractlist

                var newForm = new FormData()
                for(let key in this.senddata){
                    if(key=='contract'){
                        newForm.append(key,JSON.stringify(this.senddata[key]))
                    }
                    else {
                        newForm.append(key,this.senddata[key])
                    }
                }
                
                this.$http('FORM', '/salesmanreceivables/add_fore_busness.php', newForm).then(response => {
                    if(response.code==0){
                        this.$emit('closeYujiReturnComponents')
                    }else{
                        alert(response.msg)
                    }
                })
			}
        },
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../assets/main";
 	.centerModal {
		.modalInner {
			width: 680px;
			.body{
				.yujiReturn {
					.row {
						.col-xs-9{
							position: relative;
							.preset {
								position: absolute;
								top: 32px;
								left: 16px;
								width: 91%;
								background: #ffffff;
								z-index: 11;
								box-shadow: 0 0px 6px rgba(0,0,0,0.35);
								li {
									padding-left: 15px;
									list-style: none;
									line-height: 28px;
									cursor: pointer;
								}
								.active {
									background: #e7eef9;
								}
							}
							.choose {
								right: 38px;
							}
						}
						.xzhetong {
							line-height: 32px;
							span {
								cursor: pointer;
								color: $mainColor;
							}
							.container {
								padding: 10px 0;
								width: 465px;
								overflow: hidden;
								border-bottom: 1px dashed #dbe2ee;
								line-height: 26px;
								.left {
									float: left;
									width: 260px;
									p:nth-child(1){
										width: 100px;
										float: left;
										color: $huiColor;
									}
									p:nth-child(2){
										width: 150px;
										float: left;
										color: $wordColor;
									}
								}
								.right {
									width: 200px;
									float: left;
									p:nth-child(1){
										width: 70px;
										float: left;
										color: $huiColor;
									}
								}
							}
							.container:last-child {
								border: 0;
							}
						}
						.person {
							.add {
								float: left;
								width: 60px;
                                cursor: pointer;
                                text-align: center;
                                i {
                                	font-size: 36px;
                                	 color: #ddd;
                                }
                                p {
                                    line-height: 20px;
                                     color: #ddd;
                                }
							}
                            .img {
                            	float: left;
                                width: 60px;
                                cursor: pointer;
                                text-align: center;
                                img {
                                	margin-top: 6px;
                                    display: inline-block;
                                    width: 30px;
                                    height: 30px;
                                    border-radius: 50%;
                                }
                                p {
                                    line-height: 20px;
                                    color: #000;
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
