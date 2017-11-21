<template>
	<div>
		<div class="centerModal fgsModal">
			<div class="modalInner">
				<div class="header">
					<h3>发给谁</h3>
					<i class="icon iconfont" @click="closetoPerson">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="person active" v-for="item,key in financelist" @click="checkuser(item)">
						<img v-if="item.ding_avatar" :src="item.ding_avatar" alt="">
						<img v-else :src="imghost+'/logo_defaullt@2x.png'" alt="">
						<p>{{item.realname}}</p>
						<span v-show="item.id==checkeduser.id">
							<i class="icon iconfont">&#xe614;</i>
						</span>
					</div>

				</div>
				<div class="footer">
					<button class="btn cancel" @click="closetoPerson">取消</button>
					<button class="btn confirm" @click="subcheckeduser">确定</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../config/config.js'
	export default{
		data(){
			return {
				host,
				imghost,
				financelist:[],
				checkeduser:{}
			}
		},
		mounted(){
			this.iniData()
		},
		methods:{
			iniData(){
				this.$http('GET','/receivables/get_finance_list.php').then( res => {
					this.financelist  = res.data
				})
			},
			closetoPerson(){
				this.$emit('closetoPerson')
			},
			checkuser(user){
			    this.I(user)
				this.checkeduser = user
			},
			subcheckeduser(){
				this.$emit('subcheckeduser',this.checkeduser)
			}
		}

	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main.scss";
	.centerModal {
		.modalInner {
			margin: 180px auto 0;
			width: 520px;
			.body {
				padding: 30px 50px;
				min-height: 180px;
				.person {
					margin: 0 12px;
					padding: 10px;
					float: left;
					text-align: center;
					position: relative;
					cursor: pointer;
					img {
						display: inline-block;
						width: 60px;
						height: 60px;
						border-radius: 50%;
					}
					p {
						line-height: 26px;
						font-size: 14px;
						color: #000000;
					}
					span {
						display: none;
						position: absolute;
						top: 10px;
						left: 10px;
						width: 60px;
						height: 60px;
						border-radius: 50%;
						background: $mainColor;
						opacity: 0.35;
						line-height: 60px;
						text-align: center;
						i {
							font-size: 44px;
							color: $baiColor;
						}
					}
				}
				.active {
					span {
						display: block;
					}
				}
			}
		}
	}

</style>
