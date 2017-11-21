<template>
    <div>
        <div class="selectTab">
            <div :class="{'active':showZiliao}"><p @click="changeShow(true)"><span>详细资料</span></p></div>
            <div :class="{'active':!showZiliao}"><p @click="changeShow(false)"><span>合同信息</span></p></div>
        </div>
        <div class="tabCont">
            <div v-show="showZiliao" class="ziliao">
                <div class="title"><h3>基本信息</h3></div>
                <div class="container">
                    <div class="headPortrait">
                        <img class="img" v-if="companyinfo.logo" :src="host+companyinfo.logo" alt="">
                        <img class="img" v-else :src="imghost+'logo_defaullt@2x.png'" alt="">
                    </div>
                    <div class="row">
                        <div class="col-xs-3">客户名称</div>
                        <div class="col-xs-7">{{companyinfo.custom_name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">客户编号</div>
                        <div class="col-xs-7">{{companyinfo.custom_number}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">客户性质</div>
                        <div class="col-xs-9" v-if="companyinfo.custom_nature==1">个人</div>
                        <div class="col-xs-9" v-if="companyinfo.custom_nature==2">企业</div>
                        <div class="col-xs-9" v-if="companyinfo.custom_nature==3">政府事业单位</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-3">所属行业</div>
                        <div class="col-xs-9">{{companyinfo.industry_name}}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-3">办公地址</div>
                        <div class="col-xs-9">{{companyinfo.bangongdizhi}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">负责人</div>
                        <div class="col-xs-9 personnel">
                            <div v-for="(item,key) in companyinfo.follows">
                                <img class="img" v-if="item.ding_avatar" :src=item.ding_avatar alt="">
                                <img class="img" v-else :src="imghost+'logo_defaullt@2x.png'" alt="">
                                <p>{{item.realname}}</p>
                                <p>{{item.dapart_name}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="title"><h3>开票信息</h3></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">发票抬头</div>
                        <div class="col-xs-7">{{companyinfo.fapiaotaitou}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">纳税人识别号</div>
                        <div class="col-xs-7">{{companyinfo.payer_id}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">开户银行</div>
                        <div class="col-xs-9">{{companyinfo.bank_name}}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-3">地址</div>
                        <div class="col-xs-9">{{companyinfo.address}}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-xs-3">电话</div>
                        <div class="col-xs-9">{{companyinfo.tel}}</div>
                    </div>
                </div>
                <div class="title"><h3>其他信息</h3></div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">创建时间</div>
                        <div class="col-xs-7">{{companyinfo.add_time}}</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-3">创建人</div>
                        <div class="col-xs-7">{{companyinfo.realname}}</div>
                    </div>
                
                </div>
            </div>
            <div v-show="!showZiliao" class="xinxi">
                <div v-for="contract in companyinfo.contract_list" class="container">
                    <div class="col-xs-8">
                        <h3>{{contract.contract_name}}</h3>
                        <p>{{contract.custom_name}}</p>
                        <p>合同金额(元)：<span>{{contract.contract_money | numberFormat}}</span></p>
                        <p>应收余额(元)：<span>{{contract.contract_money - contract.verification_money | numberFormat}}</span>
                        </p>
                    </div>
                    <div class="col-xs-4">
                        <p>{{contract.contract_date}}</p>
                        <p>执行中</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {host, imghost} from '../../../config/config.js'
    import ccl from '../../../common/ccl.js'
    import {mapMutations} from 'vuex'
    export default{
        data(){
            return {
                showZiliao: true,
                companyinfo: {},
                host,
                imghost,
            }
        },
        mounted(){
            
            const customid = this.$route.params.customid
            const _this = this
            this.CLEARCUSTOM()
            ccl.setMenu({
                items: [
                    {
                        "id": "1",
                        "iconId": "trash",
                        "text": "删除"
                    },
                    {
                        "id": "2",
                        "iconId": "edit",
                        "text": "编辑"
                    }
                ],
                onSuccess: function (data) {
                    if (data.id == 1) {
                        let arr = [];
                        arr.push(customid)
                        _this.deletecompany(JSON.stringify(arr))
                    }
                    else if (data.id == 2) {
                        _this.editcompany(customid)
                    }
                }
            })
            this.getcompanyinfo(customid).then(res => {
                this.companyinfo = res.data
            })
        },
        methods: {
            ...mapMutations([
                "CLEARSELECTCUSROM",'SETEDITCONTRACT','CLEARCUSTOM','SETLINKMAN'
            ]),
            changeShow(bol){
                this.showZiliao = bol;
            },
            getcompanyinfo(customid){
                return this.$http('POST', '/custom/get_custom_info.php', {'custom_id': customid})
            },
            deletecompany(customid){
                this.$http('POST', '/custom/delete_custom.php', {'custom_id': customid}).then(res => {
                    if (res.code == 0) {
                        ccl.toast({text: '删除成功'})
                        this.$router.replace('/customer')
                    } else {
                    
                    }
                })
            },
            editcompany(customid){
                this.SETLINKMAN([])
                this.$router.push({
                    path: '/editCustom',
                    query: {
                        id: customid
                    }
                })
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    @import "../../../assets/main";
    
    .selectTab {
        background: $baiColor;
        border-bottom: $borderStyle;
        overflow: hidden;
        padding: 0.5rem 0;
        div {
            float: left;
            width: 50%;
            text-align: center;
            line-height: 1.2rem;
            p {
                span {
                    font-size: 0.75rem;
                    color: #222222;
                }
            }
            
        }
        .active {
            p {
                span {
                    color: $mainColor;
                }
            }
        }
        div:first-child p {
            border-right: $borderStyle;
        }
    }
    
    .tabCont {
        .ziliao {
            background: $baiColor;
            .title {
                padding: 0.5rem 10px;
                border-bottom: $borderStyle;
                h3 {
                    padding-left: 5px;
                    border-left: 2px solid $mainColor;
                    color: $hColor;
                    line-height: 0.75rem;
                    font-size: 0.75rem;
                }
            }
            .container {
                position: relative;
                .row {
                    margin-left: 8px;
                    padding: 0.5rem 0;
                    overflow: hidden;
                    font-size: 0.7rem;
                    border-bottom: $borderStyle;
                    .col-xs-3 {
                        color: #97a8b3;
                    }
                    .col-xs-6, .col-xs-9 {
                        color: #222222;
                    }
                    .personnel {
                        div {
                            float: left;
                            margin: 0 0.3rem;
                            text-align: center;
                            img {
                                border-radius: 50%;
                                width: 1.8rem;
                                height: 1.8rem;
                            }
                        }
                    }
                }
                .headPortrait {
                    position: absolute;
                    right: 10px;
                    top: 10px;
                    padding-left: 0.3rem;
                    background: $baiColor;
                    img {
                        width: 3rem;
                        height: 3rem;
                        border: $borderStyle;
                        border-radius: 50%;
                    }
                }
                
            }
            .container:last-child .row:last-child {
                border: 0;
            }
        }
        .xinxi {
            .container {
                background: $baiColor;
                border-bottom: $borderStyle;
                overflow: hidden;
                position: relative;
                .col-xs-8 {
                    padding: 4px 5px;
                    h3 {
                        color: $hColor;
                        font-size: 0.75rem;
                        line-height: 1.2rem;
                    }
                    p {
                        color: #5a6b79;
                        font-size: 0.7rem;
                        line-height: 1.1rem;
                        span {
                            color: $mainColor;
                        }
                    }
                }
                .col-xs-4 {
                    padding: 4px 5px;
                    text-align: right;
                    p {
                        color: #5a6b79;
                        font-size: 0.7rem;
                    }
                    p:nth-child(2) {
                        position: absolute;
                        bottom: 8px;
                        right: 1rem;
                        display: inline-block;
                        padding: 0 10px;
                        border-radius: 10px;
                        border: 1px solid $mainColor;
                        color: $mainColor;
                    }
                }
            }
        }
    }
</style>
