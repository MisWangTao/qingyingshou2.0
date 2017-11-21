<template>
	<div>
		<div class="top">
			<ul class="left">
				<li>西安朋客信息科技有限公司</li>
				<li>2017-08-09 星期三</li>
			</ul>
			<ul class="right">
				<li class="li1">
					<img :src="imghost+'/top/talk@2x.png'" alt="">
					<span>1</span>
				</li>
				<li class="li2" @click="shownewslist">
					<img :src="imghost+'/top/message@2x.png'" alt="">
					<span>1</span>
				</li>
				<li class="li3">
					<i class="icon iconfont">&#xe68e;</i>
				</li>
				<li class="li4">
					<img :src="imghost+'/logo_defaullt@2x.png'" alt="">
				</li>
				<li class="li5">
					<select>
						<option>庞凯</option>
						<option>刘嘉欢</option>
						<option>王涛</option>
						<option>惠凶冰</option>
						<option>张晓涵</option>
					</select>
				</li>
			</ul>
		</div>
		<news v-if="shownews" @closenewslist="closenewslist"></news>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../config/config.js'
	import news from './news/news.vue'
	import axios from 'axios'
	export default{
		data(){
			return {
				host,
				imghost,
				shownews:false
			}
		},
		components: {
            news
        },
        methods:{
        	shownewslist(){
        		this.shownews  = true
        	},
        	closenewslist(){
        		this.shownews = false
        	}
        }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main.scss";
	
	.top {
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 70px;
		z-index: 29;
		background: $menuBg;
		.left {
			margin-left: 200px;
			float: left;
			color: #ffffff;
			padding: 26px 0;
			li {
				padding: 0 15px;
				float: left;
				height: 14px;
				line-height: 14px;
				border-right: 1px solid #fff;
				font-size: 14px;
			}
			li:last-child {
				border: 0;
			}
		}
		.right {
			height: 70px;
			float: right;
			margin-right: 30px;
			li {
				margin: 0 5px;
				padding: 0 10px;
				height: 70px;
				float: left;
				color: $baiColor;
				cursor: pointer;
			}
			.li1 {
				position: relative;
				img {
					display: block;
					margin-top: 24px;
					width: 20px;
				}
				span {
					display: block;
					position: absolute;
					top: 15px;
					right: 0;
					width: 18px;
					height: 18px;
					background: $redColor;
					border-radius: 50%;
					color: #ffffff;
					font-size: 12px;
					line-height: 18px;
					text-align: center;
				}
			}
			.li2 {
				position: relative;

				img {
					display: block;
					margin-top: 24px;
					width: 18px;
				}
				span {
					display: block;
					position: absolute;
					top: 15px;
					right: 0;
					width: 18px;
					height: 18px;
					background: $redColor;
					border-radius: 50%;
					color: #ffffff;
					font-size: 12px;
					line-height: 18px;
					text-align: center;
				}
			}
			.li3 {

				line-height: 60px;
				i {
					font-size: 20px;
				}
			}
			.li4 {
				img {
					display: block;
					margin-top: 12px;
					width: 36px;
					height: 36px;
					border-radius: 50%;
				}
			}
			.li5 {
				line-height: 60px;
				
				select {
					width: 80px;
					border: 0;
					background: $menuBg;
					color: #f5f5f5;
					option {
						background: $menuBg;
						line-height: 28px;
					}

				}
			}
			li:hover {
				background: #080e26;
			}
			.li4:hover,.li5:hover {
				background: $menuBg;
			}
		}
	}
</style>
