<template>
	<div>
		<div class="centerModal htbqModal">
			<div class="modalInner selectLabels">
				<div class="header">
					<h3>合同标签</h3>
					<i class="icon iconfont" @click="closeSelectLabel">&#xe60f;</i>
				</div>
				<div class="body">
					<div class="labels">
						<div class="items" v-for="item,key in labelsMap" @click="chooseLabelInfo(key,item.id,item.label_name)">
							<span :class="{'active': isChooseStatus(item.id)}">{{item.label_name}}</span>
						</div>
						<div class="items add">
							<span @click="addLabel">+添加</span>
						</div>
						<div class="items" v-if="showInput">
							<input type="text" placeholder="5字以内~" ref="labelName"><span class="jia" @click="addLabels"><i class="icon iconfont">&#xe63a;</i></span>
						</div>
					</div>
				</div>
				<div class="footer">
					<button class="btn cancel" @click="closeSelectLabel">取消</button>
					<button class="btn confirm" @click="chooseLabels">确定</button>
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
				labelsMap:[],
				labelName:[],
				labelId:[],
				aa:[],
				showActive:false,
				showInput:false
			}
		},
		mounted(){
		    this.getLabels()
        },
		methods:{
			//获取客户列表
			getLabels(){
				this.$http("GET",'/contract/get_contract_label.php').then(res=>{

					this.labelsMap = res.data

				}).catch(err => {
                
                })
			},
			//关闭
			closeSelectLabel(){
				this.labelId = []
				this.labelName = []
				this.$emit('closeSelectLabelss')
			},
			//发送至夫集组件
			chooseLabels(){

				let sendObj = {
					'label_id':this.labelId,
					'label_name':this.labelName
				}
				
				this.$emit('ChoosedLabels',JSON.stringify(sendObj))
			
			},
			//合同标签显示
            addLabel(){
			    this.showInput = true
            },
            //添加合同标签
            addLabels(){
            	let labelName = this.$refs.labelName.value

            	this.$http("POST",'contract/add_contract_label.php',{label_name:labelName}).then(res=>{
            		if(res.code==0)
            		{
            			this.showInput = false
            			this.labelsMap = res.data
            		}
            	}).catch(err=>{

            	})
            },
			//选择合同标签
			chooseLabelInfo(key,id,name){
				
				let index = -1

				for(let i=0;i<this.labelId.length;i++)
				{
					if(this.labelId[i]==id)
					{
						index = i
					}
				}
				if(index == -1)
				{
					this.labelId.push(id)
					this.labelName.push(name)
				}else{
					this.labelId.splice(index,1)
					this.labelName.splice(index,1)
				}
				// console.log(this.labelId)
			},
			//判断是否选中的状态
			isChooseStatus(id){
				
				if(this.labelId.length>0){
					
					for(let i =0;i<this.labelId.length;i++)
					{

						if(this.labelId[i]==id)
						{
							
							return true
						}

					}
					return false
				}
			},
		}

	}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
	@import "../../assets/main.scss";
	.centerModal {
	   .selectLabels {
	   		margin: 150px auto 0;
	   		width: 450px;
	   		.body {
	   			min-height: 200px;
	   			.labels {
					padding: 20px;
					overflow: hidden;
					.items {
						float: left;
						margin: 8px;
						span {
							display: inline-block;
							padding: 2px 8px;
							border: $iptBorder;
							color: $huiColor;
							cursor: pointer;
						}
						.active {
							background: $mainColor;
							color: #fff;
       
						}
						input {
							width: 78px;
							padding: 0 6px;
							height: 22px;
							color: #121827;
							border: $borderStyle;
						}
						.jia {
							padding: 0;
							width: 20px;
							line-height: 22px;
							text-align: center;
							height: 22px;
							background: #bfcbd9;
							color: #ffffff;
							border: 1px solid #bfcbd9;
							cursor: pointer;
							i {
								font-size: 14px;
							}
						}

					}
					.add {
						span {
							border: $lanBorder;
							color: $mainColor;
						}
					}

	   			}
	   		}
	   }
	}
</style>
