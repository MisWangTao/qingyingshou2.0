<template>
    <div id="paymentPlan">
        <div class="row top">
            <p>提示:按照客户账期自动生成回款计划</p>
            <span @click="changeStatae">修改</span>
        </div>
        <div class="planLists">
            <div class="row">
                <div class="col-xs-4">计划日期</div>
                <div class="col-xs-4">类型</div>
                <div class="col-xs-4">金额</div>
            </div>
            <div class="row">
                <div class="col-xs-4">{{date}}</div>
                <div class="col-xs-4">常规</div>
                <div class="col-xs-4">{{money | numberFormat}}</div>
            </div>
        </div>
        <div class="addPlan" @click="goShoudong"><p>手动添加回款计划</p></div>
        <div class="container-fluid">
            <div class="col-xs-3">到期提醒</div>
            <div class="col-xs-9 switch">
                提前
                <select v-model="stateDay" style="border:none;">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                </select>
                天
                <input @click="changeShow" type="checkbox" name="" value=""/>
                <img v-show="!showState" :src="imghost+'switch_off@2x.png'" alt="">
                <!-- 打开显示图片 -->
                <img v-show="showState" :src="imghost+'switch_on@2x.png'" alt="">
            </div>
        </div>
        
        <div class="btn">
            <button @click="goBacks">确定</button>
            <p @click="noTianjia">暂不添加，跳过</p>
        </div>
        
        
        <!-- 选择账期部分弹框 -->
        <div class="modal" v-show="showModel">
            <div class="inner">
                <div class="head">
                    <h4>提示</h4>
                </div>
                <div class="modalBody">
                    <div class="row">
                        <div class="col-xs-2"><img class="img1" :src="imghost+'yicixing@2x.png'" alt=""></div>
                        <div class="col-xs-9">
                            <p>一次性收账 账期<input type="text" v-model="zhangqi">天<br>
                                <span>根据账期自动生成回款计划</span></p>
                        </div>
                        <div class="col-xs-1">
                            <input @click="setIndex(1)" type="radio" name="" value=""/>
                            <span :class="{'active': index == 1}"><i class="icon iconfont">&#xe614;</i></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-2"><img class="img2" :src="imghost+'gundong@2x.png'" alt=""></div>
                        <div class="col-xs-9">
                            <p>滚动收款<span> 滚动生成回款计划</span></p>
                            <div class="cycle">
                                <div>
                                    <i class="icon iconfont">&#xe622;</i>
                                    <select v-model="paymethods">
                                        <option value="1">周结</option>
                                        <option value="2">月结</option>
                                        <option value="3">季结</option>
                                        <option value="4">年结</option>
                                    </select>
                                </div>
                                <div>
                                    <i class="icon iconfont">&#xe622;</i>
                                    <select v-model="zhou" v-show="paymethods == 1">
                                        <option value="1">周一</option>
                                        <option value="2">周二</option>
                                        <option value="3">周三</option>
                                        <option value="4">周四</option>
                                        <option value="5">周五</option>
                                        <option value="6">周六</option>
                                        <option value="7">周日</option>
                                    </select>
                                    <select v-model="months" v-show="paymethods == 3">
                                        <i class="icon iconfont">&#xe622;</i>
                                        <option value="1">
                                            第一个月
                                        </option>
                                        <option value="2">
                                            第二个月
                                        </option>
                                        <option value="3">
                                            第三个月
                                        </option>

                                    </select>
                                    <select v-model="month" v-show="paymethods == 4">
                                        <i class="icon iconfont">&#xe622;</i>
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
                                </div>
                                <div>
                                    <select v-model="day" v-show="paymethods != 1">
                                        <i class="icon iconfont">&#xe622;</i>
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
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-1">
                            <input @click="setIndex(2)" type="radio" name="" value=""/>
                            <span :class="{'active': index == 2}"><i class="icon iconfont">&#xe614;</i></span>
                        </div>
                    </div>
                    <div class="ipts">
                        <input @click="hideModel(1)" class="ipt1" type="button" name="" value="取消"/>
                        <input @click="hideModel(2)" class="ipt2" type="submit" name="" value="确定"/>
                    </div>
                </div>
            </div>
        </div>
    
    </div>
</template>
<script>
    import {host, imghost} from '../../../config/config.js'
    import {mapState} from 'vuex'
    export default{
        data(){
            return {
                host,
                imghost,
                date : '',
                money : '',
                zhangqi : 7,
                showModel : false,
                index : 1,
                paymethods : 1, //结算方式 默认周结
                zhou : 1,
                months : 1,
                month :1,
                day :1,
                stateDay:7,
                showState : false,
            }
        },
        computed:{
            ...mapState([
                'newContract'
            ])
        },
        mounted(){
            this.I(this.newContract)
            this.initData()
        },
        methods:{
            initData(){
                this.date = this.getNowDate(new Date(this.newContract.contractDate).getTime() + this.zhangqi*24*60*60*1000)
                this.money = this.newContract.contractMoney
            },
            changeStatae(){
                this.showModel = true
            },
            changeShow(){
                this.showState = !this.showState
            },
            hideModel(param){
                if(param == 2){
                    let dates = '';
                    let arrDate = this.newContract.arrivalDate; //合同时间
                    if(this.index == 1){
                        dates = this.getNowDate(new Date(this.newContract.contractDate).getTime() + this.zhangqi*24*60*60*1000)
                    }
                    if(this.index == 2){
                        let conDate = this.newContract.contractDate; //合同时间
                        if(this.paymethods == 1){
                            let zhou = this.zhou
                            let day = new Date(conDate).getDay()
                            let cha = (zhou-day) >0 ? (zhou-day) : (zhou-day) + 7
                            dates = this.getNowDate(new Date(this.newContract.contractDate).getTime() + cha*24*60*60*1000)
                        }
                        if(this.paymethods == 2){
                            let day = this.day < 10 ? '0'+this.day : this.day
                            if(Number(day) > Number(conDate.slice(-1))){
                                dates = conDate.slice(0,-2) + day
                            }else{
                                let m = conDate.slice(5,7)
                                let y = conDate.slice(0,4)
                                if((Number(m)+1)>12){
                                    m = '0' + ((Number(m)+1)-12)
                                    y = Number(y) + 1
                                }else{
                                    m = Number(m)+1 <10 ? '0'+(Number(m)+1) : Number(m)+1
                                }
                                let newDate = y + '-' + m + '-' + day
                                dates = newDate
                            }
                        }
                        if(this.paymethods == 3){
                            let mon = this.months
                            let day = this.day
                            let y = conDate.slice(0,4)
                            let m = conDate.slice(5,7)
                            if(m%3>Number(mon) || (m%3 == mon && Number(conDate.slice(-2))>=Number(day))){
                                let nowmo = (Math.floor(m/3+1)*3+Number(mon) ) <10 ? ('0' + (Math.floor(m/3+1)*3+Number(mon))) : (Math.floor(m/3+1)*3+ Number(mon ))
                                let dd = day < 10 ? '0' + day : day
                                let newDate = y + '-' + nowmo + '-' + dd
                                dates = newDate
                            }else{
                                let nowmo = (Math.floor(m/3)*3+Number(mon) ) <10 ? ('0' + (Math.floor(m/3)*3+Number(mon))) : (Math.floor(m/3)*3+ Number(mon ))
                                let dd = day < 10 ? '0' + day : day
                                let newDate = y + '-' + nowmo + '-' + dd
                                dates = newDate
                            }
                        }
                        if(this.paymethods == 4){
                            let mon = this.month < 10 ? '0' + this.month : this.month
                            let day = this.day < 10 ? '0' + this.day : this.day
                            let y = conDate.slice(0,4)
                            let m = conDate.slice(5,7)
                            let huiDate = y + '-' + mon + '-' +day
                            this.I(huiDate)
                            if(huiDate > conDate){
                                dates = huiDate
                            }else{
                                dates = Number(y)+1 + '-' + mon + '-' + day
                            }
                        }
                    }
                    this.date = dates > arrDate ? arrDate : dates;
                }
                this.showModel = false
            },
            setIndex(index){
                this.index = index
            },
            goBacks(){
                if(this.date == '' || this.money == ''){
                    return;
                }
                let arr = [];
                let obj = {};
                obj.plan_type = '1'
                obj.plan_date = this.date
                obj.plan_money = this.money
                arr.push(obj)
                let param = {
                    contract_id : this.$route.params.id,
                    returnPlan : JSON.stringify(arr),
                }
                if(this.showState){
                    param.expiration_reminder = true
                    param.advance_remind = this.stateDay
                }
                this.$http('POST','/paymentPlan/add_plan.php',param).then(res=>{
                    if(res.code == 0){
                        this.$router.replace('/contractList')
                    }
                }).catch(err=>{
                
                })
            },
            goShoudong(){
                let id = this.$route.params.id
                this.$router.replace('/addhuikuanPlan/'+id)
            },
            noTianjia(){
                this.$router.replace('/contractList')
            },
            getNowDate(date){
                let newDate = date ? new Date(date) : new Date()
                let year = newDate.getFullYear()
                let month = newDate.getMonth()+1
                let day = newDate.getDate()
                let m = month < 10 ? '0' + month : month
                let d = day < 10 ? '0' + day : day
                return year + '-' + m + '-' + d
            },
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../assets/main.scss";
    
    #paymentPlan {
        font-size: 0.7rem;
        .top {
            padding: 0.3rem 0.5rem;
            overflow: hidden;
            p {
                display: inline-block;
                color: #5a6879;
                line-height: 1.2rem;
            }
            span {
                display: block;
                float: right;
                padding: 0.06rem 0.5rem;
                color: $mainColor;
                border-radius: 2px;
                border: 1px solid $mainColor;
            }
        }
        .planLists {
            background: $baiColor;
            padding: 0 0.5rem;
            border-top: $qianStyle;
            border-bottom: $qianStyle;
            .row {
                border-bottom: $qianStyle;
                overflow: hidden;
                line-height: 1.8rem;
                color: #121213;
                .col-xs-4 {
                    text-align: center;
                }
            }
            .row:first-child {
                color: #5a6879;
            }
        }
        .addPlan {
            padding: 0.2rem 0.5rem;
            overflow: hidden;
            p {
                float: right;
                color: $mainColor;
            }
        }
        .container-fluid {
            background: $baiColor;
            overflow: hidden;
            padding: 0.5rem 0.5rem;
            .col-xs-3 {
                color: #5a6879;
            }
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
    
    .modal {
        .inner {
            margin: 35% auto 0;
            width: 85%;
            background: $baiColor;
            border-radius: 1px;
            overflow: hidden;
            .head {
                text-align: center;
                line-height: 1.6rem;
                border-bottom: $borderStyle;
            }
            .modalBody {
                padding: 0.5rem 0 0.8rem;
                overflow: hidden;
                .row {
                    margin-top: 0.5rem;
                    padding: 0.3rem 0.5rem;
                    overflow: hidden;
                    .col-xs-2 {
                        padding: 0 0.5rem 0 0;
                        text-align: center;
                        img {
                            vertical-align: top;
                            margin-top: 0.4rem;
                        }
                        .img1 {
                            width: 1.2rem;
                        }
                        .img2 {
                            width: 1.3rem;
                        }
                    }
                    .col-xs-9 {
                        p:first-child {
                            font-size: 0.7rem;
                            color: #121213;
                            input {
                                text-align: center;
                                margin: 0 0.2rem;
                                width: 2rem;
                                border-radius: 2px;
                                border: $borderStyle;
                            }
                            span {
                                font-size: 0.65rem;
                                color: #999999;
                            }
                        }
                        p:nth-child(2) {
                            select {
                            
                            }
                        }
                        .cycle {
                            overflow: hidden;
                            div {
                                position: relative;
                                margin-right: 0.3rem;
                                float: left;
                                select {
                                    color: #5a6879;
                                    padding: 0 0.8rem 0 0.3rem;
                                    border: 1px solid #bdbdbd;
                                    border-radius: 1px;
                                    font-size: 0.65rem;
                                }
                                i {
                                    position: absolute;
                                    top: 0.1rem;
                                    right: 0.1rem;
                                    font-size: 0.7rem;
                                    color: #999999;
                                }
                                
                            }
                        }
                    }
                    .col-xs-1 {
                        position: relative;
                        input {
                            position: absolute;
                            top: 0.5rem;
                            right: 0;
                            width: 0.9rem;
                            height: 0.9rem;;
                            z-index: 12;
                            opacity: 0;
                        }
                        span {
                            display: block;
                            position: absolute;
                            top: 0.5rem;
                            right: 0;
                            z-index: 11;
                            width: 0.9rem;
                            height: 0.9rem;;
                            border-radius: 50%;
                            background: $baiColor;
                            text-align: center;
                            border: $borderStyle;
                            i {
                                display: none;
                                font-size: 0.8rem;
                            }
                        }
                        .active {
                            background: $mainColor;
                            border: 1px solid $mainColor;
                            i {
                                display: block;
                                color: $baiColor;
                            }
                            
                        }
                    }
                }
                .ipts {
                    text-align: center;
                    margin-top: 1.5rem;
                    input {
                        margin: 0 0.5rem;
                        padding: 0.1rem 1rem;
                    }
                    .ipt1 {
                        border: $borderStyle;
                        
                    }
                    .ipt2 {
                        background: $mainColor;
                        color: $baiColor;
                        border: $lanBorder;
                    }
                }
            }
        }
        
    }


</style>
