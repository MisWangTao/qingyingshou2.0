<template>
    <div id="newCustom">
        <div class="container-fluid">
            <div class="headPortrait">
                <img class="img" :src='editCustom.logo' alt="">
                <i class="icon iconfont">&#xe638;</i>
                <input type="file" @change="filechange" ref='file'/>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3"><span>*</span>客户名称</div>
                    <div class="col-xs-6"><input v-model="editCustom.custom_name" type="text" placeholder="请输入客户名称">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">客户编号</div>
                    <div class="col-xs-6"><input v-model="editCustom.custom_number" type="text" placeholder="请输入客户编号">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">客户性质</div>
                    <div class="col-xs-9">
                        <select style="border:none" v-model="editCustom.custom_nature">
                            <option value="1">个人</option>
                            <option value="2">企业</option>
                            <option value="3">政府事业单位</option>
                        </select>
                        <i class="icon iconfont">&#xe681;</i></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">所属行业</div>
                    <div class="col-xs-9"><input type="text" @click='showcustomindustry' v-model="editCustom.industry_name"
                                                 readonly placeholder="请选择所属行业"><i class="icon iconfont">&#xe681;</i>
                    </div>
                
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">办公地址</div>
                    <div class="col-xs-9"><input v-model="editCustom.bangongdizhi" type="text" placeholder="请输入客户办公地址">
                    </div>
                </div>
            </div>
            <!-- <div class="container">
                <div class="row">
                    <div class="col-xs-3">回款方式</div>
                    <div class="col-xs-9"><input type="text" disabled placeholder="请选择回款方式"></div>
                    <i class="jiantou"></i>
                </div>
            </div> -->
        </div>
        <div class="container-fluid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">负责人</div>
                    <div class="col-xs-9 personnel">
                        <div v-for="(item,key) in selectLinkman">
                            <p>{{item.realname}}</p>
                            <p>{{item.ding_name}}</p>
                            <i @click="delLinkman(key)" v-show="showDel" class="icon iconfont">&#xe60a;</i>
                        </div>
                        <div @click="chooseLinkman">
                            <img :src="imghost+'tianjia@2x.png'" alt="添加">
                        </div>
                        <div @click="changeShow">
                            <img :src="imghost+'shanchu@2x.png'" alt="删除">
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="container">
                <div class="row switch" @click="changeShowAll">
                    <div class="col-xs-3">开票信息</div>
                    <div class="col-xs-9 text-right">纳税人识别号等信息<b
                        :class="{'jiantou1':!showkaipiao,'jiantou2':showkaipiao}"></b></div>
                </div>
            </div>
            <div class="kaipiao" v-show="showkaipiao">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">发票抬头</div>
                        <div class="col-xs-9"><input v-model="editCustom.fapiaotaitou" type="text"
                                                     placeholder="请输入发票抬头"></div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">纳税人识别号</div>
                        <div class="col-xs-9"><input v-model="editCustom.payer_id" type="text" placeholder="请输入纳税人识别号">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">开户银行</div>
                        <div class="col-xs-9"><input v-model="editCustom.bank_name" type="text" placeholder="请输入开户银行">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">银行账号</div>
                        <div class="col-xs-9"><input v-model="editCustom.bank_account_number" type="text" placeholder="请输入银行账号">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">地址</div>
                        <div class="col-xs-9"><input v-model="editCustom.address" type="text" placeholder="请输入地址"></div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-3">电话</div>
                        <div class="col-xs-9"><input v-model="editCustom.tel" type="text" placeholder="请输入电话"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="btn">
            <button @click="sendData">确定</button>
        </div>
    </div>
</template>
<script>
    import {mapState, mapMutations} from 'vuex'
    import {host, imghost} from '../../../../config/config.js'
    import ccl from '../../../../common/ccl.js'
    export default{
        data(){
            return {
                showkaipiao: true,
                host,
                imghost,
                customnature: '',
                customindustry: '',
                showDel : false,
            }
        },
        mounted(){
            const _this = this
            ccl.setMenu({
                items: [
                    {
                        "id": "1",
                        "iconId": "scan",
                        "text": "扫名片"
                    }
                ],
                onSuccess: function (data) {
                    ccl.scanCard({
                        onSuccess: function (data) {
                            _this.SETEDITCUSTOM({
                                company_name: data.COMPANY,
                                invoice_header: data.COMPANY,
                                company_address: data.ADDRESS
                            })
                        }
                    })
                },
            })
            this.initData().then(res=>{
                let newObj = this.editCustom && this.editCustom.hasData == 1 ? this.editCustom :  res.data;
                let aa= newObj.custom_nature == 1 ? '个人' : newObj.custom_nature == 2 ? '企业' :
                    newObj.custom_nature == 3 ?'政府事业单位' : ''
                let industry_name = this.selectIndustry.industry_name ? this.selectIndustry.industry_name : newObj.industry_name
                let industry_id = this.selectIndustry.industry_id ? this.selectIndustry.industry_id : newObj.industry_id
                newObj.industry_name = industry_name
                newObj.industry_id = industry_id
                newObj.custom_natureName = aa
                newObj.logo = (this.editCustom && this.editCustom.logo)? this.editCustom.logo : (this.host + res.data.logo)
                newObj.hasData = 1;
                if(this.editCustom.hasData != 1){
                    let arrs = this.selectLinkman
                    for(let i=0;i<res.data.follows.length; i++){
                        let obj={};
                        obj.ding_id = res.data.follows[i].depart_id
                        obj.ding_name = res.data.follows[i].dapart_name
                        obj.id = res.data.follows[i].user_id
                        obj.realname = res.data.follows[i].realname
                        arrs.push(obj)
                    }
                    this.SETLINKMAN(arrs)
                    this.SETEDITCUSTOM(newObj)
                }else{
                    let objs = this.editCustom
                    objs.industry_name = industry_name
                    objs.custom_natureName = aa
                    this.SETEDITCUSTOM(objs)
                }
            }).catch(err=>{
                this.I(err)
            })
            
        },
        computed: {
            ...mapState([
                'editCustom','selectIndustry','selectLinkman'
            ])
        },
        methods: {
            ...mapMutations([
                'SETEDITCUSTOM','SETLINKMAN'
            ]),
            initData(){
                let customId = this.$route.query.id
                return this.$http('POST','/custom/get_custom_info.php',{'custom_id':customId})
            },
            changeShowAll(){
                this.showkaipiao = !this.showkaipiao
            },
            changeShow(){
                this.showDel = !this.showDel
            },
            filechange(event){
                event.preventDefault()
                
                const _this = this
                let target = event.target
                let file = target.files[0]
                // file.thumb = URL.createObjectURL(file)
                let reader = new FileReader()
                reader.readAsDataURL(file)
                reader.onload = function (e) {
                    let objs = _this.editCustom
                    objs.logo = e.target.result
                    _this.I(e.target.result)
                    _this.SETEDITCUSTOM(objs)
                }
            },
            showcustomnature(){
                
                let _this = this
                let otherButtons = ['个人', '企业', '政府事业单位']
                ccl.actionSheet({
                    title: '请选择客户性质',
                    cancelButton: '取消',
                    otherButtons: otherButtons,
                    onSuccess: result => {
                        if (result.buttonIndex != -1) {
                            _this.editCustom.company_name = otherButtons[result.buttonIndex]
                            _this.editCustom.company_nature = result.buttonIndex + 1
                        }
                    }
                })
            },
            showcustomindustry(){
                this.$router.push('/selectIndustry')
            },
            sendData(){
                this.I(this.editCustom)
                this.$http('POST', '/custom/edit_custom_info.php', this.editCustom).then(response => {
                    if(response.code == 0){
                        this.$router.go(-2)
                    }else{
                        alert(response.msg)
                    }
                })
            },
            chooseLinkman(){
                this.$router.push('/selectLinkman')
            },
            delLinkman(key){
                let arr = this.selectLinkman
                arr.splice(key,1)
                console.log(arr)
                this.SETLINKMAN(arr)
            }
            
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../../assets/main";
    
    #newCustom {
        font-size: 0.7rem;
        .container-fluid {
            padding: 0;
            margin-bottom: 0.5rem;
            background: $baiColor;
            overflow: hidden;
            position: relative;
            .container {
                .row {
                    padding: 0.5rem 0;
                    overflow: hidden;
                    font-size: 0.7rem;
                    border-bottom: $qianStyle;
                    .col-xs-3 {
                        padding: 0 0 0 6px;
                        color: #97a8b3;
                        position: relative;
                        span {
                            position: absolute;
                            top: 0;
                            left: 0;
                            color: $redColor;
                        }
                    }
                    .col-xs-6, .col-xs-9 {
                        color: #222222;
                        input {
                            width: 100%;
                            border: 0;
                        }
                        i {
                            display: block;
                            float: right;
                            font-size: 0.7rem;
                            color: #97a8be;
                        }
                        b {
                            width: 0.5rem;
                            height: 0.5rem;
                            border-top: 2px solid #97a8be;
                            border-right: 2px solid #97a8be;
                            transform: rotate(45deg);
                            float: right;
                            margin-top: 0.2rem;
                            margin-right: 0.3rem;
                        }
                        .showall {
                            color: #bbb;
                            font-size: 0.6rem;
                            float: right;
                        }
                        .jiantou1 {
                            width: 0.4rem;
                            height: 0.4rem;
                            margin: 0 0.3rem;
                            transform: rotate(135deg);
                        }
                        .jiantou2 {
                            width: 0.4rem;
                            height: 0.4rem;
                            margin: 0.3rem 0.3rem;
                            transform: rotate(315deg);
                        }
                    }
                    .col-xs-9 {
                        input {
                            width: 90%;
                        }
                    }
                    .personnel {
                        div {
                            float: left;
                            margin: 0 0.3rem;
                            text-align: center;
                            position: relative;
                            i {
                                position: absolute;
                                right: 0;
                                top: 0;
                                font-size: 0.5rem;
                                color: $redColor;
                            }
                            img {
                                width: 1.8rem;
                                height: 1.8rem;
                                border-radius: 50%;
                            }
                            p:first-child {
                                margin: 0 auto;
                                width: 1.8rem;
                                height: 1.8rem;
                                background: #c3defd;
                                border-radius: 50%;
                                color: #222222;
                                line-height: 1.8rem;
                                text-align: center;
                                font-size: 0.5rem;
                                overflow: hidden;
                            }
                            p:nth-child(2) {
                                font-size: 0.6rem;
                                line-height: 1.4rem;
                                color: #666666;
                            }
                        }
                    }
                }
                .switch {
                    .col-xs-9 {
                        text-align: right;
                        color: #c0c0c0;
                    }
                }
            }
            .container:last-child .row {
                border: 0;
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
                    border-radius: 50%;
                    border: $borderStyle;
                }
                i {
                    position: absolute;
                    bottom: -0.2rem;
                    right: -0.2rem;
                    font-size: 1.3rem;
                    color: #a2a2a2;
                    z-index: 22;
                }
                input {
                    position: absolute;
                    bottom: -0.2rem;
                    right: -0.2rem;
                    width: 1.3rem;
                    height: 1.3rem;
                    color: #a2a2a2;
                    z-index: 33;
                    opacity: 0;
                }
            }
        }
        .btn {
            width: 80%;
            margin: 2rem auto;
            button {
                display: block;
                width: 100%;
                height: 1.6rem;
                text-align: center;
                border-radius: 8px;
                background-color: #1f8ae8;
                color: #fff;
                border: 0;
                font-size: 0.75rem;
                letter-spacing: 5px;
            }
        }
    }
</style>
