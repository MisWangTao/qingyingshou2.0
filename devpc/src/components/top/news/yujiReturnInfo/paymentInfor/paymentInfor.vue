<template>
	<div>
		<div class="centerModal bchkxxModal">
			<div class="modalInner">
				<div class="header">
					<h3>补充回款信息</h3>
					<i class="icon iconfont" @click="closepaymentInfor">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="tishi">已确认预计回款信息，补充回款信息：</div>
					<div class="row">
						<div class="col-xs-3"><span>*</span>结算方式</div>
						<div class="col-xs-9">
							<select v-model="data.payment_id">
								<option value="1">现金</option>
	                            <option value="2">支票</option>
	                            <option value="3">银行转账</option>
	                            <option value="4">其他</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">收据编号</div>
						<div class="col-xs-9">
							<input type="text" value="" v-model="data.number">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">备注</div>
						<div class="col-xs-9">
							<input type="text" value="" v-model="data.remark">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3">附件</div>
						<div class="col-xs-9 file">
                            <table v-show="filesData.length>0">
                                <thead>
                                <tr>
                                    <th>文件名称</th>
                                    <th>文件大小</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="item,key in filesData">
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
                                       accept="image/png,image/gif,image/jpeg" @change="upload"/>
                                <span>已选择{{filesData.length}}个文件</span>
                            </div>
							
						</div>
					</div>
				</div>
				<div class="footer">
					<button class="btn cancel"  @click="closepaymentInfor">取消</button>
					<button class="btn confirm" @click="sub">确定</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	import {mapState, mapMutations} from 'vuex'
	import {host, imghost} from '../../../../../config/config.js'
	export default{
		data(){
			return {
				host,
				imghost,
				data:{payment_id:1},
				filesData:[],
                yulanFiles : [],
			}
		},
		props:['id','newsId'],
		methods:{
			closepaymentInfor(){
				this.$emit('closepaymentInfor')
			},
            upload(e){
                let files = e.target.files
                // let nowFiles = this.editContract.files ? this.editContract.files : []
                for (let i = 0; i < files.length; i++) {
                    this.filesData.push(files[i])
                    this.yulanFiles.push(URL.createObjectURL(files[i]))
                }
            },
            //预览图片
            yulan(key){
            
            },
            //删除图片
            delImg(key){
                this.filesData.splice(key, 1)
                this.yulanFiles.splice(key, 1)
            },
			sub(){

				let newForm = new FormData()
                for(let key in this.data){
                    newForm.append(key,this.data[key])
                }
                if (this.filesData && this.filesData.length > 0) {
                    for (let i = 0; i < this.filesData.length; i++) {
                        newForm.append("image" + i, this.filesData[i])
                    }
                }
                newForm.append('forid',this.id)
                newForm.append('is_arrival',1)

                this.$http('FORM', '/receivables/financial_confirmation.php',newForm).then(res => {
                    if(res.code==0){
                        this.$emit('closepaymentInfor')
                    }else {
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
			width: 520px;
			.body {
				.tishi {
					padding: 15px 50px 20px;
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
