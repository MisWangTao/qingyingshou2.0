<template>
	<div>
		<div class="centerModal yiyiModal">
			<div class="modalInner">
				<div class="header">
					<h3>我有异议</h3>
					<i class="icon iconfont" @click="closeobjection">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="objection">
						<div class="tishi">该回款信息已被他人认领，提出异议：</div>
						<div class="row">
							<div class="col-xs-3">补充说明</div>
							<div class="col-xs-9">
								<textarea v-model="str"></textarea>
							</div>
						</div>
						<div class="row">
	                        <div class="col-xs-3">发给谁</div>
	                        <div class="col-xs-9 person" @click="showtoperson">
	                        	<div class="img" v-if="senduser.id">
	                                <img v-if="senduser.ding_avatar" :src="senduser.ding_avatar" alt="">
                                    <img v-else :src="imghost+'logo_defaullt@2x.png'" alt="">
                                    <p>{{senduser.realname}}</p>
	                            </div>
                        	 	<div class="add" v-else>
	                                <i class="icon iconfont">&#xe602;</i>
                                    <p>点击添加</p>
	                            </div>
	                        </div>
		                 </div>	
		            </div>
				</div>
				<div class="footer">
					<button class="btn cancel" @click="closeobjection">取消</button>
					<button class="btn confirm" @click="subobjection">确定</button>
				</div>
			</div>
		</div>
		<toPerson v-show="isshowtoPerson" @closetoPerson="closetoPerson" @subcheckeduser="subcheckeduser"></toPerson>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../../../../config/config.js'
	import toPerson from '../../../../toPerson/toPerson.vue'
	export default{
		data(){
			return {
				host,
				imghost,
				isshowtoPerson:false,
				senduser:{},
				str:''
			}
		},
		components:{
			toPerson
		},
		props:['id','newsId'],
		methods:{
			closetoPerson(){
        		this.isshowtoPerson = false
        	},
        	subcheckeduser(user){
        		this.senduser = user
        		this.isshowtoPerson = false
        	},
        	showtoperson(){
        		this.isshowtoPerson = true
        	},
        	closeobjection(){
        		this.$emit('closeobjection')
        	},
        	subobjection(){

        		this.$http("POST", 'receivables/business_dissent.php',{newsid:this.newsId,reason:this.str}).then(res => {
            		if(res.code==0){
            			this.$emit('subobjection')
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
	@import "../../../../../assets/main.scss";
	.centerModal {
		.modalInner {
			margin: 180px auto 0;
			width: 480px;
			
			.body {
				min-height: 240px;
				.objection {
					.tishi {
						padding: 15px 54px;
						color: #000000;
					}
					.row {
						margin-bottom: 16px;
						padding: 0 20px;
						overflow: hidden;
						.col-xs-3 {
							padding: 0 20px 0 0;
							text-align: right;
							color: $huiColor;
							line-height: 32px;
						}
						.col-xs-9 {
							textarea {
								padding: 0 10px;
								width: 280px;
								height: 80px;
								color: #121827;
								border: $borderStyle;
								border-radius: 3px;
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
				}
			}
		}
	}

</style>
