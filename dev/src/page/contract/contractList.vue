<template>
    <div id="contract">
        <div v-show="showShaixuan || showPaixu" id="model"></div>
        <searchInput v-show="showSearch" @searchVal="search" @hideSearch="hideSearch"></searchInput>
        <div v-show="showguolv" class="contractTop">
            <span @click="showSear">搜索</span>
            <span @click="showSx">筛选</span>
            <span @click="showPx">排序</span>
            <div v-show="showShaixuan" class="shaixuan">
                <div class="conlist contractDate">
                    <p>合同日期</p>
                    <ul>
                        <li @click="chooseDate(1)" :class="{'active':dateSelectIndex == 1}">全部</li>
                        <li @click="chooseDate(2)" :class="{'active':dateSelectIndex == 2}">今天</li>
                        <li @click="chooseDate(3)" :class="{'active':dateSelectIndex == 3}">本周</li>
                        <li @click="chooseDate(4)" :class="{'active':dateSelectIndex == 4}">本月</li>
                        <li @click="chooseDate(5)" :class="{'active':dateSelectIndex == 5}">本季度</li>
                        <li @click="chooseDate(6)" :class="{'active':dateSelectIndex == 6}">本年</li>
                    </ul>
                </div>
                <div class="conlist contractState">
                    <p>合同状态</p>
                    <ul>
                        <li @click="chooseState(1)" :class="{'active':contractState == 1}">全部</li>
                        <li @click="chooseState(2)" :class="{'active':contractState == 2}">执行中</li>
                        <li @click="chooseState(3)" :class="{'active':contractState == 3}">已完成</li>
                    </ul>
                </div>
                <div class="conlist yuqiState">
                    <p>逾期状态</p>
                    <ul>
                        <li @click="chooseYuqiState(1)" :class="{'active':yuqiState == 1}">全部</li>
                        <li @click="chooseYuqiState(2)" :class="{'active':yuqiState == 2}">逾期</li>
                        <li @click="chooseYuqiState(3)" :class="{'active':yuqiState == 3}">未逾期</li>
                    </ul>
                </div>
                <div class="sures">
                    <div>
                        <span @click="clearShaixuan" class="suresInit">重置</span>
                    </div>
                    <div>
                        <span @click="sureShaixuan" class="suresOk">确定</span>
                    </div>
                </div>
            </div>
            <div v-show="showPaixu" class="paixu">
                <p @click="changePaixu(1)">
                    最近更新
                    <i class="icon iconfont" v-show="showDuihao==1">&#xe614;</i>
                </p>
                <p @click="changePaixu(2)">
                    最近创建
                    <i class="icon iconfont" v-show="showDuihao==2">&#xe614;</i>
                </p>
                <p @click="changePaixu(3)">
                    合同金额正序
                    <i class="icon iconfont" v-show="showDuihao==3">&#xe614;</i>
                </p>
                <p @click="changePaixu(4)">
                    合同金额倒序
                    <i class="icon iconfont" v-show="showDuihao==4">&#xe614;</i>
                </p>
                <p @click="changePaixu(5)">
                    应收余额正序
                    <i class="icon iconfont" v-show="showDuihao==5">&#xe614;</i>
                </p>
                <p @click="changePaixu(6)">
                    应收余额倒序
                    <i class="icon iconfont" v-show="showDuihao==6">&#xe614;</i>
                </p>
            </div>
        </div>
        <div class="itemBox" v-for="(item,key) in contractList" v-show='isShow(item) >= 0 && shaixuan(item)' @click="toInfo(item.id)">
            <div class="itemlist itemProject">
                <span>{{item.contract_name}}</span>
                <span>{{item.contract_date}}</span>
            </div>
            <div class="itemlist itemCustom">
                <span>{{item.company_name}}</span>
            </div>
            <div class="itemlist itemShebei">
                <span v-for="items,keys in item.label_name">{{items.label_name}}</span>
            </div>
            <div class="itemlist itemContract">
                <span>合同金额：{{item.contract_money | numberFormat}}</span>
            </div>
            <div class="itemlist itemYsye">
                <span>应收余额：{{(item.contract_money - item.verification_money) | numberFormat}}</span>
                <span class="zhixinging">执行中</span>
            </div>
            <div class="line"></div>
            <div class="itembottom">
                <span><i class="icon iconfont">&#xe65f;</i>45</span>
                <span class="active"><i class="icon iconfont">&#xe69e;</i>45</span>
            </div>
        </div>
    </div>
</template>
<script>
    import searchInput from '../../components/searchInput/searchInput1.vue'
    export default{
        data(){
            return {
                showSearch: false,//搜索显示
                showShaixuan: false,//显示筛选
                showPaixu: false,//显示排序
                showguolv: true,//显示过滤所有
                showDuihao: 0,//排序显示对勾
                searchVal: '',
                contractList: [],
                //筛选需求数据
                dateSelectIndex : 1,
                contractState : 1,//1 全部
                yuqiState : 1,
                shaixuanData : [],
            }
        },
        components: {
            searchInput
        },
        mounted(){
            this.initData().then(res => {
                this.contractList = res.data
            }).catch(err => {
                this.I(err)
            })
        },
        methods: {
            initData(){
                return this.$http('GET', '/contract/get_contract_list.php')
            },
            isShow(item){
                return JSON.stringify(item).indexOf(this.searchVal);
            },
            search(val){
                this.searchVal = val
            },
            hideSearch(){
                this.showSearch = false
                this.showguolv = true
                this.searchVal = ''
            },
            showSear(){
                this.showSearch = true;
                this.showguolv = false;
                this.showShaixuan = false;
                this.showPaixu = false;
            },
            showSx(){
                this.showShaixuan = !this.showShaixuan;
                this.showPaixu = false;
            },
            showPx(){
                this.showPaixu = !this.showPaixu;
                this.showShaixuan = false;
            },
            changePaixu(num){
                this.showDuihao = num
                let _this = this
                setTimeout(function () {
                    _this.showPaixu = false;
                }, 100)
            },
            toInfo(id){
                this.$router.push('/contractInfo/' + id)
            },
            //筛选功能
            chooseDate(index){
                this.dateSelectIndex = index
            },
            chooseState(index){
                this.contractState = index
            },
            chooseYuqiState(index){
                this.yuqiState = index
            },
            shaixuan(item){
                let err = [];
                
                let nowDate = this.getNowDate(); //当前时间
                let conDate = item.contract_date; //合同时间
                
                let one = this.shaixuanData[0]
                let two = this.shaixuanData[1]
                let three = this.shaixuanData[2]
                if(one != 1){
                    if(one == 2){
                        if(nowDate != conDate){
                            err.push('err')
                        }
                    }
                    if(one == 3){
                        let d = new Date().getDay() == 0 ? '6' : (new Date().getDay()-1)//0-6 => 星期1-7
                        if(this.getNowDate(Date.now()-d*24*60*60*1000) > conDate || conDate>this.getNowDate(Date.now()+(7-d)*24*60*60*1000)){
                            err.push('err')
                        }
                    }
                    if(one == 4){
                        if(nowDate.slice(0,7) != conDate.slice(0,7)){
                            err.push('err')
                        }
                    }
                    if(one == 5){
                    
                    }
                    if(one == 6){
                        if(nowDate.slice(0,4) != conDate.slice(0,4)){
                            err.push('err')
                        }
                    }
                }
                if(two != 1){
                    if(two == 2){
                    
                    }
                }
                return err.length>0 ? false : true
            },
            sureShaixuan(){
                this.shaixuanData[0] = this.dateSelectIndex
                this.shaixuanData[1] = this.contractState
                this.shaixuanData[2] = this.yuqiState
                this.showShaixuan = false
            },
            clearShaixuan(){
                this.dateSelectIndex = 1
                this.contractState = 1
                this.yuqiState = 1
                this.shaixuanData = []
                this.showShaixuan = false
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
    @import "../../assets/main.scss";
    
    #contract {
        padding-bottom: 3rem;
        #model {
            position: fixed;
            width: 100%;
            height: 100%;
            background: $bgOpcity;
            z-index: 11;
        }
        .contractTop {
            position: relative;
            width: 100%;
            height: 1rem;
            background-color: #fff;
            padding: 0.35rem 0;
            display: flex;
            z-index: 12;
            .paixu {
                background-color: #fff;
                width: 100%;
                position: absolute;
                left: 0;
                top: 1.7rem;
                border-top: 1px solid #dee7f1;
                p {
                    padding: 0.5rem 0.8rem;
                    border-bottom: $qianStyle;
                    i {
                        float: right;
                        font-size: 1rem;
                        color: #3891f9;
                    }
                }
            }
            .shaixuan {
                background-color: #fff;
                width: 100%;
                position: absolute;
                left: 0;
                top: 1.7rem;
                border-top: 1px solid #dee7f1;
                z-index: 12;
                .conlist {
                    padding: 0.5rem 0.5rem 0.2rem;
                    p {
                        font-size: 0.65rem;
                        color: #222;
                    }
                    ul {
                        padding-top: 0.3rem;
                        overflow: hidden;
                        li {
                            float: left;
                            list-style: none;
                            padding: 0.1rem 0.4rem;
                            border: 1px solid #dee7f1;
                            font-size: 0.6rem;
                            margin-bottom: 0.3rem;
                            margin-right: 0.5rem;
                            color: #555;
                        }
                        li.active {
                            color: #fff;
                            background-color: #3891f9;
                        }
                    }
                }
                .sures {
                    width: 100%;
                    border-top: 1px solid #dee7f1;
                    padding: 0.55rem 0;
                    margin-top: 0.4rem;
                    display: flex;
                    div {
                        width: 50%;
                        text-align: center;
                        span {
                            width: 100px;
                            border: 1px solid #3891f9;
                            padding: 0.1rem 0.8rem;
                            border-radius: 0.1rem;
                        }
                        .suresInit {
                            color: #3891f9;
                        }
                        .suresOk {
                            color: #fff;
                            background-color: #3891f9;
                        }
                    }
                    div:first-child {
                        border-right: 1px solid #dee7f1;
                    }
                    
                }
            }
            span {
                color: #97a8be;
                flex-grow: 1;
                text-align: center;
                border-right: 1px solid #e7eef7;
            }
            span:last-child {
                border: none;
            }
        }
        .itemBox {
            position: relative;
            font-size: 0.7rem;
            margin-top: 0.5rem;
            padding: 0 0.5rem;
            background-color: #fff;
            overflow: hidden;
            .itemlist {
                padding: 0.2rem 0 0.1rem 0;
            }
            .itemProject {
                display: flex;
                span {
                    flex-grow: 1;
                }
                span:first-child {
                    font-size: 0.7rem;
                    color: #0c1c2c;
                }
                span:last-child {
                    font-size: 0.65rem;
                    text-align: right;
                    color: #97a8be;
                }
            }
            .itemCustom {
                span {
                    font-size: 0.6rem;
                    color: #5a6879;
                }
            }
            .itemShebei {
                span {
                    display: inline-block;
                    padding: 0 5px;
                    margin-right: 0.2rem;
                    background-color: #E3EFFF;
                }
            }
            .itemContract {
                span {
                    color: #333;
                    font-size: 0.65rem;
                }
            }
            .itemYsye {
                position: relative;
                span {
                    color: #5a6879;
                    font-size: 0.6rem;
                }
                .zhixinging {
                    position: absolute;
                    right: 0.1rem;
                    bottom: 0.3rem;
                    width: 2.75rem;
                    height: 0.9rem;
                    text-align: center;
                    line-height: 0.9rem;
                    border-radius: 0.45rem;
                    border: 1px solid #3891f9;
                    color: #3891f9;
                }
            }
            .itembottom {
                margin: 0.5rem -0.5rem 0;
                border-top: 1px solid #e7eef7;
                line-height: 1.4rem;
                padding: 0 0.5rem;
                overflow: hidden;
                span {
                    float: right;
                    font-size: 0.5rem;
                    width: 20%;
                    text-align: center;
                    color: #999999;
                    i {
                        margin-right: 0.3rem;
                        font-size: 0.7rem;
                        color: #999999;
                    }
                }
                span:first-child {
                    i {
                        font-size: 0.65rem;
                    }
                }
                .active {
                    i {
                        color: $mainColor;
                    }
                }
            }
        }
    }
</style>
