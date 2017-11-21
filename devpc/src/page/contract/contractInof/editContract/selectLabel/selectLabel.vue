<template>
    <div>
        <div class="centerModal htbqModal">
            <div class="modalInner">
                <div class="header">
                    <h3>合同标签</h3>
                    <i class="icon iconfont" @click="closeSelectLabel">&#xe60f;</i>
                </div>
                <div class="body">
                    <div class="selectCustomers">
                        <div @click="add_label">新建</div>
                        <span class="row" v-for="(item,key) in labelsMap"
                              @click="chooseLabelInfo(key,item.id,item.label_name)">
							<div class="col-xs-2" :class="{'active': isChooseStatus(item.id)}">{{item.label_name}}</div>
						</span>
                    </div>
                </div>
                <div class="footer">
                    <button @click="closeSelectLabel" class="btn cancel">取消</button>
                    <button class="btn confirm" @click="chooseLabels">确定</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState, mapMutations} from 'vuex'
    import {host, imghost} from '../../../../../config/config.js'
    export default{
        data(){
            return {
                host,
                imghost,
                labelsMap: [],
                labelName: [],
                labelId: [],
            }
        },
        props: ['labelData'],
        mounted(){
            this.getLabels()
        },
        methods: {
            //获取客户列表
            getLabels(){
                this.$http("GET", '/contract/get_contract_label.php').then(res => {
                    this.labelsMap = res.data
                }).catch(err => {
                
                })
            },
            //关闭
            closeSelectLabel(){
                this.$emit('closeSelectLabelss')
            },
            //发送至夫集组件
            chooseLabels(){
                
                
                this.$emit('ChoosedLabels',this.labelData)
                
            },
            add_label(){
            
            },
            //选择合同标签
            chooseLabelInfo(key, id, name){
                let index = -1
                
                for (let i = 0; i < this.labelData.length; i++) {
                    if (this.labelData[i].id == id) {
                        index = i
                    }
                }
                if (index == -1) {
                    let newObj = {}
                    newObj.id = id;
                    newObj.label_name = name
                    this.labelData.push(newObj)
                } else {
                    this.labelData.splice(index, 1)
                }
                // console.log(this.labelId)
            },
            //判断是否选中的状态
            isChooseStatus(id){
                if (this.labelData.length > 0) {
                    for (let i = 0; i < this.labelData.length; i++) {
                        if (this.labelData[i].id == id) {
                            return true
                        } else {
                        }
                    }
                    return false
                }
            },
        },
        watch: {
            labelData(){
            
            }
        }
        
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style lang="scss" scoped>
    @import "../../../../../assets/main";
    
    .selectCustomers {
        background: #ffffff;
        border-top: 2px solid $mainColor;
        .row {
            overflow: hidden;
            background: #f9f9f9;
            line-height: 34px;
            .col-xs-2 {
                text-align: center;
                width: 100px;
                margin: 0 10px;
                input {
                    vertical-align: middle;
                    display: inline-block;
                    width: 14px;
                    height: 14px;
                }
            }
            .col-xs-3:last-child {
                text-align: center;
            }
        }
        .row:first-child {
            background: #e9f2fa;
            height: 40px;
            line-height: 40px;
            border-bottom: $borderStyle;
            .col-xs-2 {
                height: 40px;
            }
        }
        .row:nth-child(2n) {
            background: #ffffff;
        }
        .active {
            background-color: skyblue;
        }
    }
</style>
