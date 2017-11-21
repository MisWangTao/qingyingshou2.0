<template>
	<div id="refundDetails">
		<div class="seal"><img :src="imghost+'tuikuan@2x.png'" alt="异常"></div>
		<div class="contract detail writeOff">
			<div class="container-fluid">
				<div class="title"><h4>退款信息</h4></div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">客户名称</div>
						<div class="col-xs-9">西安朋客信息科技有限公司</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">合同名称</div>
						<div class="col-xs-9">合同合同</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">退款金额</div>
						<div class="col-xs-9"><span class="red">￥56230</span></div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">退款日期</div>
						<div class="col-xs-9">2017-08-01</div>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="title">
					<h4>退款详情</h4>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">合同名称</div>
						<div class="col-xs-9">合同合同</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">合同金额</div>
						<div class="col-xs-9">￥56230.00</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">变更业务类型</div>
						<div class="col-xs-9">仅退款</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">变更原因说明</div>
						<div class="col-xs-9">备因出现质量问题，客户要求退还部分回款</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">变更日期</div>
						<div class="col-xs-9">2017-02-12</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">备注</div>
						<div class="col-xs-9">设备合同的备注信息，详细信息及内容说明，关于合同的备注信息</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-xs-3">附件</div>
						<div class="col-xs-9">
							<div class="file">
								<div class="col-xs-4">
									<div>
										<img :src="imghost+'wp2.jpg'"/>
									</div>
								</div>
								<div class="col-xs-4">
									<div>
										<img :src="imghost+'wp2.jpg'"/>
									</div>
								</div>
								<div class="col-xs-4">
									<div>
										<img :src="imghost+'wp2.jpg'"/>
									</div>
								</div>
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
	export default{
		data(){
			return{
				host,
				imghost,
				searchVal : ''
			}
		},
		components: {
			searchInput,
		},
		methods:{
			search(val){
				this.searchVal = val
			}
		}
	}
</script>
<style lang="scss" scoped>
	@import "../../../../assets/main";
	#refundDetails{
		.seal {
			position: absolute;
			top: 16%;
			left: 40%;
			width: 6rem;
			z-index: 2;
			opacity: 0.8;
			img {
				width: 100%;
			}
		}
		.title {
			background: $bgColor;
		}
	}
</style>
