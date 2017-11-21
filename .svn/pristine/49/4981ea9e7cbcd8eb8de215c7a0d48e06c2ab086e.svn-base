<template>
	<div>
		<div class="menu">
			<div class="logo">
				<img class="img2" :src="imghost+'logo@2x.png'" alt="">
				<i class="icon iconfont">&#xe606;</i>
			</div>
			<ul>
				<router-link tag="li" active-class="active" to="/home">
				   <img class="img2" :src="imghost+'/menu/Home@2x.png'" alt=""> 首页
				</router-link>
				<router-link tag="li" active-class="active" to="/contract">
				   <img class="img2" :src="imghost+'/menu/hetong@2x.png'" alt=""> 合同管理
				</router-link>
				<router-link tag="li" active-class="active" to="/customer">
				   <img class="img2" :src="imghost+'/menu/kehu.png'" alt=""> 客户管理
				</router-link>
				<router-link tag="li" active-class="active" to="/payment">
				   <img class="img2" :src="imghost+'/menu/kehu.png'" alt=""> 回款管理
				</router-link>
			</ul>
		</div>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../config/config.js'
	import axios from 'axios'
	export default{
		data(){
			return {
				host,
				imghost,
			}
		},
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main.scss";
	
	.menu {
		position: fixed;
		top: 0;
		left: 0;
		width: 150px;
		height: 100%;
		z-index: 30;
		background: $menuBg;
		.logo {
			height: 70px;
			img {
				vertical-align: top;
				margin: 19px 0 0 5px;
			}
			i {
				margin-top: 24px;
				color: #b1b6c4;
				font-size: 24px;
				float: right;
			}
		}
		ul {
			li {
				margin: 0 0 30px;
				padding: 10px 0 10px 20px;
				color: #ffffff;
				font-size: 14px;
				cursor: pointer;
				img {
					margin-right: 5px;
					vertical-align: middle;
				}
			}
			li:first-child {
				img {
					width: 17px;
				}
			}
			li:nth-child(2) {
				img {
					margin-left: 2px;
					width: 15px;
				}
			}
			li:nth-child(3) {
				img {
					width: 16px;
				}
			}
			.active {
				border-left: 4px solid $mainColor;
				background: #080e26;
			}
		}
	}
</style>
