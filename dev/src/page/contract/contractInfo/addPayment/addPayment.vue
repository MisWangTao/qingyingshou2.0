<template>
    <div class="contract">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同金额</div>
                    <div class="col-xs-9">
                        <input type="text"  v-model="data.plan_money">
                        <span class="bizhong" v-if="this.contract.currency_id">{{this.contract.ab}}</span>
                        <span class="bizhong" v-else @click="getcurrencylist">{{this.checkedcurrency.ab}}</span>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">计划收款时间</div>
                    <div class="col-xs-9">
                        <input type="date" v-model="data.plan_date">
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">备注</div>
                    <div class="col-xs-9"><textarea v-model="data.plan_remark"></textarea></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">附件</div>
                    <div class="col-xs-9">
                        <input type="file" multiple="true" accept="image/png,image/gif,image/jpeg" @change="update">
                        <i class="icon iconfont">&#xe692;</i>
                        <div class="file">
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
        <div class="container-fluid">
        	<div class="container">
        	<div class="row">
    			<div class="col-xs-3">到期提醒</div>
		            <div class="col-xs-9 switch">
		                提前
                            <select v-model="contract.advance_remind">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                            </select>
                        天
		                <input type="checkbox" name=""  v-model="contract.expiration_reminder" />
		                <img v-show="!contract.expiration_reminder" :src="imghost+'switch_off@2x.png'" alt="">
		                <!-- 打开显示图片 -->
		                <img v-show="contract.expiration_reminder" :src="imghost+'switch_on@2x.png'" alt="">
		            </div>
	           </div>
        	</div>
        </div>
        <div class="btn" @click="subadd">
            <button>确定</button>
        </div>


        <!-- 选择货币种类部分 -->
        <div class="zhezhao" v-show="showchoosecurrency"></div>
        <div class="currency" v-show="showchoosecurrency">
            <ul>
                <li class="active" v-for="item,key in currency" @click="chooseCurrency(item)">
                    <img :src="imghost+'/currency/'+item.ab+'@2x.png'" title="item.ab" />
                    <i v-show="item.id == checkedcurrency.id" class="icon iconfont">&#xe614;</i>
                </li>
            </ul>
        </div>
        
    
    </div>
</template>
<script>
    import {host, imghost} from '../../../../config/config.js'
    export default{
        data(){
            return {
                host,
                imghost,
                showchoosecurrency:false,
                currency: [],
                checkedcurrency:{'id':1,'ab':'CNY'},
                contract:{},
                data:{},
                filesData:[],
            }
        },
        mounted(){
            
            this.inidata()
        },
        methods:{
            chooseCurrency(item){

                const _this = this
                this.checkedcurrency = item
                setTimeout( () => _this.showchoosecurrency = false,200)
            },
            inidata(){

                this.$http('POST','/paymentPlan/get_plan_contract.php',{id:this.$route.params.id}).then( res => {
                    this.contract = res.data
                })
            },
            getcurrencylist(){

                if(!this.contract.currency_id){
                    this.$http('GET', '/currency/get_currency_list.php').then( res => {
                        this.currency = res.data
                        this.showchoosecurrency = true
                    })
                }
                
            },
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
            subadd(){
                let newForm = new FormData()
                if(this.filesData.length>0){
                    for(let i=0; i<this.filesData.length; i++){
                        newForm.append("image" + i, this.filesData[i])
                    }
                }
                newForm.append('contract_id',this.$route.params.id)
                newForm.append('advance_remind',this.contract.advance_remind)
                newForm.append('expiration_reminder',Number(this.contract.expiration_reminder))
                newForm.append('returnPlan',JSON.stringify(this.data))
                newForm.append('currentcy_id',JSON.stringify(this.checkedcurrency.id))
                this.$http("FORM", 'paymentPlan/add_plan.php' ,newForm).then(res => {
                    alert(res.msg)
                })
            },
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../../assets/main.scss";
    .contract {
    	.container-fluid {
			.switch {
                position: relative;
                input {
                    top: 0;
                    right: 0.5rem;
                    width: 60px;
                    height: 0.8rem;
                    position: absolute;
                    z-index: 12;
                    opacity: 0;
                }
                img {
                    position: absolute;
                    top: 0;
                    right: 0.5rem;
                    z-index: 10;
                    width: 2rem;
                    
                }
            }
    	}
    }
    .currency {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 9.34rem;
        z-index: 33;
        background: $baiColor;
        overflow: auto;
        ul {
            padding: 0 10px;
            li {
                padding: 0.3rem 0.5rem;
                border-bottom: $qianStyle;
                img {
                    max-width: 5rem;
                }
                i {
                    display: none;
                    float: right;
                    font-size: 1.2rem;
                }
            }
            .active {
                i {
                    display: block;
                }
            }
        }
    }
</style>
