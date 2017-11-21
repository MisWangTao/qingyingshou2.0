<template>
	<div>
		<div class="fade">
			<div class="madol">
				<div class="top">
					<h3>{{detailData.company_name}}<span><i class="icon iconfont">&#xe659;</i>工商信息</span></h3>
					<div class="right">
						<div @click="showEdit" class="bradge"><i class="icon iconfont">&#xe68c;</i>编辑</div>
						<div class="bradge"><i class="icon iconfont">&#xe63d;</i>打印</div>
						<div @click="del_customer" class="bradge"><i class="icon iconfont">&#xe61e;</i>删除</div>
						<div @click="closeDetail" class="bradge"><i class="icon iconfont">&#xe60f;</i>关闭</div>
					</div>
				</div>
				<div class="middle">
					<div class="khbh">
						<span>客户编号</span>
						<span>{{detailData.custom_number}}</span>
					</div>
					<div class="date">
						<span>创建日期</span>
						<span>{{detailData.add_time}}</span>
					</div>
					<div class="fzr">
						<span>负责人</span>
						<span v-for="(item,key) in detailData.follows">{{item.realname}}</span>
					</div>
				</div>
				<div class="main">
					<div class="tabSelect">
						<div @click="changeIndex(1)" :class="{'active':activeIndex == 1}">详细信息</div>
						<div @click="changeIndex(2)" :class="{'active':activeIndex == 2}">合同信息(3)</div>
					</div>
					<div class="tabCont">
						<div class="xiangxi" v-show="activeIndex==1">
							<div class="title">基本信息</div>
							<div class="container">
								<div class="row">
									<div class="col-xs-6">
										<p>客户名称：</p>
										<p>{{detailData.custom_name}}</p>
									</div>
									<div class="col-xs-6">
										<p>客户编号：</p><p>{{detailData.custom_number}}</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<p>客户性质：</p>
										<p>{{detailData.custom_nature == 1?'个人' : detailData.custom_nature == 2?'企业':'政府事业单位'}}</p>
									</div>
									<div class="col-xs-6">
										<p>所属行业：</p><p>{{detailData.industry_name}}</p>
									</div>

								</div>
								<div class="row">
									<div class="col-xs-6">
										<p>负责人：</p>
										<p v-for="(item,key) in detailData.follows">{{item.realname}}</p>
									</div>
								</div>
							</div>
							<div class="title">基本信息</div>
							<div class="container">
								<div class="row">
									<div class="col-xs-6">
										<p>联系人：</p>
										<p>张晓涵</p>
									</div>
									<div class="col-xs-6">
										<p>联系电话：</p>
										<p>{{detailData.tel}}</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<p>办公地址：</p>
										<p>{{detailData.bangongdizhi}}</p>
									</div>

								</div>
							</div>
							<div class="title">开票信息</div>
							<div class="container">
								<div class="row">
									<div class="col-xs-6">
										<p>发票抬头：</p>
										<p>{{detailData.fapiaotaitou}}</p>
									</div>
									<div class="col-xs-6">
										<p>纳税人识别号：</p>
										<p>{{detailData.payer_id}}</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<p>开户银行：</p>
										<p>{{detailData.bank_name}}</p>
									</div>
									<div class="col-xs-6">
										<p>银行账号：</p>
										<p>{{detailData.bank_account_number}}</p>
									</div>

								</div>
								<div class="row">
									<div class="col-xs-6">
										<p>地址：</p>
										<p>{{detailData.address}}</p>
									</div>
									<div class="col-xs-6">
										<p>电话：</p>
										<p>{{detailData.tel}}</p>
									</div>
								</div>
							</div>
							<div class="title">其他信息</div>
							<div class="container">
								<div class="row">
									<div class="col-xs-6">
										<p>创建时间：</p>
										<p>{{detailData.add_time}}</p>
									</div>
									<div class="col-xs-6">
										<p>创建人：</p>
										<p>{{detailData.realname}}</p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<p>最近更新：</p>
										<p>{{detailData.update_time}}</p>
									</div>
									<div class="col-xs-6">
										<p>操作人：</p>
										<p>{{detailData.update_realname}}</p>
									</div>

								</div>
							</div>
						</div>
						<div class="hetong" v-show="activeIndex == 2">
							<div class="container">
								<div class="col-xs-6" v-for="(item,key) in detailData.contract_list">
									<div class="row">
										<p class="p1">合同编号：</p>
										<p class="p2">{{item.contract_number}}</p>
									</div>
									<div class="row">
										<p class="p1">合同名称：</p>
										<p class="p2 mc">{{item.contract_name}}</p>
									</div>
									<div class="row">
										<p class="p1">合同日期：</p>
										<p class="p2">{{item.contract_date}}</p>
									</div>
									<div class="row">
										<p class="p1">合同金额：</p>
										<p class="p2">{{item.contract_money | numberFormat}}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
        <editCustomer @sendEditData="hideAll" @hideModel="hideEdit" :editData="detailData" v-show="showEditcustom"></editCustomer>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../../config/config.js'
    import editCustomer from './editCustomer/editCustomer.vue'
	export default{
		data(){
			return {
				host,
				imghost,
                detailData:{},
                activeIndex : 1,
                showEditcustom : false,
			}
		},
        props:{id:{type:String}},
        components: {
            editCustomer,
        },
        mounted(){
            this.initData()
        },
        methods:{
            initData(){
                this.$http('POST','/custom/get_custom_info.php',{'custom_id':this.id}).then(res=>{
                    this.detailData = res.data
                }).catch(err=>{
                
                })
            },
            changeIndex(index){
                this.activeIndex = index
            },
            closeDetail(){
                this.$emit('closeDetail')
            },
            del_customer(){
                let arr = [];
                arr.push(this.id)
                let ids = JSON.stringify(arr);
                if(ids != []){
                    this.$http('POST','/custom/delete_custom.php',{custom_id:ids}).then(res=>{
                        if(res.code == 0){
                            this.$emit('closeDetail',res.data)
                        }
                    }).catch(err=>{
            
                    })
                }
            },
            showEdit(){
                this.showEditcustom = true;
            },
            hideEdit(){
                this.showEditcustom = false
            },
            hideAll(val){
                this.showEditcustom = false
                this.$emit('hideAll',val)
            }
        },
        watch:{
            id(){
            }
        }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../../assets/main";
	.khbh {
		width: 300px;
	}
	.date {
		width: 180px;
	}
	.xiangxi {
		overflow: auto;
		.title {
			padding-left: 30px;
			background: $danlanColor;
			line-height: 34px;
			font-size: 16px;
		}
		.container {
			padding: 5px 0 10px;
			overflow: hidden;
			.row {
				height: 28px;
				.col-xs-6 {
					padding-left: 30px;
					p {
						float: left;
						line-height: 28px;
					}
					p:first-child {
						width: 30%;
						color: #5a6879;
					}
					p:nth-child(2) {
						width: 70%;
						color: #1f2a44;
					}
				}
			}
		}
	}
	.hetong {
		overflow: hidden;
		.container {
			overflow: hidden;
			border-bottom: 1px dashed #dbe2ee;
			.col-xs-6 {
				padding: 10px;
				.row {
					line-height: 28px;
					p {
						float: left;
						line-height: 28px;
					}
					.p1 {
						width: 80px;
						color: #5a6879;
					}
					.p2 {
						width: 245px;
						color: #1f2a44;
					}
					.mc {
						color: $mainColor;
					}
				}
			}
		}
		.container:last-child {
			border: 0;
		}
	}
 
</style>
