<template>
    <div class="contract">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>合同名称</div>
                    <div class="col-xs-9"><input v-model="editContract.contract_name" placeholder="请输入合同名称" type="text"
                                                 value=""></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同编号</div>
                    <div class="col-xs-9"><input v-model="editContract.contract_number" placeholder="请输入合同编号"
                                                 type="text" value=""></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>客户名称</div>
                    <div class="col-xs-9" @click="selectCumter">
                        <input type="text" disabled v-model="selectCustomer.customName" value="西安朋客信息科技有限公司">
                        <i class="icon iconfont">&#xe681;</i></div>
                
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同标签</div>
                    <div class="col-xs-9 hetong" @click="chooseLabel">
                        <span v-for="(item,key) in editContract.label">{{item.label_name}}</span>
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">联系人</div>
                    <div class="col-xs-9"><input disabled v-model="editContract.linkman" type="text" value="吴彦祖"><i
                        class="icon iconfont">&#xe681;</i></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">联系电话</div>
                    <div class="col-xs-9"><input disabled v-model="editContract.tel" placeholder="" type="text"
                                                 value="186223566"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>跟进人</div>
                    <div class="col-xs-9 genjinren"  @click="showLinkmans">
                        <p><span>{{editContract.followusername}}</span><span>{{editContract.followdepartname}}</span>
                        </p>
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="display:block">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>合同日期</div>
                    <div class="col-xs-9"><input v-model="editContract.contract_date" type="date" value="2017-05-23"><i
                        class="icon iconfont">&#xe681;</i></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span v-show="editContract.contract_type!= 1">*</span>到期日期</div>
                    <div class="col-xs-9"><input v-model="editContract.maturity_date" type="date" value="2017-05-23"><i
                        class="icon iconfont">&#xe681;</i></div>
                </div>
            </div>
            <div class="container" v-show="editContract.contract_type == 1">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>合同金额</div>
                    <div class="col-xs-9"><input v-model="editContract.contract_money" placeholder="请输入合同金额" type="text"
                                                 value="560.00"><i class="icon iconfont">&#xe681;</i></div>
                </div>
            </div>
            <div class="container" v-show="editContract.contract_type == 3">
                <div class="row">
                    <div class="col-xs-3">预收款</div>
                    <div class="col-xs-9"><input type="text" v-model="editContract.advance_money" value=""><span class="bizhong">CNY</span>
                    </div>
                </div>
            </div>
            
            <div class="container" v-show="editContract.contract_type == 3">
                <div class="row">
                    <div class="col-xs-3">回款方式</div>
                    <div class="paymentMethod">
                        <select v-model="editContract.payment_type">
                            <option value="1">每月</option>
                            <option value="2">每季度</option>
                            <option value="3">每年</option>
                        </select>
                        <select v-show="editContract.payment_type == 3" v-model="editContract.each_month">
                            <option value="1">1月</option>
                            <option value="2">2月</option>
                            <option value="3">3月</option>
                            <option value="4">4月</option>
                            <option value="5">5月</option>
                            <option value="6">6月</option>
                            <option value="7">7月</option>
                            <option value="8">8月</option>
                            <option value="9">9月</option>
                            <option value="10">10月</option>
                            <option value="11">11月</option>
                            <option value="12">12月</option>
                        </select>
                        <select v-show="editContract.payment_type == 2" v-model="editContract.each_month">
                            <option value="1">第1个月</option>
                            <option value="2">第2个月</option>
                            <option value="3">第3个月</option>
                        </select>
                        <select v-model="editContract.each_day">
                            <option value="1">1日</option>
                            <option value="2">2日</option>
                            <option value="3">3日</option>
                            <option value="4">4日</option>
                            <option value="5">5日</option>
                            <option value="6">6日</option>
                            <option value="7">7日</option>
                            <option value="8">8日</option>
                            <option value="9">9日</option>
                            <option value="10">10日</option>
                            <option value="11">11日</option>
                            <option value="12">12日</option>
                            <option value="13">13日</option>
                            <option value="14">14日</option>
                            <option value="15">15日</option>
                            <option value="16">16日</option>
                            <option value="17">17日</option>
                            <option value="18">18日</option>
                            <option value="19">19日</option>
                            <option value="20">20日</option>
                            <option value="21">21日</option>
                            <option value="22">22日</option>
                            <option value="23">23日</option>
                            <option value="24">24日</option>
                            <option value="25">25日</option>
                            <option value="26">26日</option>
                            <option value="27">27日</option>
                            <option value="28">28日</option>
                            <option value="29">29日</option>
                            <option value="30">30日</option>
                            <option value="31">31日</option>
                        </select>
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
        
        </div>
    
        
        <div class="container-fluid" v-show="editContract.contract_type == 2">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>回款周期</div>
                    <div class="col-xs-9" @click="chooseZhouqi">
                        <input type="text" v-model="huizhouqiName" value="" disabled placeholder="请选择回款周期">
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>首次收款日期</div>
                    <div class="col-xs-9"><input type="date" v-model="editContract.first_date_payment"><i
                        class="icon iconfont">&#xe681;</i></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>每期金额</div>
                    <div class="col-xs-9"><input type="text" v-model="editContract.each_money"><i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="badge" v-show="editContract.contract_type == 2">
            <div class="col-xs-5">
                回款期数：<span>{{cycle}}期</span>
            </div>
            <div class="col-xs-7">
                合同金额：<span>{{editContract.each_money*cycle | numberFormat}}</span>
            </div>
        </div>
        <div class="container-fluid" v-show="editContract.contract_type == 2">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">周期提醒</div>
                    <div class="col-xs-9 switch">
						<span>
							提前
							<select class="select" name="" id="" v-model="editContract.advance_remind">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
							</select>
							天
						</span>
                        <input type="checkbox" @click="changeChecked" v-model="editContract.remindState" name=""
                               value=""/>
                        <img v-show="editContract.remindState == 0" :src="imghost+'switch_off@2x.png'" alt="">
                        <img v-show="editContract.remindState == 1" :src="imghost+'switch_on@2x.png'" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">备注</div>
                    <div class="col-xs-9"><textarea v-model="editContract.remark"></textarea></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">附件</div>
                    <div class="col-xs-9">
                        <input ref="files" multiple="true" accept="image/png,image/gif,image/jpeg" @change="update"
                               type="file"><i class="icon iconfont">&#xe692;</i>
                        <div class="file">
                            <div class="col-xs-4" v-for="(item,key) in filesData">
                                <div>
                                    <img :src="item" alt="">
                                    <i class="icon iconfont" @click="delImg(key)">&#xe60a;</i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn">
            <button @click="sendData">确定</button>
        </div>
        <!-- 选择跟进人部分弹框 -->
        <div class="modal" v-show="showLinkman">
            <div class="modalInner">
                <div class="modalHead">
                    <h4>选择跟进人</h4>
                    <i class="icon iconfont">&#xe60f;</i>
                </div>
                <div class="modalBody">
                    <div class="cont" v-for="(item,key) in linkManData">
                        <div class="title"><span></span><h4>{{item.depart_name}}</h4></div>
                        <div class="person">
                            <div class="col" v-for="(items,index) in item.users"
                                 @click="sureLinkman(item.depart_name,item.departId,items.userId,items.realname)">
                                <div class="imgs">
                                    <div class="img">
                                        <img :src="items.ding_avatar" alt="">
                                    </div>
                                </div>
                                <p>{{items.realname}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapState, mapMutations} from 'vuex'
    import {host, imghost} from '../../../config/config'
    import ccl from '../../../common/ccl.js'
    export default{
        data(){
            return {
                host,
                imghost,
                filesData: [],
                huizhouqiName : '',
                showLinkman : '',
                linkManData : [],
            }
        },
        computed: {
            ...mapState([
                'editContract', 'selectCustomer'
            ]),
            cycle(){
                let conDate = this.editContract.contract_date
                let arrDate = this.editContract.maturity_date
                let firstDate = this.editContract.first_date_payment
                if(arrDate>firstDate){
                    let aY = arrDate.slice(0,4)
                    let am = arrDate.slice(5,7)
                    let ad = arrDate.slice(-2)
                    let fY = firstDate.slice(0,4)
                    let fm = firstDate.slice(5,7)
                    let fd = firstDate.slice(-2)
                    
                    if(this.editContract.payment_cycle == 1){
                        if(ad >= fd){
                            return (aY-fY)*12+(am-fm)+1
                        }else{
                            return (aY-fY)*12+(am-fm)
                        }
                    }else if(this.editContract.payment_cycle == 2){
                        if(ad >= fd){
                            if(am > fm){
                                return (aY-fY)*4+Math.floor((am-fm)/3)+1
                            }else{
                                return (aY-fY)*4+Math.floor((am-fm)/3)
                            }
                        }else{
                            if(am > fm){
                                return (aY-fY)*4+Math.floor((am-fm)/3)
                            }else{
                                return (aY-fY)*4+Math.floor((am-fm)/3)-1
                            }
                        }
                    }else if(this.editContract.payment_cycle == 3){
                        if(am > fm || (am == fm && ad>= fd)){
                            return ay - fy +1
                        }else{
                            return ay-fy
                        }
                    }
                }else{
                    return 0
                }
            }
        },
        mounted(){
            this.initData()
            this.huizhouqiName = this.editContract.payment_cycle == 1 ? '每月' : this.editContract.payment_cycle == 2 ? '每季度' :
                this.editContract.payment_cycle == 3 ?'每年' : ''
        },
        methods: {
            ...mapMutations([
                'SETEDITCONTRACT'
            ]),
            initData(){
                let id = this.$route.params.id
                this.$http('GET', '/contract/get_contract_edit_details.php?id=' + id).then(res => {
                    if ((this.editContract.files == [] || this.editContract.files == undefined) && res.data.files != []) {
                        for (let i = 0; i < res.data.files.length; i++) {
                            let urlsrc = this.host + res.data.files[i].src
                            this.filesData.push(urlsrc)
                        }
                    } else {
                        for (let i = 0; i < this.editContract.files.length; i++) {
                            if (this.editContract.files[i].size) {
                                this.filesData.push(URL.createObjectURL(this.editContract.files[i]))
                            } else {
                                this.filesData.push(this.editContract.files[i])
                            }
                        }
                    }
                    if (!this.selectCustomer.customId) {
                        this.selectCustomer.customId = res.data.custom_id;
                        this.selectCustomer.customName = res.data.custom_name
                        let datas = res.data;
                        datas.files = this.filesData.concat()
                        this.SETEDITCONTRACT(datas)
                    } else {
                    
                    }
                }).catch(err => {
                    this.I(err)
                })
            },
            update(e){
                let files = e.target.files;
                let nowFiles = this.editContract.files ? this.editContract.files : [];
                for (let i = 0; i < files.length; i++) {
                    this.filesData.push(URL.createObjectURL(files[i]))
                    nowFiles.push(files[i])
                }
                let newObj = this.editContract
                newObj.files = nowFiles;
                this.I(newObj)
                this.SETEDITCONTRACT(newObj)
            },//预览图片
            delImg(key){
                let newObj = this.editContract
                newObj.files.splice(key, 1)
                this.filesData.splice(key, 1)
                this.SETEDITCONTRACT(newObj)
            },//删除图片
            selectCumter(){
                this.$router.push('/selectCustomer')
            },//选择客户
            sureLinkman(depart_name, depart_id, userId, realname){
                let newObj = this.editContract
                newObj.followdepartname = depart_name
                newObj.depart_id = depart_id
                newObj.userId = userId
                newObj.followusername = realname
                this.SETEDITCONTRACT(newObj)
                this.showLinkman = false
            },//确认联系人
            showLinkmans(){
                if (this.selectCustomer.customId) {
                    let id = this.selectCustomer.customId;
                    this.$http('POST', '/receivables/appoint_person.php', {custom_id: id}).then((res)=>{
                        this.linkManData = res.data
                    })
                    this.showLinkman = true
                }
            },
            chooseLabel(){
                let arr = []
                this.editContract.label.map((item) => {
                    return arr.push(item.label_name)
                })
                this.$router.push('/editContractLabel')
            },//选择标签
            changeChecked(){
                /*let state = this.editContract.remindState
                let newObj = this.editContract
                newObj.remindState = state == 0 ? 1 : 0
                this.I(newObj.remindState)
                this.SETEDITCONTRACT(newObj)
                this.$forceUpdate()*/
            },//周期提醒
            chooseZhouqi(){
                let _this = this;
                ccl.actionSheet({
                    title: '合同周期',
                    cancelButton: '取消',
                    otherButtons: ['每月', '每季度', '每年'],
                    onSuccess: function (result) {
                        let newObj = _this.editContract
                        newObj.payment_cycle = result.buttonIndex + 1;
                        newObj.huizhouqiName = result.buttonIndex == 0 ? '每月' : result.buttonIndex == 1 ? '每季度' : '每年'
                        _this.huizhouqiName = result.buttonIndex == 0 ? '每月' : result.buttonIndex == 1 ? '每季度' : '每年'
                        _this.SETEDITCONTRACT(newObj)
                    },
                })
            },//选择周期
            sendData(){
                let sendObj = this.editContract
                if (sendObj.contract_name == '' || sendObj.contract_name == undefined) {
                    ccl.alert({
                        text: '合同名称不能为空'
                    });
                    return;
                }
                /*if (this.selectCustomer.customId == '' || this.selectCustomer.customId == undefined) {
                 ccl.alert({
                 text: '客户名称不能为空'
                 });
                 return;
                 }*/
                if (sendObj.contract_date == '' || sendObj.contract_date == undefined) {
                    ccl.alert({
                        text: '合同日期不能为空'
                    });
                    return;
                }
                if ((sendObj.contract_money == '' || sendObj.contract_money == undefined) && sendObj.contract_type == 1) {
                    ccl.alert({
                        text: '合同金额无效'
                    });
                    return;
                }
                if ((sendObj.maturity_date == '' || sendObj.maturity_date == undefined) && sendObj.contract_type != 1) {
                    ccl.alert({
                        text: '到期日期不能为空'
                    });
                    return;
                }
                if ((sendObj.first_date_payment == '' || sendObj.first_date_payment == undefined) && sendObj.contract_type == 2) {
                    ccl.alert({
                        text: '首次回款日期不能为空'
                    });
                    return;
                }
                if ((sendObj.each_money == '' || sendObj.each_money == undefined) && sendObj.contract_type == 2) {
                    ccl.alert({
                        text: '每期回款金额不能为空'
                    });
                    return;
                }
                
                let labelIdarr = []
                sendObj.label.map((item) => {
                    return labelIdarr.push(item.id)
                })
                let contract_id = this.$route.params.id
                let contract_name = sendObj.contract_name ? sendObj.contract_name : '';
                let contract_number = sendObj.contract_number ? sendObj.contract_number : '';
                let custom_id = this.selectCustomer.customId ? this.selectCustomer.customId : '';
                let label_id = labelIdarr ? labelIdarr : '';
                let contract_type = sendObj.contract_type ? sendObj.contract_type : '1';
                let contract_date = sendObj.contract_date ? sendObj.contract_date : '';
                let maturity_date = sendObj.maturity_date ? sendObj.maturity_date : '';
                let remark = sendObj.remark ? sendObj.remark : '';
                let currency_id = sendObj.currency_id ? sendObj.currency_id : '1';
                let linkman = sendObj.linkman ? sendObj.linkman : '1';
                let followup = sendObj.followup_id ? sendObj.followup_id : '';
                let departId = sendObj.followup_depart ? sendObj.followup_depart : '';
                //周期
                let payment_cycle = sendObj.payment_cycle ? sendObj.payment_cycle : '1';
                let firstPayment = sendObj.first_date_payment ? sendObj.first_date_payment : '2017-01-01';
                let each_money = sendObj.each_money ? sendObj.each_money : '';
                let expiration_reminder = sendObj.remindState ? '1' : 0;
                let advance_remind = expiration_reminder == 0 ? '' : sendObj.advance_remind ? sendObj.advance_remind : '';
                let cycle = this.cycle ? this.cycle : '';
                let cycleMoney = this.cycle*each_money ? this.cycle*each_money : '';
                
                //普通合同
                let contract_money = sendObj.contract_money ? sendObj.contract_money : '';
                
                //框架合同
                let advance_money = sendObj.yuMoney ? sendObj.yuMoney : '';
                let payment_type = sendObj.payment_type ? sendObj.payment_type : '';
                let three_type = sendObj.three_type ? sendObj.three_type : '';
                let two_type = sendObj.two_type ? sendObj.two_type : '';
                let each_day = sendObj.each_day ? sendObj.each_day : '';
                let each_month = payment_type == 2 ? two_type : payment_type == 3 ? three_type : '1'
                
                let newForm = new FormData()
                let oldArr = [];
                if (sendObj.files && sendObj.files.length > 0) {
                    for (let i = 0; i < sendObj.files.length; i++) {
                        if(sendObj.files[i].type){
                            newForm.append("image" + i, sendObj.files[i])
                        }else{
                            oldArr.push(sendObj.files[i])
                        }
                    }
                }
                newForm.append('oldArr', JSON.stringify(oldArr))
                
                newForm.append('contract_id', contract_id)
                newForm.append('contract_name', contract_name)
                newForm.append('contract_number', contract_number)
                newForm.append('custom_id', custom_id)
                newForm.append('label_id', label_id)
                newForm.append('contract_type', contract_type)
                newForm.append('contract_date', contract_date)
                newForm.append('maturity_date', maturity_date)
                newForm.append('remark', remark)
                newForm.append('currency_id', currency_id)
                newForm.append('linkman', linkman)
                newForm.append('followup', followup)
                newForm.append('depart_id', departId)
                if (contract_type == 1) {
                    newForm.append('contract_money', Number(contract_money).toFixed(2))
                } else if (contract_type == 2) {
                    newForm.append('payment_cycle', payment_cycle)
                    newForm.append('firstPayment', firstPayment)
                    newForm.append('each_money', Number(each_money).toFixed(2))
                    newForm.append('expiration_reminder', expiration_reminder)
                    newForm.append('advance_remind', advance_remind)
                    newForm.append('cycle', cycle)
                    newForm.append('contract_money', Number(cycleMoney).toFixed(2))
                } else if (contract_type == 3) {
                    newForm.append('advance_money', Number(advance_money).toFixed(2))
                    newForm.append('payment_type', payment_type)
                    newForm.append('each_month', each_month)
                    newForm.append('each_day', each_day)
                }
                this.$http('FORM', '/contract/put_contract.php', newForm).then(res => {
                    if (res.code == 0) {
                        let id = res.data
                        if (res.code == 0) {
                            this.$router.go(-2)
                        }
                    }
                }).catch(err => {
                    this.I(err)
                })
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../assets/main.scss";
    
    .cont {
        overflow: hidden;
        .title {
            span {
                margin: 0 5px 3px 0;
                display: inline-block;
                width: 5px;
                height: 5px;
                background: $mainColor;
            }
            h4 {
                display: inline-block;
                font-size: $fontSize;
                color: #666666;
            }
        }
        .person {
            .col {
                margin: 0.3rem 0;
                width: 33.333%;
                float: left;
                text-align: center;
                .imgs {
                    width: 60%;
                    margin: 0 auto;
                    position: relative;
                    .img {
                        position: relative;
                        width: 100%;
                        padding-bottom: 100%;
                        img {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            border-radius: 50%;
                            
                        }
                    }
                    .active {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(56, 145, 249, 0.4);
                        border-radius: 50%;
                        i {
                            font-size: 1.5rem;
                            color: $baiColor;
                            opacity: 0.8;
                        }
                    }
                }
                p {
                    font-size: 0.65rem;
                    color: #000000;
                }
            }
        }
    }

</style>
