<template>
    <!-- 	<div>
            <kuangjia v-if="data.contract_type==3" :data="data"></kuangjia>
            <zhouqi   v-if="data.contract_type==2" :data="data"></zhouqi>
            <putong   v-if="data.contract_type==1" :data="data"></putong>
        </div> -->
    <div class="contract detail">
        <div class="container-fluid">
            <div class="title"><h4>基本信息</h4></div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同名称</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.contract_name">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同编号</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.contract_number">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">客户名称</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.custom_name">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同标签</div>
                    <div class="col-xs-9 hetong" >
                        <span v-for="(item,key) in data.label">{{item.label_name}}</span>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同日期</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.contract_date">
                    </div>
                </div>
            </div>
            <div class="container" v-if="data.contract_type==1">
                <div class="row">
                    <div class="col-xs-3">合同金额</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.contract_money">
                    </div>
                </div>
            </div>
            <div class="container" v-if="data.contract_type!=1">
                <div class="row">
                    <div class="col-xs-3">到期日期</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.maturity_date">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid" v-if="data.contract_type==2">
            <div class="title"><h4>回款信息</h4></div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">回款方式</div>
                    <div class="col-xs-9">
                        <select>
                            <option v-if="data.payment_cycle==1">每月</option>
                            <!-- <option v-if="data.payment_cycle==1">每周</option> -->
                            <option v-if="data.payment_cycle==3"> 每年</option>
                            <option v-if="data.payment_cycle==2">每季度</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">首次回款日期</div>
                    <div class="col-xs-9">
                        <input type="date" disabled :value="data.first_date_payment">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">每期金额</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.each_money">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">回款期次</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.cycle+'期'">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同金额</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.contract_money">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid" v-if="data.contract_type==3">
            <div class="title"><h4>回款信息</h4></div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">回款方式</div>
                    <div class="col-xs-9">
                        <select>
                            <option>每月</option>
                            <option>每年</option>
                            <option>每季度</option>
                            <option>每周</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">预收款</div>
                    <div class="col-xs-9">
                        <input type="text" disabled value="￥30000.00">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="title"><h4>联系信息</h4></div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">联系人</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.linkman">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">联系电话</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.tel">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">负责人</div>
                    <div class="col-xs-9 genjinren">
                        <input v-show="false" type="text" disabled placeholder="请选择负责人">
                        <p>
                            <span>{{data.followusername}}</span>
                            <span>{{data.followdepartname}}</span>
                        </p>
                        <i v-show="false" class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="title"><h4>附加信息</h4></div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">产品信息</div>
                    <div class="col-xs-9">
                        <input type="text" disabled value="KT1707,Kt-029,">
                        <i class="icon iconfont">&#xe681;</i>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">备注</div>
                    <div class="col-xs-9">
                        {{data.remark}}
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">附件</div>
                    <div class="col-xs-9">
                        <div class="file">
                            <div class="col-xs-4" v-for="(item,key) in data.files">
                                <div>
                                    <img :src="item.src" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="title"><h4>其他信息</h4></div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">创建时间</div>
                    <div class="col-xs-9">
                        <input type="text" disabled :value="data.creattime">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">创建人</div>
                    <div class="col-xs-9">
                        <input type="" disabled :value="data.creatname">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid" v-if="data.contract_type==3">
            <div class="title"><h4>增加项信息</h4></div>
            <p>2017-08-01新增合同款</p>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同金额</div>
                    <div class="col-xs-9">
                        <input type="text" disabled value="￥5620.00">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">计划收款时间</div>
                    <div class="col-xs-9">
                        <input type="date" disabled value="2017-08-01">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">备注</div>
                    <div class="col-xs-9">
                        {{data.remark}}
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">附件</div>
                    <div class="col-xs-9">
                        <div class="file">
                            <div class="col-xs-4" v-for="(item,key) in data.files">
                                <div>
                                    <img :src="item.src" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p>2017-08-01新增合同款</p>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">合同金额</div>
                    <div class="col-xs-9">
                        <input type="text" disabled value="￥5620.00">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">计划收款时间</div>
                    <div class="col-xs-9">
                        <input type="date" disabled value="2017-08-01">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">备注</div>
                    <div class="col-xs-9">
                        {{data.remark}}
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xs-3">附件</div>
                    <div class="col-xs-9">
                        <div class="file">
                            <div class="col-xs-4" v-for="(item,key) in data.files">
                                <div>
                                    <img :src="item.src" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {host, imghost} from '../../../../config/config.js'
    import {mapState} from 'vuex'
    // import kuangjia from './classifyDetail/kuangjia.vue'
    // import putong from './classifyDetail/putong.vue'
    // import zhouqi from './classifyDetail/zhouqi.vue'
    export default{
        data(){
            return {
                host,
                imghost,
                data: {},
            }
        },
        // components:{
        // 	kuangjia,
        // 	putong,
        // 	zhouqi,
        // },
        mounted(){
            this.initData()
        },
        methods: {
            initData(){
                this.$http('GET', '/contract/get_contract_details.php?id=' + this.$route.params.id).then(res => {
                    this.data = res.data
                })
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../../assets/main.scss";

</style>
