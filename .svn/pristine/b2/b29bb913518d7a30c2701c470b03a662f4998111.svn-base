<template>
    <div class="wrap">
        <div class="main-content">
            <div class="header">
            	<div class="row">
	                <div class="left">
	                    <input class="xinjian" @click="showXinjian" type="button" value="新建">
	                    <span class="port"><i class="icon iconfont">&#xe6d9;</i>导入</span>
	                    <span class="port"><i class="icon iconfont">&#xe60d;</i>导出</span>
	                    <span @click="del_chooseId" class="port dele"><i class="icon iconfont">&#xe601;</i>删除</span>
	                </div>
	                <div class="right">
	                    <div class="searchInput">
	                        <input type="search" v-model="searchVal" placeholder="请输入搜索内容...">
	                        <i class="icon iconfont">&#xe637;</i>
	                    </div>
	                </div>
	            </div>
            </div>
            <div class="middle customer">
                <table>
                    <thead>
                    <tr>
                        <th><input @click="changeAll" :checked="isShowall" type="checkbox"></th>
                        <th>客户名称</th>
                        <th>客户行业</th>
                        <th>客户性质</th>
                        <th>创建时间<i class="icon iconfont">&#xe60e;</i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,key) in customData" @click="showDetail(item.id)">
                        <td @click.stop><input :checked="chooseId.indexOf(item.id)>=0" @click="changeId(item.id)" type="checkbox"></td>
                        <td>{{item.custom_name}}</td>
                        <td>{{item.industry_name}}</td>
                        <td>{{item.custom_nature == 1 ? '个人' : item.custom_nature == 2 ? '企业' :item.custom_nature == 3 ? '政府事业单位' : ''}}</td>
                        <td>{{item.add_time}}</td>
                    </tr>
                    
                    </tbody>
                </table>
            </div>
            <div class="line"></div>
            <div class="bottom">
                <div class="left">
                    总计: <span>6</span>个
                </div>
                <div class="right">
                    <p>共{{customData.length}}条</p>
                    <ul>
                        <li><i class="icon iconfont">&#xe61c;</i></li>
                        <li class="active">1</li>
                        <li>2</li>
                        <li>3</li>
                        <li>4</li>
                        <li>5</li>
                        <li>...</li>
                        <li>9</li>
                        <li>10</li>
                        <li><i class="icon iconfont">&#xe61d;</i></li>
                    </ul>
                    <p>前往<input type="text" value="1">页</p>
                </div>
            </div>
        </div>
        <!-- 客户详细信息部分弹框 -->
        <customerInfo @hideAll="hideAlls" @closeDetail="hideDetail" :id="detailId" v-if="showDetails"></customerInfo>
        <!-- 新建客户弹框 -->
        <newCustomer @closeNewContract="hiddenNewContract" @newCustomData="sendWithUrl" @hideModel="hideNewcustom" v-if="showNewcustom"></newCustomer>
    </div>
</template>

<script>
    import {mapState, mapMutations} from 'vuex'
    import {host, imghost} from '../../config/config.js'
    import customerInfo from './customerInfo/customerInfo.vue'
    import newCustomer from './newCustomer/newCustomer.vue'
    export default{
        data(){
            return {
                host,
                imghost,
                allData:[],
                chooseId : [],
                searchVal : '',
                showNewcustom : false,
                showDetails : false,
                detailId: '',
            }
        },
        computed:{
            customData(){
                let arr = [];
                let val = this.searchVal;
                this.allData.map((item)=>{
                    if(item.custom_name.indexOf(val)>=0){
                        arr.push(item)
                    }
                })
                return arr
            },
            isShowall(){
                let objVal = []
                this.customData.map((item)=>{
                    return objVal.push(item.id)
                })
                let aa = 1;
                for(let i=0;i<objVal.length; i++){
                    if(this.chooseId.indexOf(objVal[i])<0){
                        aa = 2
                    }
                }
                return aa == 1 ? true : false
                
            }
        },
        mounted(){
            this.initData()
        },
        components: {
            customerInfo,
            newCustomer
        },
        methods: {
            initData(){
                this.$http("GET", '/custom/get_custom_list.php').then(res => {
                    if(res.code == 0){
                        this.allData = res.data
                    }else{
                        this.layer.alert(res.msg)
                    }
                }).catch(err => {
                
                })
            },
            sendWithUrl(val){
                this.allData = val
                this.showNewcustom = false;
            },
            hideNewcustom(){
                this.showNewcustom = false;
            },
            showXinjian(){
                this.showNewcustom = true;
            },
            showDetail(id){
                this.detailId = id;
                this.showDetails = true;
            },
            del_chooseId(){
                let ids = JSON.stringify(this.chooseId);
                if(ids != []){
                    this.$http('POST','/custom/delete_custom.php',{custom_id:ids}).then(res=>{
                        this.allData = res.data
                    }).catch(err=>{
        
                    })
                }
            },
            hideDetail(val){
                if(val){
                    this.allData = val
                }
                this.showDetails = false
            },
            hideAlls(val){
                this.I(val)
                this.allData = val
                this.showDetails = false
            },
            changeAll(e){
                if(e.target.checked == true){
                    this.chooseId = []
                    this.customData.map((item)=>{
                        return this.chooseId.push(item.id)
                    })
                }else{
                    this.chooseId = []
                }
            },//全选
            changeId(id){
                if(this.chooseId.indexOf(id)>-1){
                    this.chooseId.splice(this.chooseId.indexOf(id),1)
                }else{
                    this.chooseId.push(id)
                }
            },//单选
            hiddenNewContract(){
                this.showNewcustom = false;
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
    @import "../../assets/main.scss";
    
    .customer {
        table {
            thead {
                th {
                
                }
            }
            tbody {
                tr {
                    td {
                        text-align: center;
                    }
                    td:nth-child(2), td:nth-child(3) {
                        text-align: left;
                        padding-left: 50px;
                    }
                    td:nth-child(3), td:nth-child(4), td:nth-child(5) {
                        width: 200px;
                    }
                }
            }
        }
    }

</style>
