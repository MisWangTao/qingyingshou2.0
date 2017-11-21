<template>
	<div>
		<div class="centerModal bctkxxModal">
			<div class="modalInner">
				<div class="header">
					<h3>补充退款信息</h3>
					<i @click="closeTrue" class="icon iconfont">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="tishi">已确认{{change_info.send_realname}}发来的合同：<span class="lan">{{contract_info.contract_name}}</span>的变更信息，确认通过：</div>
					<div class="row">
						<div class="col-xs-3"><span>*</span>结算方式</div>
						<div class="col-xs-9">
							<select v-model="buchongData.paymethod_id">
								<option value="1">现金</option>
								<option value="2">银行账号</option>
								<option value="3">支票</option>
								<option value="4">其他</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">收据编号</div>
						<div class="col-xs-9">
							<input v-model="buchongData.pay_number" type="text" value="">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">备注</div>
						<div class="col-xs-9">
							<input v-model="buchongData.remark" type="text" value="">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">附件</div>
						<div class="col-xs-9 file">
                            <table v-show="files.length>0">
                                <thead>
                                <tr>
                                    <th>文件名称</th>
                                    <th>文件大小</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item,key in files">
                                    <td>{{item.name}}</td>
                                    <td>{{item.size}}</td>
                                    <td>
                                        <i class="icon iconfont yulan" @click="yulan(key)">&#xe660;</i>
                                        <i class="icon iconfont xiazai">&#xe62a;</i>
                                        <i class="icon iconfont dele" @click="delImg(key)">&#xe612;</i>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="upload"><p>+点击添加附件</p>
                                <input type="file" ref="files" multiple="true"
                                       accept="image/png,image/gif,image/jpeg" @change="upload"/></div>
						</div>
					</div>
				</div>
				<div class="footer">
					<button @click="closeTrue" class="btn cancel">取消</button>
					<button @click="sendData" class="btn confirm">确定</button>
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
                buchongData:{
				    paymethod_id:1
                },
                files:[],
			}
		},
        mounted(){
		    this.I(this.change_info)
		    this.I(this.contract_info)
        },
        props:['change_info','contract_info','message','newsId'],
        methods:{
            closeTrue(){
                this.$emit('closeTrue')
            },
            upload(e){
                let files = e.target.files
                // let nowFiles = this.newContract.files ? this.newContract.files : []
                for (let i = 0; i < files.length; i++) {
                    this.files.push(files[i])
                }
                // console.log(this.yulanFiles)
                // console.log(this.fileMap)
            },
            sendData(){
                let newForm = new FormData()
                if (this.files && this.files.length > 0) {
                    for (let i = 0; i < this.files.length; i++) {
                        if (this.files[i].type) {
                            newForm.append("image" + i, this.files[i])
                        } else {
                            oldArr.push(this.host + this.files[i].src)
                        }
                    }
                }
                let change_id = this.change_info.id
                let news_id = this.newsId
                let payment_method = this.buchongData.paymethod_id
                let number = this.buchongData.pay_number
                let remark = this.buchongData.remark
                let message = this.message
                newForm.append('change_id', change_id)
                newForm.append('news_id', news_id)
                newForm.append('payment_method', payment_method)
                newForm.append('number', number)
                newForm.append('remark', remark)
                newForm.append('message', message)
                this.$http('FORM','/change/biangeng_examine.php',newForm).then(res=>{
                    if(res.code == 0){
                        this.$emit('closeTrue',2)
                    }
                }).catch(err=>{
                
                })
            },
            //预览图片
            yulan(key){
        
            },
            //删除图片
            delImg(key){
                this.files.splice(key, 1)
            },
        }
	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main.scss";
	.centerModal {
		z-index: 20;
		.modalInner {
			margin: 180px auto 0;
			width: 520px;
			.body {
				.tishi {
					padding: 15px 20px 20px;
					color: #5a6879;
					.jine {
						margin: 0 5px;
					}
					.lan {
						color: $mainColor;
					}
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
						span {
							margin-right: 4px;
							color: $redColor;

						}
					}
					.col-xs-9 {
						input,select {
							padding: 0 10px;
							width: 320px;
							height: 30px;
							color: #121827;
							border: $borderStyle;
							border-radius: 3px;
						}
						select {
							width: 340px;
						}
						table {
							margin-bottom: 10px;
							width: 342px;
							border: $borderStyle;
							border-collapse:collapse;
							thead {
								background: #eef1f6;
								tr {
									th{
										white-space: nowrap;
										font-weight: normal;
										text-align: center;
										border: $borderStyle;
										padding: 6px;
									}
								}
							}
							tbody {
								tr{
									td {
										text-align: center;
										border: $borderStyle;
										padding: 6px 12px;
										i {
											font-size: 16px;
											cursor: pointer;
										}
										.yulan {
											font-size: 12px;
											color: $huiColor;
										}
										.xiazai {
											font-size: 14px;
											color: $mainColor;
										}
										.dele {
											font-size: 14px;
											color: $redColor;
										}
									}
								}
							}
						}
						.upload {
							width: 100%;
							height: 32px;
							position: relative;
							input[type="file"] {
								position: absolute;
								top: 0;
								left: 0;
								width: 90%;
								border: 1px dashed #dbe2ee;
								opacity: 0;
							}
							p {
								
								width: 340px;
								border: 1px dashed #dbe2ee;
								height: 30px;
								text-align: center;
								line-height: 32px;
								color: $huiColor;
							}
						}
					}
				}
			}
		}
	}

</style>
