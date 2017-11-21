<template>
    <div>
        <div class="centerModal bjhtModal">
            <div class="modalInner">
                <div class="header">
                    <h3>编辑合同</h3>
                    <i @click="closeModel" class="icon iconfont">&#xe60f;</i>
                </div>
                <div class="body">
                    <div class="newContract editContract">
                        <div class="row">
                            <div class="col-xs-3"><span>*</span>合同名称</div>
                            <div class="col-xs-9">
                                <input type="text" placeholder="请输入客户名称" v-model="editContract.contract_name"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">合同编号</div>
                            <div class="col-xs-9">
                                <input type="text" placeholder="请输入客户编号" v-model="editContract.contract_number"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3"><span>*</span>客户名称</div>
                            <div class="col-xs-9">
                                <input type="text" placeholder="请选择客户名称" disabled v-model="editContract.custom_name"/>
                                <span class="choose" @click="selectCustomer">选择</span>
                                <ul class="preset" v-show="false">
                                    <li class="active">西安</li>
                                    <li>西安朋客信息科技有限公司</li>
                                    <li>西安朋客信息科技有限公司</li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">合同标签</div>
                            <div class="col-xs-9">
                                <span v-for="(item,key) in editContract.label">{{item.label_name}}</span>
                                <span class="choose" @click="selectLabels">选择</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">合同类型</div>
                            <div class="col-xs-9">
                                <select v-model="editContract.contract_type">
                                    <option value="1">普通合同</option>
                                    <option value="2">周期合同</option>
                                    <option value="3">框架合同</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-3"><span>*</span>合同日期</div>
                            <div class="col-xs-9">
                                <input type="date" value="" v-model="editContract.contract_date"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">到期日期</div>
                            <div class="col-xs-9">
                                <input type="date" value="" v-model="editContract.maturity_date"/>
                            </div>
                        </div>
                        <div class="row" v-show="editContract.contract_type==1">
                            <div class="col-xs-3"><span>*</span>合同金额</div>
                            <div class="col-xs-9">
                                <input type="text" placeholder="请输入合同金额" v-model="editContract.contract_money"/>
                            </div>
                        </div>
                        <!-- 周期合同 -->
                        <div class="row" v-show="editContract.contract_type==2">
                            <div class="col-xs-3"><span>*</span>回款周期</div>
                            <div class="col-xs-9">
                                <!-- <div class="hkzq"> -->
                                <select v-model="editContract.payment_cycle">
                                    <option value="1">每月</option>
                                    <option value="2">每季</option>
                                    <option value="3">每年</option>
                                </select>
                                <!-- <span>/</span> -->
                                
                                <!-- 		<select>
                                            <option>1月</option>
                                            <option>2月</option>
                                            <option>3月</option>
                                            <option>4月</option>
                                            <option>5月</option>
                                            <option>6月</option>
                                            <option>7月</option>
                                            <option>8月</option>
                                            <option>9月</option>
                                            <option>10月</option>
                                            <option>11月</option>
                                            <option>12月</option>
                                        </select>
                                        <span>/</span>
                                        <select>
                                            <option>最后一天</option>
                                            <option>2日</option>
                                            <option>...</option>
                                        </select> -->
                                <!-- </div> -->
                            </div>
                        </div>
                        <div class="row" v-show="editContract.contract_type==2">
                            <div class="col-xs-3"><span>*</span>首次回款日期</div>
                            <div class="col-xs-9">
                                <input type="date" v-model="editContract.first_date_payment"/>
                            </div>
                        </div>
                        <div class="row" v-show="editContract.contract_type==2">
                            <div class="col-xs-3">每期金额</div>
                            <div class="col-xs-6">
                                <input type="text" placeholder="请输入每次金额" v-model="editContract.each_money"/>
                            </div>
                            <div class="bizhong">
                                <select>
                                    <option>人民币</option>
                                    <option>美元</option>
                                    <option>新台币</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" v-show="editContract.contract_type==2">
                            <div class="col-xs-3">周期提醒</div>
                            <div class="col-xs-9">
                                <select v-model="editContract.advance_remind">
                                    <option value="7">提前7天</option>
                                    <option value="6">提前6天</option>
                                    <option value="5">提前5天</option>
                                    <option value="4">提前4天</option>
                                    <option value="3">提前3天</option>
                                    <option value="2">提前2天</option>
                                    <option value="1">提前1天</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" v-show="editContract.contract_type==3">
                            <div class="col-xs-3">预收款</div>
                            <div class="col-xs-6">
                                <input type="text" placeholder="请输入合同预收款" v-model="editContract.advance_money"/>
                            </div>
                            <div class="bizhong">
                                <select v-model="editContract.currenct_id">
                                    <option>人民币</option>
                                    <option>美元</option>
                                    <option>新台币</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" v-show="editContract.contract_type==3">
                            <div class="col-xs-3"><span>*</span>收款方式</div>
                            <div class="col-xs-9">
                                <input type="text" placeholder="请选择回款方式" v-model="editContract.payment_type"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">联系人</div>
                            <div class="col-xs-9">
                                <input type="text" v-model="editContract.linkmanId" placeholder="请输入联系人" value=""/>
                                <i class="icon iconfont dj" @click="selectLinkMan">&#xe623;</i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3"><span>*</span>跟进人</div>
                            <div class="col-xs-9">
                                <input type="text" v-model="editContract.followusername" placeholder="请选择跟进人" value=""/>
                                <i class="icon iconfont dj" @click="selectFollow">&#xe604;</i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">产品信息</div>
                            <div class="col-xs-9 chanpin">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>产品名称</th>
                                        <th>单价</th>
                                        <th>计价单位</th>
                                        <th>数量</th>
                                        <th><i class="icon iconfont">&#xe616;</i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><span>1</span><input type="text" value=""></td>
                                        <td><input type="text" value="￥562300.00"></td>
                                        <td>
                                            <input type="text" value="台">
                                        </td>
                                        <td>
                                            <input type="text" value="5">
                                        </td>
                                        <td>
                                            <i class="icon iconfont xiazai">&#xe616;</i>
                                            <i class="icon iconfont dele">&#xe610;</i>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="none">
                                    <div class="div1">暂无产品信息</div>
                                    <div>合计：0元</div>
                                    <span class="choose">选择</span>
                                </div>
                            
                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">备注</div>
                            <div class="col-xs-9">
                                <textarea name="" id="" v-model="editContract.remark"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">附件</div>
                            <div class="col-xs-9 file">
                                <table v-show="editContract.files && editContract.files.length>0">
                                    <thead>
                                    <tr>
                                        <th>文件名称</th>
                                        <th>文件大小</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="item,key in editContract.files">
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
                                    <span>已选择{{editContract.files && editContract.files.length}}个文件</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button @click="closeModel" class="btn cancel">取消</button>
                    <button class="btn confirm" @click="sengData()">确定</button>
                </div>
            </div>
        </div>
        <!-- 选择客户部分弹框 -->
        <selectCustomers v-show="showSelectCustom" @closeSelectCustom="hiddenSelectCustom"
                         @customInfo="ChooseCustomer"></selectCustomers>
        <!--选择合同标签弹框-->
        <selectLabels v-if="showSelectLabel" @closeSelectLabelss="hiddenSelectLabel" :labelData="editContract.label"
                      @ChoosedLabels="ChoosedLabels"></selectLabels>
        <!--选择联系人-->
        <!-- <selectLinkman v-show="showSelectLinkMan" @closeSelectLinkman="hiddenSelectLinkman" @ChoosedLabels="ChoosedLabels"></selectLinkman> -->
    </div>
</template>

<script>
    import {mapState, mapMutations} from 'vuex'
    import {host, imghost} from '../../../../config/config.js'
    import selectCustomers from '../../../../components/selectCustomers/selectCustomers.vue'
    import selectLabels from './selectLabel/selectLabel.vue'
    import ccl from '../../../../common/ccl'
    // import selectLinkman from '../../components/selectCustomers/selectLinkman.vue'
    export default{
        data(){
            return {
                host,
                imghost,
                editContract: {
                    contract_type: '1',
                },
                contractInfo: [],
                showSelectCustom: false,
                showSelectLabel: false,
                showSelectLinkMan: false,
                yulanFiles: [],
            }
        },
        computed: {
            cycle(){
                let conDate = this.editContract.contract_date
                let arrDate = this.editContract.maturity_date
                let firstDate = this.editContract.first_date_payment
                if (arrDate > firstDate) {
                    let aY = arrDate.slice(0, 4)
                    let am = arrDate.slice(5, 7)
                    let ad = arrDate.slice(-2)
                    let fY = firstDate.slice(0, 4)
                    let fm = firstDate.slice(5, 7)
                    let fd = firstDate.slice(-2)
                    
                    if (this.editContract.payment_cycle == 1) {
                        if (ad >= fd) {
                            return (aY - fY) * 12 + (am - fm) + 1
                        } else {
                            return (aY - fY) * 12 + (am - fm)
                        }
                    } else if (this.editContract.payment_cycle == 2) {
                        if (ad >= fd) {
                            if (am > fm) {
                                return (aY - fY) * 4 + Math.floor((am - fm) / 3) + 1
                            } else {
                                return (aY - fY) * 4 + Math.floor((am - fm) / 3)
                            }
                        } else {
                            if (am > fm) {
                                return (aY - fY) * 4 + Math.floor((am - fm) / 3)
                            } else {
                                return (aY - fY) * 4 + Math.floor((am - fm) / 3) - 1
                            }
                        }
                    } else if (this.editContract.payment_cycle == 3) {
                        if (am > fm || (am == fm && ad >= fd)) {
                            return aY - fY + 1
                        } else {
                            return aY - fY
                        }
                    }
                } else {
                    return 0
                }
            }
        },
        mounted(){
            this.I(this.id)
            this.initData()
        },
        props: ['id'],
        components: {
            selectCustomers,
            selectLabels,
            // selectLinkman,
        },
        methods: {
            initData(){
                let id = this.id
                this.$http('GET', '/contract/get_contract_edit_details.php?id=' + id).then(res => {
                    /*if ((this.editContract.files == [] || this.editContract.files == undefined) && res.data.files != []) {
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
                     }*/
                    this.editContract = res.data
                    console.log(this.editContract)
                }).catch(err => {
                    this.I(err)
                })
            },
            sengData(){
                let sendData = this.editContract
                
                let newForm = new FormData()
                
                if (sendData.contract_name == '' || sendData.contract_name == undefined) {
                    // ccl.alert({
                    //     text: '合同名称不能为空'
                    // });
                    this.I(1)
                    return;
                }
                if (sendData.custom_id == '' || sendData.custom_id == undefined) {
                    ccl.alert({
                        text: '客户名称不能为空'
                    });
                    this.I(2)
                    return;
                }
                if (sendData.contract_date == '' || sendData.contract_date == undefined) {
                    ccl.alert({
                        text: '合同日期不能为空'
                    });
                    this.I(3)
                    return;
                }
                if ((sendData.contract_money == '' || sendData.contract_money == undefined) && sendData.contractType == 1) {
                    ccl.alert({
                        text: '合同金额无效'
                    });
                    this.I(4)
                    return;
                }
                if ((sendData.maturity_date == '' || sendData.maturity_date == undefined) && sendData.contractType != 1) {
                    ccl.alert({
                        text: '到期日期不能为空'
                    });
                    this.I(5)
                    return;
                }
                if ((sendData.first_date_payment == '' || sendData.first_date_payment == undefined) && sendData.contractType == 2) {
                    ccl.alert({
                        text: '首次回款日期不能为空'
                    });
                    this.I(6)
                    return;
                }
                if ((sendData.each_money == '' || sendData.each_money == undefined) && sendData.contractType == 2) {
                    ccl.alert({
                        text: '每期回款金额不能为空'
                    });
                    this.I(7)
                    return;
                }
                let labelIdarr = []
                sendData.label.map((item) => {
                    return labelIdarr.push(item.id)
                })
                let oldArr = [];
                if (sendData.files && sendData.files.length > 0) {
                    for (let i = 0; i < sendData.files.length; i++) {
                        if (sendData.files[i].type) {
                            newForm.append("image" + i, sendData.files[i])
                        } else {
                            oldArr.push(this.host + sendData.files[i].src)
                        }
                    }
                }
                //公共参数
                let contract_id = this.id
                let contract_name = sendData.contract_name ? sendData.contract_name : ''
                let contract_number = sendData.contract_number ? sendData.contract_number : ''
                let custom_id = sendData.custom_id ? sendData.custom_id : ''
                let label_id = labelIdarr ? labelIdarr : '';
                let contract_type = sendData.contract_type ? sendData.contract_type : ''
                let contract_date = sendData.contract_date ? sendData.contract_date : ''
                let maturity_date = sendData.maturity_date ? sendData.maturity_date : ''
                let linkman = sendData.linkman ? sendData.linkman : '1'
                let followup = sendData.followup_id ? sendData.followup_id : ''
                let departId = sendData.followup_depart ? sendData.followup_depart : ''
                let remark = sendData.remark ? sendData.remark : ''
                let product_info = sendData.product_info ? endData.product_info : ''
                //普通合同
                let contract_money = sendData.contract_money ? sendData.contract_money : ''
                //周期合同
                let payment_cycle = sendData.payment_cycle ? sendData.payment_cycle : 1
                let firstDate = sendData.first_date_payment ? sendData.first_date_payment : '2017-01-01'
                let each_money = sendData.each_money ? sendData.each_money : ''
                let reminder = sendData.remindState ? '1' : 0
                let advance_remind = reminder == 0 ? '' : sendData.advance_remind ? sendData.advance_remind : ''
                let cycle = this.cycle ? this.cycle : '';
                let cycleMoney = this.cycle * each_money ? this.cycle * each_money : '';
                //框架合同
                let advance_money = sendData.yuMoney ? sendData.yuMoney : ''
                let currency_id = sendData.currenct_id ? sendData.currenct_id : 1
                let payment_type = sendData.payment_type ? sendData.payment_type : ''
                let three_type = sendData.three_type ? sendData.three_type : ''
                let two_type = sendData.two_type ? sendData.two_type : ''
                let each_day = sendData.each_day ? sendData.each_day : ''
                let each_month = payment_type == 2 ? two_type : payment_type == 3 ? three_type : '1'
                
                
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
                    newForm.append('contract_money', contract_money)
                } else if (contract_type == 2) {
                    newForm.append('payment_cycle', payment_cycle)
                    newForm.append('firstPayment', firstDate)
                    newForm.append('each_money', each_money)
                    newForm.append('expiration_reminder', reminder)
                    newForm.append('advance_remind', advance_remind)
                    newForm.append('cycle', cycle)
                    newForm.append('contract_money', Number(cycleMoney).toFixed(2))
                } else if (contract_type == 3) {
                    newForm.append('contract_money', contract_money)
                    newForm.append('advance_money', advance_money)
                    newForm.append('payment_type', payment_type)
                    newForm.append('each_month', each_month)
                    newForm.append('each_day', each_day)
                }
                
                this.$http('FORM', '/contract/put_contract.php', newForm).then(res => {
                    if (res.code == 0) {
                        if (res.code == 0) {
                            this.$emit('closeAll', res.data)
                        }
                    }
                }).catch(err => {
                    this.I(err)
                })
            },
            //选择客户组建显示
            selectCustomer(){
                
                this.showSelectCustom = true
            },
            //选择客户渲染
            ChooseCustomer(val){
                this.showSelectCustom = false
                console.log(val)
                this.editContract.custom_name = val.custom_name
                this.editContract.custom_id = val.custom_id
            },
            closeModel(){
                this.$emit('closeEdit')
            },
            //选择客户子组件点击叉的回调
            hiddenSelectCustom(){
                this.showSelectCustom = false
            },
            //选择合同标签
            selectLabels(){
                this.showSelectLabel = true
            },
            //选择标签子组件点击叉的回调
            hiddenSelectLabel(){
                this.showSelectLabel = false
            },
            //选择标签的渲染
            ChoosedLabels(val){
                this.I(val)
                this.showSelectLabel = false
                this.editContract.label = val
            },
            //选择联系人
            selectLinkMan(){
                this.showSelectLinkMan = true
            },
            //选择联系人的回调
            hiddenSelectLinkman(){
                this.showSelectLinkMan = false
            },
            //选择跟进人
            selectFollow(){
            
            },
            //选择图片
            upload(e){
                let files = e.target.files
                // let nowFiles = this.editContract.files ? this.editContract.files : []
                for (let i = 0; i < files.length; i++) {
                    this.editContract.files.push(files[i])
                    this.yulanFiles.push(URL.createObjectURL(files[i]))
                }
            },
            //预览图片
            yulan(key){
            
            },
            //删除图片
            delImg(key){
                this.editContract.files.splice(key, 1)
                this.yulanFiles.splice(key, 1)
            },
        },
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
    @import "../../../../assets/main";
    
    .centerModal {
        .modalInner {
            .body {
                .editContract {
                    .row {
                        .chanpin {
                            .none {
                                width: 94%;
                                height: 50px;
                                border: $borderStyle;
                                border-radius: 3px;
                                position: relative;
                                div {
                                    padding-left: 10px;
                                    line-height: 24px;
                                    height: 24px;
                                }
                                .div1 {
                                    color: #cfd3d9;
                                    border-bottom: 1px dashed #bfcbd9;
                                }
                                .choose {
                                    position: absolute;
                                    top: 2px;
                                    right: 10px;
                                    font-size: 13px;
                                    color: $mainColor;
                                    cursor: pointer;
                                }
                            }
                        }
                        .col-xs-9 {
                            .hkzq {
                                width: 94%;
                                height: 30px;
                                border: $borderStyle;
                                border-radius: 3px;
                                position: relative;
                                background: #ffffff;
                                select {
                                    display: block;
                                    float: left;
                                    width: 80px;
                                    border: 0;
                                    -webkit-appearance: textfield;
                                    
                                }
                                span {
                                    line-height: 30px;
                                    display: block;
                                    float: left;
                                }
                            }
                            table {
                                tr {
                                    td {
                                        white-space: nowrap;
                                        line-height: 24px;
                                        span {
                                            display: block;
                                            float: left;
                                            margin-right: 3px;
                                        }
                                    }
                                    td:nth-child(1) input {
                                        width: 90px;
                                    }
                                    td:nth-child(2) input {
                                        width: 60px;
                                    }
                                    td:nth-child(3) input {
                                        width: 30px;
                                    }
                                    td:nth-child(4) input {
                                        width: 30px;
                                    }
                                }
                                input {
                                    display: inline-block;
                                    height: 24px;
                                    padding: 0 3px;
                                }
                                i {
                                    font-size: 12px;
                                    cursor: pointer;
                                }
                            }
                            .preset {
                                position: absolute;
                                top: 32px;
                                left: 15px;
                                width: 91%;
                                background: #ffffff;
                                z-index: 11;
                                box-shadow: 0 0px 4px rgba(0, 0, 0, 0.25);
                                li {
                                    padding-left: 15px;
                                    list-style: none;
                                    line-height: 28px;
                                }
                                .active {
                                    background: #e7eef9;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

</style>
