<template>
	<div>
		<div class="contract confirm">
	        <div class="container-fluid">
	        	<div class="top">已确认到账，补充回款信息：</div>
	            <div class="container">
	                <div class="row">
	                    <div class="col-xs-3"><span>*</span>结算方式</div>
	                    <div class="col-xs-9">
	                        <select v-model="data.payment_id">
	                            <option value="1">现金</option>
	                            <option value="2">支票</option>
	                            <option value="3">银行转账</option>
	                            <option value="4">其他</option>
	                        </select>
	                        <i class="icon iconfont">&#xe681;</i>
	                    </div>
	                </div>
	            </div>
	            <div class="container">
	                <div class="row">
	                    <div class="col-xs-3">单据编号</div>
	                    <div class="col-xs-9">
	                        <input type="text" value="" placeholder="请输入单据编号" v-model="data.number" />
	                    </div>
	                </div>
	            </div>
	            <div class="container">
	                <div class="row">
	                    <div class="col-xs-3">备注</div>
	                    <div class="col-xs-9"><input type="text" placeholder="30字以内备注信息"  v-model="data.remark"/></div>
	                </div>
	            </div>
	            <div class="container">
	                <div class="row">
	                    <div class="col-xs-3">附件</div>
	                    <div class="col-xs-9">
	                        <input type="file" multiple="true" accept="image/png,image/gif,image/jpeg" @change="update">
	                        <i class="icon iconfont">&#xe692;</i>
	                        <div class="file" v-show="true">
                                <div class="col-xs-4" v-for="(item,key) in filesData">
                                    <div>
                                        <img :src="item.thumb"/>
                                        <i class="icon iconfont" @click="delImg(key)">&#xe60a;</i>
                                    </div>
                                </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <div class="btn">
	        	<button @click="subdaozhang">确定</button>
	        </div>
		</div>
	
	</div>
</template>
<script>
	import {host, imghost} from '../../../../../config/config.js'
	export default{
		data(){
			return {
				host,
				imghost,
				data:{payment_id:1},
                filesData:[],
			}
		},
		methods:{
            update(e){
                let files = e.target.files;
                for (let i = 0; i < files.length; i++) {
                    files[i].thumb = URL.createObjectURL(files[i])
                    this.filesData.push(files[i])
                }
            },//预览图片
            delImg(key){
                this.filesData.splice(key, 1)
            },//删除图片
            subdaozhang(){

            	var newForm = new FormData()
                for(let key in this.data){
                    newForm.append(key,this.data[key])
                }
                if (this.filesData && this.filesData.length > 0) {
                    for (let i = 0; i < this.filesData.length; i++) {
                        newForm.append("image" + i, this.filesData[i])
                    }
                }
                newForm.append('forid',this.$route.params.id)
                newForm.append('is_arrival',1)

                this.$http('FORM', '/receivables/financial_confirmation.php',newForm).then(res => {
                    if(res.code==0){
                        this.$router.go(-2)
                    }else {
                        alert(res.msg)
                    }
                })
            }
        }
	}
</script>
<style lang="scss" scoped>
	@import "../../../../../assets/main.scss";
	
	.confirm {
		.container-fluid {
			margin-bottom: 2rem;
			.top {
				padding: 0.5rem;
				background: #f3f6f9;
				color: #121213;

			}
		}
	}
</style>
