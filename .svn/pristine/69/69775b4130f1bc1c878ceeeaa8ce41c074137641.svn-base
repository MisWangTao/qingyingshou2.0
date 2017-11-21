<template>
	<div id="paymentDetail">
		<div class="seal" v-if="data.states==3"><img :src="imghost+'yichang-@2x.png'" alt="异常"></div>
		<div id="model" v-show="showopera" @click="closeopera">
			<div id="screen">
				<i class="three"></i>
				<p @click="zhidingreceive">指定给</p>
				<p @click="hexiaoreceive">核销</p>
				<p @click="deletereceive">删除</p>
			</div>
		</div>
		<div class="contract detail writeOff">
			<div class="container-fluid">
				<div class="title"><h4>回款信息</h4></div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">客户名称</div>
						<div class="col-xs-9">{{data.custom_name}}</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">结算方式</div>
						<div class="col-xs-9">{{data.payment_method | echopaymethod}}</div>
					</div>
				</div>
<!-- 				<div class="container">
					<div class="row">
						<div class="col-xs-3">账号</div>
						<div class="col-xs-9">{{data.values}}</div>
					</div>
				</div> -->
				<div class="container">
					<div class="row">
						<div class="col-xs-3">回款金额</div>
						<div class="col-xs-9"><span>￥{{data.arrival_amount | numberFormat}}</span></div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">回款日期</div>
						<div class="col-xs-9">{{data.arrival_date}}</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">备注</div>
						<div class="col-xs-9">{{data.remarks}}</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">附件</div>
						<div class="col-xs-9">
							<div class="file">
                                <div class="col-xs-4" v-for="(item,key) in data.files">
                                    <div>
                                        <img :src="item.src" alt="">
                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid" v-show="data.states==2">
				<div class="title">
					<h4>核销信息</h4>
				</div>
				<div class="container" v-for="item,key in data.hexiao">
					<h4>{{item.contract_name}}</h4>
					<div class="row">
						<div class="col-xs-3">合同编号</div>
						<div class="col-xs-9">{{item.contract_number}}</div>
					</div>
					<div class="row">
						<div class="col-xs-3">合同金额</div>
						<div class="col-xs-9">￥{{item.contract_money}}</div>
					</div>
					<div class="row">
						<div class="col-xs-3">本次核销</div>
						<div class="col-xs-9">￥{{item.hexiao}}</div>
					</div>
				</div>
			</div>
		</div>

        <!-- 选择人员部分弹框 -->
        <div v-show="showadduser" class="modal">
            <div class="modalInner">
                <div class="modalHead">
                    <h4>选择人员</h4>
                    <i class="icon iconfont" @click="closeadduser">&#xe60f;</i>
                </div>
                <div class="modalBody">
                    <div class="cont">
                        <p class="p">回款信息发给指定人员后,可直接认领核销，请选择指定对象:</p>
                        <div class="person">
                            <div class="col" @click="chooseuser">
                                <div class="imgs">
                                    <div class="img">
                                        <img :src="imghost+'tianjia@2x.png'" alt="">
                                    </div>
                                </div>
                                <p class="tjry">添加人员</p>
                            </div>
                            <div class="col" v-for="item,key in checkedusers">
                                <div class="imgs">
                                    <div class="img">
                                        <img v-if="!item.ding_avatar"  :src="imghost+'menu/hetong_new@2x.png'" alt="">
                                        <img v-if="item.ding_avatar"   :src="item.ding_avatar" alt="">
                                    </div>
                                </div>
                                <p>{{item.realname}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="ipts">
                        <input class="ipt1" type="button" value="取消" @click="closeadduser" />
                        <input class="ipt2" type="button" value="确定" @click="subzhiding" />
                    </div>
                </div>
            </div>
        </div>
        <!-- 选择人员部分弹框 -->
        <div v-show="showchoseuser" class="modal">
            <div class="modalInner">
                <div class="modalHead">
                    <h4>选择人员</h4>
                    <i class="icon iconfont" @click="closechooseuser">&#xe60f;</i>
                </div>
                <div class="modalBody">

                    <div class="cont" v-for="item,key in userlist">
                        <div class="title"><span></span><h4>{{item.depart_name}}</h4></div>
                        <div class="person" >

                            <div class="col" v-for="i,k in item.users" @click="checkeduser(i,key,k)">
                                <div class="imgs">
                                    <div class="img">
                                        <img v-if="!i.ding_avatar"  :src="imghost+'menu/hetong_new@2x.png'" alt="">
                                        <img v-if="i.ding_avatar"   :src="i.ding_avatar" alt="">
                                    </div>
                                    <div class="active" v-show="i.checked"><i class="icon iconfont">&#xe614;</i></div>
                                </div>
                                <p>{{i.realname}}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

	</div>
</template>
<script>
	import searchInput from '../../../../components/searchInput/searchInput.vue'
	import {host, imghost} from '../../../../config/config.js'
	import ccl from '../../../../common/ccl.js'
    import {mapMutations} from 'vuex'
	export default{
		data(){
			return{
				host,
				imghost,
				searchVal : '',
				showopera :false,
				data:{},
				showadduser:false,
                showchoseuser:false,
                userlist:[],
				checkedusers:[],
			}
		},
		mounted(){
			
			this.inidata()
		},
		components: {
			searchInput,
		},
		methods:{
            ...mapMutations([
                "CLEARSELECTCUSROM",
            ]),
			inidata(){
                this.CLEARSELECTCUSROM()
				const _this = this

				this.$http('POST', '/receivables/get_receivable_details.php',{id:this.$route.params.id}).then(res => {
	                this.data = res.data
	                if(res.data.states==1){
	                	ccl.setRight({
						text:'操作',
						onSuccess: () =>{ _this.showopera = !_this.showopera }
					})
	                }
	            })

			},
			search(val){
				this.searchVal = val
			},
			closeopera(){
				this.showopera = false
			},
			zhidingreceive(){
				this.$http('POST','/receivables/appoint_person.php',{custom_id:this.data.custom_id}).then(res=>{
	                this.userlist = res.data
	                this.showadduser = true
	            })
			},
			hexiaoreceive(){

				const id = this.$route.params.id
				this.$router.push("/hexiao/"+id+"?caiwu=1")
			},
			deletereceive(){

			},
            closeadduser(){
                this.showadduser  = false
            },
            chooseuser(){
                this.showchoseuser = true
            },
            closechooseuser(){
                this.showchoseuser = false
            },
            checkeduser(user,key,k){
                let users = this.checkedusers.filter( e => { return e.userId == user.userId })

                if(!users.length){
                    this.checkedusers.push(user)
                    this.userlist[key].users[k].checked = true
                }else{
                    const userId = user.userId
                    for(let i = 0 ;i<this.checkedusers.length;i++){
                        if(this.checkedusers[i].userId==userId)this.checkedusers.splice(i,1)
                    }
                    this.userlist[key].users[k].checked = false
                }

                this.showchoseuser = false
            },
            subzhiding(){

                if(this.checkedusers.length==0)alert("请选择指派人")
                let id = this.$route.params.id

                var newForm = new FormData()
                newForm.append('id',id)
                newForm.append('userids',JSON.stringify(this.checkedusers))
                
                this.$http('FORM','/receivables/financer_assign_business.php',newForm).then(res=>{
                    if(res.code == 0){
                        this.$router.go(-1)
                    }else{
                        alert(res.msg)
                    }
                })

            }
		}
	}
</script>
<style lang="scss" scoped>
	@import "../../../../assets/main";
	#paymentDetail{
		.seal {
			position: absolute;
			top: 20%;
			left: 30%;
			width: 7rem;
			z-index: 2;
			opacity: 0.8;
			img {
				width: 100%;
			}
		}
		#model{
			position:fixed;
			top:0;
			width:100%;
			height:100%;
			background:$bgOpcity;
			z-index:1;
			#screen{
				width:5rem;
				position:absolute;
				right:0.2rem;
				top:0.3rem;
				background-color:#fff;
				.three{
					position:absolute;
					top:-0.28rem;
					right:1rem;
					border-left: 0.3rem solid transparent;
					border-right: 0.3rem solid transparent;
					border-bottom: 0.3rem solid #fff;
				}
				p{
					line-height:1.6rem;
					text-align:center;
					color:#5a6879;
					border-bottom:1px solid #eee;
				}
				p:last-child{
					border:none;
				}
			}
		}
		.title {
			background: $bgColor;
		}
		.writeOff {
			.container-fluid {
				.title {
					background: $bgColor;
				}
				.container {
					margin: 0 0.5rem;
					padding: 0.3rem 0;
					border-bottom: $qianStyle;
					h4 {
						padding-left: 6px;
					}
					.row {
						border: 0;
						padding: 0;
						line-height: 1.4rem;
						span {
							color: $mainColor;
						}
					}
				}
			}
		}
	}
	.cont {
        padding: 0.3rem 0.5rem;
        overflow: hidden;
        .p {
            color: #333333;
        }
        .title {
            span {
                margin: 0 5px 3px 0;
                display: inline-block;
                width: 5px;
                height: 5px;
                background: $mainColor;
            }
            h4 {
                display: inline-block;
                font-size: $fontSize;
                color: #666666;
            }
        }
        .person {
            margin-top: 0.5rem;
            overflow: hidden;
            .col {
                margin: 0.3rem 0;
                width: 33.333%;
                float: left;
                text-align: center;
                .imgs {
                    width: 60%;
                    margin: 0 auto;
                    position: relative;
                    .img {
                        position: relative;
                        width: 100%;
                        padding-bottom: 100%;
                        img {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            border-radius: 50%;
                            
                        }
                    }
                    .active {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(56, 145, 249, 0.4);
                        border-radius: 50%;
                        i {
                            font-size: 1.5rem;
                            color: $baiColor;
                            opacity: 0.8;
                        }
                    }
                }
                p {
                    line-height: 1.2rem;
                    font-size: 0.65rem;
                    color: #000000;
                }
                .tjry {
                    color: #5a6879;
                }
            }
        }
    }
</style>
