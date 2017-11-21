<template>
    <div id="payManage">
        <searchInput @searchVal="search"></searchInput>
        <div id="model" v-show="screenReceivable" @click="closescreenReceivable">
            <div id="screen">
                <i class="three"></i>
                <p>未核销</p>
                <p>已核销</p>
                <p>异常</p>
                <p>预收款</p>
                <p>退款</p>
            </div>
        </div>
        
        <div class="listbox" v-for="item,key in datalist" @click="showdetail(item)">
            <div class="itembox">
                {{item.custom_name}}
                <span class="itemSpan">
          {{item.arrival_date}}
        </span>
                <p>回款金额：￥{{item.arrival_amount | numberFormat}}</p>
            </div>
            <div
                :class="{wanchenging:true,yellowActive:item.states=='3',blueActive:item.states=='1',greenActive:item.states=='2',redActive:item.states=='4'}">
                <span v-show="item.states=='3'">异常</span>
                <span v-show="item.states=='4'">退款</span>
                <span v-show="item.states=='2'">已核销</span>
                <span v-show="item.states=='1'">未核销</span>
            </div>
        </div>
    
    </div>
</template>
<script>
    import searchInput from '../../../components/searchInput/searchInput.vue'
    import ccl from '../../../common/ccl.js'
    export default{
        data(){
            return {
                searchVal: '',
                datalist: [],
                screenReceivable:false,
            }
        },
        mounted(){

            let _this = this

            ccl.setMenu({
                items : [
                    {
                        "id":"1",
                        "iconId":"",
                        "text":"新建"
                    },
                    {
                        "id":"2",
                        "iconId":"",
                        "text":"筛选"
                    }
                ],
                onSuccess: function(data) {
                    if(data.id==1){
                        _this.newReceivable()
                    }
                    else if(data.id==2){
                        _this.choosescreenReceivable()
                    }
                }
            })

            this.getdatalist().then(res => {
                this.datalist = res.data
            })
        },
        components: {
            searchInput,
        },
        methods: {
            search(val){
                this.searchVal = val
            },
            getdatalist(){
                return this.$http('GET', '/receivables/get_receicalble_list.php')
            },
            choosescreenReceivable(){
                this.screenReceivable = !this.screenReceivable
            },
            newReceivable(){
                this.$router.push('/newReceivable')
            },
            showdetail(item){

                const id = item.id

                if(item.states=='1' || item.states=='2' || item.states=='3'){
                    this.$router.push('/paymentDetail/'+id)
                }
                else if(item.states=='4'){
                    this.$router.push('/refundDetails/'+id)
                }
            },
            closescreenReceivable(){
                this.screenReceivable = false
            }

        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../assets/main";
    
    #payManage {
        #model {
            position: fixed;
            top: 0;
            width: 100%;
            height: 100%;
            background: $bgOpcity;
            z-index: 1;
            #screen {
                width: 4.5rem;
                height: 6.45rem;
                position: absolute;
                right: 0.2rem;
                top: 0.3rem;
                background-color: #fff;
                .three {
                    position: absolute;
                    top: -0.28rem;
                    right: 1rem;
                    border-left: 0.3rem solid transparent;
                    border-right: 0.3rem solid transparent;
                    border-bottom: 0.3rem solid #fff;
                }
                p {
                    line-height: 1.25rem;
                    text-align: center;
                    color: #5a6879;
                    height: 1.25rem;
                    border-bottom: 1px solid #eee;
                }
                p:last-child {
                    border: none;
                }
            }
        }
        .listbox {
            color: #5a6879;
            position: relative;
            padding: 0 0.6rem;
            background-color: #fff;
            font-size: 0.7rem;
            .itembox {
                padding: 0.4rem;
                border-bottom:1px solid #e7eef7;
            }
            .wanchenging {
                position: absolute;
                right: 1rem;
                bottom: 0.5rem;
                width: 2.2rem;
                height: 0.8rem;
                font-size: 0.5rem;
                border-radius: 0.8rem;
                text-align: center;
                line-height: 0.8rem;
                span {
                    font-size: 0.5rem;
                }
            }
            .blueActive {
                color: #3891f9;
                border: 1px solid #3891f9;
            }
            .greenActive {
                color: #0dc356;
                border: 1px solid #0dc356;
            }
            .redActive {
                color: #de0101;
                border: 1px solid #de0101;
            }
            .yellowActive {
                color: #ff9c00;
                border: 1px solid #ff9c00;
            }
            .itemSpan {
                float: right;
                font-size: 0.6rem;
                color: #97a8be;
            }
            p {
                font-size: 0.65rem;
                color: #333;
                margin-top: 0.3rem;
            }
        }
    }
</style>
