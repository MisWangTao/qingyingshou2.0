<template>
    <div id="contract">
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>合同名称</div>
                    <div class="col-xs-9"><input v-model="newContract.name" type="text" placeholder="请输入合同名称"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同编号</div>
                    <div class="col-xs-9"><input v-model="newContract.bianhao" type="text" placeholder="请输入合同编号"></div>
                </div>
            </div>
            <div class="container" @click="selectCumter">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>客户名称</div>
                    <div class="col-xs-9"><input v-model="selectCustomer.customName" type="text" disabled
                                                 placeholder="请选择客户名称"><i
                        class="icon iconfont">&#xe681;</i>
                    </div>
                
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同标签</div>
                    <div class="col-xs-9 hetong" @click="chooseLabel">
                        <input type="text" disabled placeholder="请选择或添加合同标签">
                        <span v-for="(item,key) in newContract.label.labelName">{{item}}</span>
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同类型</div>
                    <div class="col-xs-9">
                        <select v-model="newContract.contractType">
                            <option value="1">普通</option>
                            <option value="2">周期</option>
                            <option value="3">框架</option>
                        </select>
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>合同日期</div>
                    <div class="col-xs-9">
                        <input v-model="newContract.contractDate" type="date" value="2017-07-31">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span v-show="newContract.contractType!=1">*</span>到期日期</div>
                    <div class="col-xs-9">
                        <input v-model="newContract.arrivalDate" type="date" value="2017-07-31">
                    </div>
                </div>
            </div>
            
            <!-- 普通合同 -->
            <div class="container" v-show="newContract.contractType==1">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>合同金额</div>
                    <div class="col-xs-9">
                        <input v-model="newContract.contractMoney" type="text" placeholder="请输入合同金额">
                        <i class="icon iconfont">&#xe681;</i>
                        <span @click="showCurrencys" class="bizhong">{{newContract.currencyName}}</span>
                    </div>
                </div>
            </div>
            
            
            <div class="container" v-show="newContract.contractType == 3">
                <div class="row">
                    <div class="col-xs-3">预收款</div>
                    <div class="col-xs-9">
                        <input v-model="newContract.yuMoney" type="text" placeholder="请输入预收款金额">
                        <i class="icon iconfont">&#xe681;</i>
                        <span class="bizhong">CNY</span>
                    </div>
                </div>
            </div>
            <div class="container" v-show="newContract.contractType == 3">
                <div class="row">
                    <div class="col-xs-3">收款方式</div>
                    <div class="paymentMethod">
                        <select name="" v-model="newContract.payment_type">
                            <option value="1">每月</option>
                            <option value="2">每季度</option>
                            <option value="3">每年</option>
                        </select>
                        <select name="" v-model="newContract.three_type" v-show="newContract.payment_type == 3">
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
                        <select name="" v-model="newContract.two_type" v-show="newContract.payment_type == 2">
                            <option value="1">第1个月</option>
                            <option value="2">第2个月</option>
                            <option value="3">第3个月</option>
                        </select>
                        <select name="" v-model="newContract.each_day">
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
        
        
        <!-- 周期合同 -->
        
        <div class="container-fluid" v-show="newContract.contractType == 2">
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
                    <div class="col-xs-9">
                        <input type="date" v-model="newContract.firstDate" value="" placeholder="请选择首次收款日期">
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>每期金额</div>
                    <div class="col-xs-9">
                        <input type="text" v-model="newContract.eachMoney" value="" placeholder="请输入每期金额">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid" v-show="newContract.contractType == 2">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">周期提醒</div>
                    <div class="col-xs-9 switch">
						<span>
							提前
							<select class="select" name="" id="" v-model="newContract.advance_remind">
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
                        <input type="checkbox" @click="changeChecked" v-model="newContract.remindState" name=""
                               value=""/>
                        <img v-show="!newContract.remindState" :src="imghost+'switch_off@2x.png'" alt="">
                        <img v-show="newContract.remindState" :src="imghost+'switch_on@2x.png'" alt="">
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="container-fluid">
            <div class="container" @click="chooseContacts">
                <div class="row">
                    <div class="col-xs-3">联系人</div>
                    <div class="col-xs-9">
                        <input type="text" placeholder="请选择或添加联系人">
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
            <!-- <div class="container">
                                <div class="row">
                                        <div class="col-xs-3">联系电话</div>
                                        <div class="col-xs-9"><input type="text" placeholder="请输入电话"></div>
                                </div>
                        </div> -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>跟进人</div>
                    <div class="col-xs-9 genjinren" @click="showLinkmans">
                        <input type="text" disabled placeholder="请选择跟进人">
                        <p v-show="man.realname">
                            <span>{{man.realname}}</span>
                            <span>{{man.depart_name}}</span>
                        </p>
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">备注</div>
                    <div class="col-xs-9"><textarea v-model="newContract.contractRemark"></textarea></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">附件</div>
                    <div class="col-xs-9">
                        <input ref="files" multiple="true" accept="image/png,image/gif,image/jpeg" @change="update"
                               type="file"><i
                        class="icon iconfont">&#xe692;</i>
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
        <div class="btn" @click="sengData">
            <button>确定</button>
        </div>
        
        <!-- 选择货币种类部分 -->
        <div class="zhezhao" style="display:block" v-show="showCurrency"></div>
        <div class="currency" v-show="showCurrency">
            <ul>
                <li :class="{'active':item.id == newContract.currencyId}" v-for="(item,key) in currency"
                    @click="chooseCurrency(item.id,item.ab)">
                    <img :src="imghost+'/currency/'+item.ab+'@2x.png'" title="item.ab"/>
                    <i v-show="item.id == newContract.currencyId" class="icon iconfont">&#xe614;</i>
                </li>
            </ul>
        </div>
        
        
        <!-- 选择跟进人部分弹框 -->
        <div class="modal" style="display:block" v-show="showLinkman">
            <div class="modalInner">
                <div class="modalHead">
                    <h4>选择跟进人</h4>
                    <i @click="showLinkman=false" class="icon iconfont">&#xe60f;</i>
                </div>
                <div class="modalBody">
                    <div class="cont" v-for="(item,key) in linkManData">
                        <div class="title"><span></span><h4>{{item.depart_name}}</h4></div>
                        <div class="person">
                            <div class="col" v-for="(items,index) in item.users"
                                 @click="sureLinkman(item.depart_name,item.departId,items.userId,items.realname)">
                                <div class="imgs">
                                    <div class="img">
                                        <img v-if="items.ding_avatar" :src="items.ding_avatar" alt="">
                                        <img v-else  :src="imghost+'menu/hetong_new@2x.png'" alt="">
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
    import {host, imghost} from '../../config/config.js'
    import {mapState, mapMutations} from 'vuex'
    import ccl from '../../common/ccl.js'
    export default{
        data(){
            return {
                host,
                imghost,
                currency: [],
                showCurrency: false,
                filesData: [],
                linkManData: [],
                huizhouqiName: '',
                showLinkman: false,
                man: {},
            }
        },
        computed: {
            ...mapState([
                'newContract', 'selectCustomer'
            ]),
        },
        mounted(){
            if (this.selectCustomer.customId) {
                this.getLinkmanData().then(res => {
                    this.linkManData = res.data
                }).catch(err => {
                    this.I(err)
                });
            }
            this.initData()
        },
        methods: {
            ...mapMutations([
                'SETNEWCONTRACT'
            ]),
            initData(){
                this.filesData = this.newContract.files ? this.newContract.files.map((item) => {
                    return URL.createObjectURL(item)
                }) : []
                if(this.selectCustomer.customId && this.newContract.customId){
                    if(this.selectCustomer.customId == this.newContract.customId){
                        this.man.depart_name = this.newContract.depart_name ? this.newContract.depart_name : ''
                        this.man.depart_id = this.newContract.depart_id ? this.newContract.depart_id : ''
                        this.man.userId = this.newContract.userId ? this.newContract.userId : ''
                        this.man.realname = this.newContract.realname ? this.newContract.realname : ''
                        this.huizhouqiName = this.newContract.huizhouqiName ? this.newContract.huizhouqiName : ''
                    }
                }
                if(this.selectCustomer.customId){
                    this.newContract.customId = this.selectCustomer.customId
                }
            },
            chooseLabel(){
                this.$router.push('/contractLabel')
            },//选择标签
            getCurrency(){
                return this.$http('GET', '/currency/get_currency_list.php')
            },//获取币种
            getLinkmanData(){
                return this.$http('POST', '/receivables/appoint_person.php', {custom_id: this.selectCustomer.customId})
            },//获取联系人
            selectCumter(){
                this.$router.push('/selectCustomer')
            },//选择客户
            update(e){
                let files = e.target.files;
                let nowFiles = this.newContract.files ? this.newContract.files : [];
                for (let i = 0; i < files.length; i++) {
                    this.filesData.push(URL.createObjectURL(files[i]))
                    nowFiles.push(files[i])
                }
                let newObj = this.newContract
                newObj.files = nowFiles;
                this.SETNEWCONTRACT(newObj)
            },//预览图片
            delImg(key){
                let newObj = this.newContract
                newObj.files.splice(key, 1)
                this.filesData.splice(key, 1)
                this.SETNEWCONTRACT(newObj)
            },//删除图片
            sureLinkman(depart_name, depart_id, userId, realname){
                this.man.depart_name = depart_name
                this.man.depart_id = depart_id
                this.man.userId = userId
                this.man.realname = realname
                let newObj = this.newContract
                newObj.depart_name = depart_name
                newObj.depart_id = depart_id
                newObj.userId = userId
                newObj.realname = realname
                this.SETNEWCONTRACT(newObj)
                this.showLinkman = false
            },//确认联系人
            chooseLinkman(){
                this.showLinkman = true;
            },
            showLinkmans(){
                if (this.selectCustomer.customId) {
                    this.showLinkman = true
                }
            },
            chooseContacts(){
                dd.biz.contact.externalComplexPicker({
                    "title":"测试标题",
                    "corpId":"",
                    "multiple":true, //是否多选  true多选，false单选，默认是单选
                    "limitTips":"超出了",
                    "maxUsers":1000, //默认不限制
                    "pickedUsers":[],  //已选，但可取消，只针对多选生效
                    "disabledUsers":[], //不可选，，只针对多选生效
                    "requiredUsers":[], //必选，只针对多选生效
                    onSuccess: function(data) {
                        alert(JSON.stringify(data))
                    },
                    onFail : function(err) {}
                });
            },
            sengData(){
                let sendObj = this.newContract
                if (sendObj.name == '' || sendObj.name == undefined) {
                    ccl.alert({
                        text: '合同名称不能为空'
                    });
                    return;
                }
                if (this.selectCustomer.customId == '' || this.selectCustomer.customId == undefined) {
                    ccl.alert({
                        text: '客户名称不能为空'
                    });
                    return;
                }
                if (sendObj.contractDate == '' || sendObj.contractDate == undefined) {
                    ccl.alert({
                        text: '合同日期不能为空'
                    });
                    return;
                }
                if ((sendObj.contractMoney == '' || sendObj.contractMoney == undefined) && sendObj.contractType == 1) {
                    ccl.alert({
                        text: '合同金额无效'
                    });
                    return;
                }
                if ((sendObj.arrivalDate == '' || sendObj.arrivalDate == undefined) && sendObj.contractType != 1) {
                    ccl.alert({
                        text: '到期日期不能为空'
                    });
                    return;
                }
                if ((sendObj.firstDate == '' || sendObj.firstDate == undefined) && sendObj.contractType == 2) {
                    ccl.alert({
                        text: '首次回款日期不能为空'
                    });
                    return;
                }
                if ((sendObj.eachMoney == '' || sendObj.eachMoney == undefined) && sendObj.contractType == 2) {
                    ccl.alert({
                        text: '每期回款金额不能为空'
                    });
                    return;
                }
                /*if ((sendObj.huizhouqiId == '' || sendObj.huizhouqiId == undefined) && sendObj.contractType == 2) {
                 ccl.alert({
                 text: '回款周期不能为空'
                 });
                 return;
                 }*/
                
                let contract_name = sendObj.name ? sendObj.name : '';
                let contract_number = sendObj.bianhao ? sendObj.bianhao : '';
                let custom_id = this.selectCustomer.customId ? this.selectCustomer.customId : '';
                let label_id = sendObj.label.labelId ? sendObj.label.labelId : '';
                let contract_type = sendObj.contractType ? sendObj.contractType : '1';
                let contract_date = sendObj.contractDate ? sendObj.contractDate : '';
                let maturity_date = sendObj.arrivalDate ? sendObj.arrivalDate : '';
                let remark = sendObj.contractRemark ? sendObj.contractRemark : '';
                let currency_id = sendObj.currencyId ? sendObj.currencyId : '1';
                let linkman = sendObj.linkman ? sendObj.linkman : '1';
                let followup = this.man.userId ? this.man.userId : '';
                let departId = this.man.depart_id ? this.man.depart_id : '';
                //周期
                let huizhouqi = sendObj.huizhouqiId ? sendObj.huizhouqiId : '1';
                let firstDate = sendObj.firstDate ? sendObj.firstDate : '2017-01-01';
                let eachMoney = sendObj.eachMoney ? sendObj.eachMoney : '';
                let reminder = sendObj.remindState ? '1' : 0;
                let advance_remind = reminder == 0 ? '' : sendObj.advance_remind ? sendObj.advance_remind : '';
                
                //普通合同
                let contract_money = sendObj.contractMoney ? sendObj.contractMoney : '';
                
                //框架合同
                let advance_money = sendObj.yuMoney ? sendObj.yuMoney : '';
                let payment_type = sendObj.payment_type ? sendObj.payment_type : '';
                let three_type = sendObj.three_type ? sendObj.three_type : '';
                let two_type = sendObj.two_type ? sendObj.two_type : '';
                let each_day = sendObj.each_day ? sendObj.each_day : '';
                let each_month = payment_type == 2 ? two_type : payment_type == 3 ? three_type : '1'
                
                let newForm = new FormData()
                if (sendObj.files && sendObj.files.length > 0) {
                    for (let i = 0; i < sendObj.files.length; i++) {
                        newForm.append("image" + i, sendObj.files[i])
                    }
                }
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
                    newForm.append('contract_money', contract_money)
                } else if (contract_type == 2) {
                    newForm.append('payment_cycle', huizhouqi)
                    newForm.append('firstPayment', firstDate)
                    newForm.append('each_money', eachMoney)
                    newForm.append('reminder', reminder)
                    newForm.append('advance_remind', advance_remind)
                } else if (contract_type == 3) {
                    newForm.append('advance_money', advance_money)
                    newForm.append('payment_type', payment_type)
                    newForm.append('each_month', each_month)
                    newForm.append('each_day', each_day)
                }
                this.$http('FORM', '/contract/add_contract.php', newForm).then(res => {
                    if (res.code == 0) {
                        let id = res.data
                        if (contract_type == 1) {
                            this.$router.push('/paymentPlan/'+id)
                        } else {
                            this.$router.push('/contractList')
                        }
                    }
                }).catch(err => {
                    this.I(err)
                })
            },//提交数据
            showCurrencys(){
                this.getCurrency().then(res => {
                    this.currency = res.data
                }).catch(err => {
                    this.I(err)
                });
                this.showCurrency = true;
            },//显示model
            chooseCurrency(id, names){
                let _this = this
                let obj = this.newContract
                obj.currencyId = id
                obj.currencyName = names
                this.SETNEWCONTRACT(obj)
                setTimeout(() => {
                    _this.showCurrency = false
                }, 200)
            },//选择货币
            chooseZhouqi(){
                let _this = this;
                ccl.actionSheet({
                    title: '合同周期',
                    cancelButton: '取消',
                    otherButtons: ['每月', '每季度', '每年'],
                    onSuccess: function (result) {
                        let newObj = _this.newContract
                        newObj.huizhouqiId = result.buttonIndex + 1;
                        newObj.huizhouqiName = result.buttonIndex == 0 ? '每月' : result.buttonIndex == 1 ? '每季度' : result.buttonIndex == 2 ? '每年' : ''
                        _this.huizhouqiName = result.buttonIndex == 0 ? '每月' : result.buttonIndex == 1 ? '每季度' : result.buttonIndex == 2 ? '每年' : ''
                        _this.SETNEWCONTRACT(newObj)
                    },
                })
            },//选择周期
            changeChecked(){
               /* let state = this.newContract.remindState
                let newObj = this.newContract
                newObj.remindState = state == 0 ? 1 : 0
                this.SETNEWCONTRACT(newObj)
                this.$forceUpdate()*/
            },//周期提醒
        },
    }
</script>
<style lang="scss" scoped>
    @import "../../assets/main.scss";
    
    #contract {
        .container-fluid {
            .container {
                .row {
                    .paymentMethod {
                        color: #222222;
                        width: 70%;
                        float: left;
                        position: relative;
                        i {
                            position: absolute;
                            right: 0;
                            top: 0.2rem;
                            font-size: 0.7rem;
                            color: #97a8be;
                        }
                        select {
                            border: 0;
                            margin-right: 0.3rem;
                        }
                    }
                    .switch {
                        position: relative;
                        .select {
                            width: 0.8rem;
                            color: $mainColor;
                        }
                        span {
                            color: #121213;
                        }
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
