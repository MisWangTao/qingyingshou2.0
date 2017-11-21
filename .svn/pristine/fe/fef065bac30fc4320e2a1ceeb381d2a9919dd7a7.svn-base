<template>
    <div>
        <div class="centerModal bghtModal">
            <div class="modalInner">
                <div class="header">
                    <h3>变更合同</h3>
                    <i @click="closeBiangeng" class="icon iconfont">&#xe60f;</i>
                </div>
                <div class="body">
                    <div class="newContract">
                        <div v-show="biangengData.contract_type != 2">
                            <div class="row">
                                <div class="col-xs-3">合同名称</div>
                                <div class="col-xs-9">
                                    <span>{{biangengData.contract_name}}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3">客户名称</div>
                                <div class="col-xs-9">
                                    <span>{{biangengData.custom_name}}</span>
                                </div>
                            </div>
                            <div class="row cols">
                                <div class="col-xs-6">
                                    <div class="col-xs-4">合同编号</div>
                                    <div class="col-xs-8"><span>{{biangengData.contract_number}}</span></div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="col-xs-4">合同日期</div>
                                    <div class="col-xs-8"><span>{{biangengData.contract_date}}</span></div>
                                </div>
                            </div>
                            <div class="row cols">
                                <div class="col-xs-6">
                                    <div class="col-xs-4">合同金额</div>
                                    <div class="col-xs-8"><span>￥{{biangengData.contract_money | numberFormat}}</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="col-xs-4">回款金额</div>
                                    <div class="col-xs-8"><span>￥{{biangengData.arrival_amount | numberFormat}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-show="biangengData.contract_type == 2">
                            <div class="row">
                                <div class="col-xs-3">合同名称</div>
                                <div class="col-xs-9">
                                    <span>{{biangengData.contract_name}}</span>
                                </div>
                            </div>
                            <div class="row cols">
                                <div class="col-xs-6">
                                    <div class="col-xs-4">客户名称</div>
                                    <div class="col-xs-8"><span>{{biangengData.custom_name}}</span></div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="col-xs-4">合同编号</div>
                                    <div class="col-xs-8"><span>{{biangengData.contract_number}}</span></div>
                                </div>
                            </div>
                            <div class="row cols">
                                <div class="col-xs-6">
                                    <div class="col-xs-4">合同日期</div>
                                    <div class="col-xs-8"><span>{{biangengData.contract_date}}</span></div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="col-xs-4">到期日期</div>
                                    <div class="col-xs-8"><span>{{biangengData.maturity_date}}</span></div>
                                </div>
                            </div>
                            <div class="row cols">
                                <div class="col-xs-6">
                                    <div class="col-xs-4">合同金额</div>
                                    <div class="col-xs-8"><span>￥{{biangengData.contract_money | numberFormat}}</span>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="col-xs-4">回款金额</div>
                                    <div class="col-xs-8"><span>￥{{biangengData.arrival_amount | numberFormat}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row cols">
                                <div class="col-xs-6">
                                    <div class="col-xs-4">每期金额</div>
                                    <div class="col-xs-8"><span>￥{{biangengData.each_money | numberFormat}}</span></div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="col-xs-4">回款期次</div>
                                    <div class="col-xs-8"><span>{{biangengData.cycle}}</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3"><span>*</span>变更业务类型</div>
                            <div class="col-xs-9">
                                <select @input="changeType" v-model="biangengType" name="">
                                    <option value="1">变更合同金额</option>
                                    <option value="2">变更合同金额并退款</option>
                                    <option value="3">仅退款</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">变更原因说明</div>
                            <div class="col-xs-9">
                                <input type="text" placeholder="30字以内变更原因说明" v-model="biangengData.biangeng_why"/>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-xs-3"><span>*</span>变更日期</div>
                            <div class="col-xs-9">
                                <input type="date" value="" v-model="biangengData.biangeng_date"/>
                            </div>
                        </div>
                        <div class="row" v-show="biangengType != 3 && biangengData.contract_type != 2">
                            <div class="col-xs-3"><span>*</span>变更金额</div>
                            <div class="col-xs-9 bgje">
                                <input type="text" value="" @input="changeBiangengmoney"/>
                                <p>
                                    变更后合同金额：￥<span>{{allMoney | numberFormat}}</span>
                                </p>
                            </div>
                        </div>
                        <div class="row" v-show="biangengData.contract_type == 2 && biangengType != 3">
                            <div class="col-xs-3"><span>*</span>到期日期</div>
                            <div class="col-xs-9 bgje">
                                <input type="date" value="" @input="changeMaturity" v-model="biangengData.maturity_dates"/>
                                <p>
                                    变更后回款期次：<span>{{cycle}}</span>
                                </p>
                            </div>
                        </div>
                        <div class="row" v-show="biangengType != 1">
                            <div class="col-xs-3"><span>*</span>退款金额</div>
                            <div class="col-xs-9">
                                <input type="text" @input="changeTuimoney" v-model="biangengData.tui_money" value=""/>
                            </div>
                        </div>
                        <div class="row" v-show="biangengData.contract_type == 2 && biangengType != 3">
                            <div class="col-xs-3"><span>*</span>变更后每期金额</div>
                            <div class="col-xs-9 bgje">
                                <input type="text" placeholder="请输入合同金额" @input="changeEachmoney" v-model="biangengData.biangeng_eachMoney"/>
                                <p>
                                    变更后合同金额：<span>{{allMoney}}</span>
                                </p>
                            </div>
                        </div>
                        
                        
                        <div class="row" v-show="biangengType != 3">
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
                        <div class="row" v-show="biangengType != 3">
                            <div class="col-xs-3">回款计划</div>
                            <div class="col-xs-9 hkjh">
                                共<span>{{biangengData.contract_type!='2'?plansCopy.length : cycle}}</span>笔回款计划<span @click="changeShowEdit" class="span2">{{biangengData.contract_type!='2'?'[点击修改]' : '[点击查看]'}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3">备注</div>
                            <div class="col-xs-9">
                                <input type="text" name="" placeholder="30字以内备注信息" id=""
                                       v-model="biangengData.biangeng_remark"/>
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
                        <div class="row">
                            <div class="col-xs-3">发给谁<i @click="showImgs" class="icon iconfont">&#xe657;</i><img
                                v-show="showImg" :src="imghost+'tishi@2x.png'"></div>
                            <div class="col-xs-9 person">
                                <div class="img">
                                    <i class="icon iconfont">&#xe616;</i>
                                    <p>点击选择</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button @click="closeBiangeng" class="btn cancel">取消</button>
                    <button class="btn confirm" @click="sengData()">提交</button>
                </div>
            </div>
        </div>
        <editPlan :planData="sendData" :allMoney="allMoney" @closeEdit="closeEditPlan" v-if="showEditPlan"></editPlan>
        <editPlanCopy :tuiMoney="biangengData.tui_money" :huiMoney="biangengData.arrival_amount" :planData="plansCopy" :contract_date="biangengData.contract_date" :allMoney="allMoney" @closeEdit="closeEditPlan" v-if="showEditPlanCopy"></editPlanCopy>
    </div>
</template>

<script>
    import {mapState, mapMutations} from 'vuex'
    import {host, imghost} from '../../../../config/config.js'
    // import selectLinkman from '../../components/selectCustomers/selectLinkman.vue'
    import editPlan from './editPlan/editPlan.vue'
    import editPlanCopy from './editPlan/editPlanCopy.vue'
    import ccl from '../../../../common/ccl.js'
    export default{
        data(){
            return {
                host,
                imghost,
                files: [],
                showEditPlan: false,
                biangengType: 1,
                biangengData: {},
                plans: [],
                showImg:false,
                plansCopy:[],
                showEditPlanCopy : false,
            }
        },
        computed: {
            cycle(){
                if( this.biangengData.contract_type==2 && this.biangengType != 3){
                    let conDate = this.biangengData.contract_date
                    let arrDate = this.biangengData.maturity_dates
                    let firstDate = this.biangengData.first_date_payment
                    if (arrDate > firstDate) {
                        let aY = arrDate.slice(0, 4)
                        let am = arrDate.slice(5, 7)
                        let ad = arrDate.slice(-2)
                        let fY = firstDate.slice(0, 4)
                        let fm = firstDate.slice(5, 7)
                        let fd = firstDate.slice(-2)
        
                        if (this.biangengData.payment_cycle == 1) {
                            if (ad >= fd) {
                                return (aY - fY) * 12 + (am - fm) + 1
                            } else {
                                return (aY - fY) * 12 + (am - fm)
                            }
                        } else if (this.biangengData.payment_cycle == 2) {
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
                        } else if (this.biangengData.payment_cycle == 3) {
                            if (am > fm || (am == fm && ad >= fd)) {
                                return ay - fy + 1
                            } else {
                                return ay - fy
                            }
                        }
                    } else {
                        return 0
                    }
                }
                
            },
            allMoney(){
                if(this.biangengType != 3 && this.biangengData.contract_type==2){
                    if(this.biangengData.biangeng_eachMoney == ''){
                        return ''
                    }else{
                        let num = 0;
                        let sum = 0;
                        for(let i=0; i<this.plansCopy.length; i++){
                            if(this.plansCopy[i].planed_money && this.plansCopy[i].planed_money > 0){
                                num = i+1
                                sum += Number(this.plansCopy[i].plan_money)
                            }
                        }
                        return sum + (this.cycle-num) * this.biangengData.biangeng_eachMoney
                    }
                }else if(this.biangengType != 3 && this.biangengData.contract_type!=2){
                     return (Number(this.biangengData.contract_money) + Number(this.biangengData.biangeng_money == '-' ? 0 : this.biangengData.biangeng_money))
                }else{
                    return Number(this.biangengData.contract_money)
                }
                
            },
            sendData(){
                if(this.biangengType != 3 && this.biangengData.contract_type==2){
                    let plansData = this.plansCopy.concat()
                    for(let i=0; i<this.plansCopy.length; i++){
                        if(this.plansCopy[i].planed_money == 0){
                            plansData[i].plan_money = this.biangengData.biangeng_eachMoney
                            plansData[i].planed_money = '0.00'
                        }
                    }
                    if(this.cycle > plansData.length){
                        let cha = this.cycle - plansData.length;
                        let type = this.biangengData.payment_cycle == 1 ? "1" : this.biangengData.payment_cycle == 2 ? "3" : this.biangengData.payment_cycle == 3 ? '12': '';
                        let lastData = plansData[plansData.length-1].plan_date
                        for(let j=0; j<cha; j++){
                            let obj = {}
                            obj.plan_date = this.getNewData(lastData,type)
                            obj.plan_detail = []
                            obj.plan_money = this.biangengData.biangeng_eachMoney
                            obj.plan_remark = ''
                            obj.plan_type = ''
                            obj.planed_money = '0.00'
                            lastData = obj.plan_date
                            plansData.push(obj)
                        }
                    }else if(this.cycle < plansData.length){
                        plansData.splice(this.cycle)
                    }
                    return plansData
                }else{
                    return ''
                }
                
            }
        },
        mounted(){
            let obj = {};
            for (let i in this.detailData.contract) {
                obj[i] = this.detailData.contract[i]
            }
            obj.biangeng_money = 0;
            obj.maturity_dates = this.detailData.contract.maturity_date;
            obj.tui_money = '';
            obj.biangeng_eachMoney = '';
            this.biangengData = obj;
            this.files = this.detailData.files.concat()
            for(let j=0 ; j<this.detailData.plan.length; j++){
                let obj = {}
                let obj1 = {}
                for(let o in this.detailData.plan[j]){
                    obj[o] = this.detailData.plan[j][o]
                    obj1[o] = this.detailData.plan[j][o]
                }
                this.plans.push(obj)
                this.plansCopy.push(obj1)
            }
        },
        components: {
            editPlan,
            editPlanCopy
        },
        props: ['detailData','id'],
        methods: {
            showImgs(){
                this.showImg = !this.showImg
            },
            //几个月后的时间
            getNewData(date,num){
                if(date){
                    let y = date.slice(0,4)
                    let m = date.slice(5,7)
                    let d = date.slice(8,10)
                    m = Number(m) + Number(num);
                    if(m >12 ){
                        m = m - 12
                        y = Number(y) + 1
                    }
                    m = m < 10 ? '0' + m:m
                    return ''+y+'-'+m+'-'+d
                }
            },
            changeType(){
                this.$set(this.biangengData, 'tui_money', '')
                let arr = []
                for(let j=0; j<this.plans.length; j++){
                    let obj = {}
                    for(let o in this.plans[j]){
                        obj[o] = this.plans[j][o]
                    }
                    arr.push(obj)
                }
                let tuiMoney = Number(this.biangengData.tui_money);
                let lastMoney = Number(this.biangengData.tui_money);
                for(let i=arr.length-1; i>=0; i--){
                    if(arr[i].planed_money >0 && lastMoney >0){
                        if(Number(arr[i].planed_money) - lastMoney <= 0){
                            lastMoney = lastMoney - Number(arr[i].planed_money)
                            arr[i].planed_money = '0.00';
                        }else{
                            arr[i].planed_money = Number(arr[i].planed_money) - lastMoney;
                            lastMoney = 0;
                        }
                    }
                }
                this.plansCopy = arr.concat()
            },
            setCopydata(){
                let arr = []
                for(let j=0; j<this.plans.length; j++){
                    let obj = {}
                    for(let o in this.plans[j]){
                        if(o == 'planed_money'){
                            obj[o] = this.plans[j][o]
                        }else{
                            obj[o] = this.plansCopy[j][o]
                        }
                    }
                    arr.push(obj)
                }
                let tuiMoney = Number(this.biangengData.tui_money);
                let lastMoney = Number(this.biangengData.tui_money);
                for(let i=arr.length-1; i>=0; i--){
                    if(arr[i].planed_money >0 && lastMoney >0){
                        if(Number(arr[i].planed_money) - lastMoney <= 0){
                            lastMoney = lastMoney - Number(arr[i].planed_money)
                            arr[i].planed_money = '0.00';
                        }else{
                            arr[i].planed_money = Number(arr[i].planed_money) - lastMoney;
                            lastMoney = 0;
                        }
                    }
                }
                this.plansCopy = arr.concat()
            },
            closeBiangeng(){
                this.$emit('closeBiangeng')
            },
            changeEachmoney(e){
                let val = e.target.value
                this.$set(this.biangengData, 'biangeng_eachMoney', val)
            },
            changeTuimoney(e){
                let val = e.target.value
                this.$set(this.biangengData, 'tui_money', val)
                this.setCopydata()
            },
            changeMaturity(e){
                let val = e.target.value
                this.$set(this.biangengData, 'maturity_dates', val)
            },
            changeShowEdit(){
                if (this.biangengData.contract_type != 2) {
                    this.showEditPlanCopy = true;
                } else {
                    if (this.biangengData.biangeng_eachMoney == '' || this.biangengData.biangeng_eachMoney == undefined) {
                        return
                    }
                    this.showEditPlan = true;
                }
            },
            closeEditPlan(val){
                this.showEditPlan = false;
                this.showEditPlanCopy = false;
                if(val){
                    this.plansCopy = val
                }
            },
            sengData(){
                let sendObj = this.biangengData
                if(this.biangengType == ''){
                    this.layer.alert('变更类型不能为空')
                    return;
                }
                if(this.biangengData.biangeng_date == '' || this.biangengData.biangeng_date == undefined){
                    this.layer.alert('变更日期不能为空')
                    return;
                }
                if(this.biangengData.contract_type != 2){
                    if(this.biangengType != 3){
                        if(this.biangengData.biangeng_money == '' || this.biangengData.biangeng_money == undefined){
                            this.layer.alert('变更金额不能为空')
                            return;
                        }
                    }
                    if(this.biangengType != 1){
                        if(this.biangengData.tui_money == '' || this.biangengData.tui_money == undefined){
                            this.layer.alert('退款金额不能为空')
                            return;
                        }
                    }
                }else if(this.biangengData.contract_type == 2){
                    if(this.biangengType != 3){
                        if(this.biangengData.maturity_dates == '' || this.biangengData.maturity_dates == undefined || this.biangengData.maturity_dates == '0000-00-00'){
                            this.layer.alert('到期日期不能为空')
                            return;
                        }
                        if(this.biangengData.biangeng_eachMoney == '' || this.biangengData.biangeng_eachMoney == undefined){
                            this.layer.alert('变更后每期金额不能为空')
                            return;
                        }
                    }
                    if(this.biangengType != 1){
                        if(this.biangengData.tui_money == '' || this.biangengData.tui_money == undefined){
                            this.layer.alert('退款金额不能为空')
                            return;
                        }
                    }
                }
    
                
                let all= 0;
                this.I(this.allMoney)
                for(let i=0;i<this.plansCopy.length;i++){
                    if(this.plansCopy[i].plan_date == ''){
                        this.layer.alert('回款计划日期不能为空')
                        return;
                    }
                    if(this.plansCopy[i].plan_date < this.contract_date){
                        this.layer.alert('回款计划日期不能早于合同日期')
                        return;
                    }
                    if(this.plansCopy[i].plan_money == ''){
                        this.layer.alert('回款计划金额不能为空')
                        return;
                    }
                    if(Number(this.plansCopy[i].plan_money) > Number(this.allMoney)){
                        this.layer.alert('回款计划金额不能大于合同金额')
                        return;
                    }
                    if(Number(this.plansCopy[i].plan_money) < Number(this.plansCopy[i].planed_money)){
                        this.layer.alert('回款计划金额不能小于核销金额')
                        return;
                    }
                    all+=Number(this.plansCopy[i].plan_money)
                }
                if(all > Number(this.allMoney) && sendObj.contract_type != '2'){
                    this.layer.alert('回款计划金额总和不能大于合同金额')
                    return;
                }
                let contract_id = this.id;
                let contract_type = sendObj.contract_type;
                let biangeng_type = this.biangengType;
                let biangeng_why = sendObj.biangeng_why ? sendObj.biangeng_why : '';
                let biangeng_date = sendObj.biangeng_date ? sendObj.biangeng_date : '';
                let biangeng_money = sendObj.biangeng_money;
                let maturity_dates = sendObj.maturity_dates;//到期日期
                let tui_money = sendObj.tui_money;//退款金额
                let biangeng_eachMoney = sendObj.biangeng_eachMoney;//变更后每期金额
                let send_userid = sendObj.send_userid ? sendObj.send_userid : '1';//变更后每期金额
                let remark = sendObj.biangeng_remark ? sendObj.biangeng_remark : '';//变更后每期金额
                let files = this.files;
                
                let newForm = new FormData()
                let oldArr = [];
                if (files && files.length > 0) {
                    for (let i = 0; i < files.length; i++) {
                        if (files[i].type) {
                            newForm.append("image" + i, files[i])
                        } else {
                            oldArr.push(this.host + files[i].src)
                        }
                    }
                }
                
                newForm.append('contract_id', contract_id)
                newForm.append('contract_type', contract_type)
                newForm.append('change_type', biangeng_type)
                newForm.append('refund_reason', biangeng_why)
                newForm.append('change_date', biangeng_date)
                newForm.append('send_userid', send_userid)
                newForm.append('remark', remark)
                if (biangeng_type != 3) {
                    if(biangeng_type == 2){
                        newForm.append('refund_money', tui_money)
                    }
                    if (contract_type == 2) {
                        newForm.append('maturity_dates', maturity_dates)
                        newForm.append('biangeng_eachMoney', biangeng_eachMoney)
                        newForm.append('planData', JSON.stringify(this.sendData))
                    }else{
                        newForm.append('planData', JSON.stringify(this.plansCopy))
                    }
                    newForm.append('change_money', biangeng_money)
                } else {
                    newForm.append('refund_money', tui_money)
                }
                this.$http('FORM', '/change/add_contract_change.php', newForm).then(res => {
                    if(res.code == 0){
                        this.$emit('closeBiangeng')
                    }
                })
            },
            changeBiangengmoney(e){
                let val = e.target.value
                this.$set(this.biangengData, 'biangeng_money', val)
            },
            //选择图片
            upload(e){
                let files = e.target.files
                // let nowFiles = this.newContract.files ? this.newContract.files : []
                for (let i = 0; i < files.length; i++) {
                    this.I(files[i])
                    this.files.push(files[i])
                }
                // console.log(this.yulanFiles)
                // console.log(this.fileMap)
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
    @import "../../../../assets/main";
    
    .centerModal {
        .modalInner {
            .body {
                .newContract {
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
                            }
                        }
                        .col-xs-9 {
                            input {
                                padding: 0 0 0 10px;
                                width: 91%;
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
                        }
                        .hkjh {
                            line-height: 32px;
                            span {
                                margin: 4px;
                            }
                            .span2 {
                                cursor: pointer;
                                color: $mainColor;
                            }
                        }
                        .bgje {
                            position: relative;
                            p {
                                position: absolute;
                                top: 6px;
                                right: 35px;
                                span {
                                    color: $chengColor;
                                }
                            }
                        }
                        .col-xs-3 {
                            position: relative;
                            img {
                                position: absolute;
                                left: 64px;;
                                bottom: 42px;
                                z-index: 3;
                            }
                            i {
                                margin-left: 3px;
                                font-size: 10px;
                            }
                            i:hover {
                                color: $mainColor;
                                cursor: pointer;
                            }
                        }
                        .person {
                            .img {
                                width: 60px;
                                cursor: pointer;
                                text-align: center;
                                i {
                                    font-size: 26px;
                                    display: block;
                                    color: #ddd;
                                }
                                img {
                                    display: inline-block;
                                    width: 30px;
                                    height: 30px;
                                    border-radius: 50%;
                                }
                                p {
                                    line-height: 20px;
                                    color: #ccc;
                                }
                            }
                        }
                    }
                    .cols {
                        padding-left: 33px;
                        .col-xs-4 {
                            text-align: right;
                            color: $huiColor;
                        }
                        .col-xs-8 {
                            padding-left: 30px;
                            color: #1f2a44;
                        }
                    }
                }
            }
        }
    }

</style>
