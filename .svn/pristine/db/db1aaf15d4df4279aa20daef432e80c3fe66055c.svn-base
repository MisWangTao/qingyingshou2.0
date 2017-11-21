<template>
    <div class="newReceivable">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>客户名称</div>
                    <router-link to="/selectCustomer" class="col-xs-9">
                        <input type="text" v-model="selectCustomer.customName" disabled placeholder="请选择客户" value="">
                        <i class="icon iconfont">&#xe681;</i>
                    </router-link>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>结算方式</div>
                    <div class="col-xs-9">
                        <!-- <input type="text" v-model="newReceivable.paymethodsName" disabled placeholder="请选择结算方式" value=""> -->
                        <select v-model="newReceivable.paymethodsId">
                            <option value="1">现金</option>
                            <option value="2">支票</option>
                            <option value="3">银行转账</option>
                            <option value="4">其他</option>
                        </select>
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
<!--             <div class="container">
                <div class="row">
                    <div class="col-xs-3">账号</div>
                    <div class="col-xs-9"><input v-model="newReceivable.accountNum" type="text" placeholder="请输入账号" value="">
                    </div>
                
                </div>
            </div> -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>回款金额</div>
                    <div class="col-xs-9">
                        <input type="number" v-model="newReceivable.accountNum" placeholder="请输入回款金额">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>回款日期</div>
                    <div class="col-xs-9">
                        <input type="date" value="" v-model="newReceivable.date" placeholder="请选择回款日期">
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">收据编号</div>
                    <div class="col-xs-9">
                        <input type="text" v-model="newReceivable.bianhao" placeholder="请输入收据编号" value="">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">备注</div>
                    <div class="col-xs-9"><textarea placeholder="请输入备注" v-model="newReceivable.remark">备注备注</textarea></div>
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
                                    <img :src="item"/>
                                    <i class="icon iconfont" @click="delImg(key)">&#xe60a;</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn">
            <button @click="saveData('/writeOff')">确定</button>
            <p @click="saveData('/paymentManage')">保存到回款列表</p>
        </div>
    
    
    </div>
</template>
<script>
    import {host, imghost} from '../../config/config.js'
    import {mapState, mapMutations} from 'vuex'
    import ccl from '../../common/ccl.js'
    export default{
        data(){
            return {
                host,
                imghost,
                filesData: []
            }
        },
        computed: {
            ...mapState([
                'newReceivable','selectCustomer'
            ])
        },
        methods: {
            ...mapMutations([
                'SETRECEDATA'
            ]),
            update(e){
                let files = e.target.files;
                let nowFiles = this.newReceivable.files ? this.newReceivable.files : [];
                for (let i = 0; i < files.length; i++) {
                    this.filesData.push(URL.createObjectURL(files[i]))
                    nowFiles.push(files[i])
                }
                let newObj = this.newReceivable
                newObj.files = nowFiles;
                this.SETRECEDATA(newObj)
            },//预览图片
            delImg(key){
                let newObj = this.newReceivable
                newObj.files.splice(key, 1)
                this.filesData.splice(key, 1)
                this.SETRECEDATA(newObj)
            },//删除图片
            saveData(page){
                let objData = this.newReceivable;
                if(this.selectCustomer.customId == '' || this.selectCustomer.customName == undefined){
                    ccl.alert({
                        text: '客户名称不能为空'
                    });
                    return;
                }
               /* if(objData.paymethodsId == '' || objData.paymethodsId == undefined){
                    ccl.alert({
                        text: '结算方式不能为空'
                    });
                    return;
                }*/
                if(objData.accountNum == '' || objData.accountNum == undefined){
                    ccl.alert({
                        text: '回款金额不能为空'
                    });
                    return;
                }
                if(objData.date == '' || objData.date == undefined){
                    ccl.alert({
                        text: '回款日期不能为空'
                    });
                    return;
                }
                let custom_id = this.selectCustomer.customId ? this.selectCustomer.customId : '';
                let payment = objData.paymethodsId ? objData.paymethodsId : '1';
                let arrival_amount = objData.accountNum ? objData.accountNum : '';
                let arrival_date = objData.date ? objData.date : '';
                let bill = objData.bianhao ? objData.bianhao : '';
                let remark = objData.remark ? objData.remark : '';
    
                let newForm = new FormData()
                if (objData.files && objData.files.length > 0) {
                    for (let i = 0; i < objData.files.length; i++) {
                        newForm.append("image" + i, objData.files[i])
                    }
                }
                newForm.append('custom_id', custom_id)
                newForm.append('payment', payment)
                newForm.append('arrival_amount', arrival_amount)
                newForm.append('arrival_date', arrival_date)
                newForm.append('bill', bill)
                newForm.append('remark', remark)
                
                let _this = this;
                this.$http('FORM', '/receivables/add_receivable.php', newForm).then(res => {
                    if(res.code == 0){
                        _this.$router.push({
                            path:page,
                            query:{
                                custom_id:res.data.custom_id,
                                rece_id:res.data.rece_id
                            },
                        })
                    }
                }).catch(err => {
                    this.I(err)
                })
            },//保存数据
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../assets/main.scss";

</style>
