<template>
    <div>
        <div class="labels">
            <p :class="{'active': inArr(item.id)}"
               v-for="(item,key) in labelData" @click="choose(item.id,item.label_name)">
                {{item.label_name}}</p>
        </div>
        <div class="addBtn">
            <span @click="showMod()">+添加标签</span>
        </div>
        
        <div class="btn">
            <button @click="go_back()">保存</button>
        </div>
        <!-- 添加标签部分弹框 -->
        <div class="modal" style="display:block" v-show="showModel">
            <div class="modalInner">
                <div class="modalHead">
                    <h4>添加标签</h4>
                    <i class="icon iconfont">&#xe60f;</i>
                </div>
                <div class="modalBody addLabel">
                    <input ref="newLabel" placeholder="自定义标签(最长5个字)"/>
                    <button @click="hideMod">确定</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    export default{
        data(){
            return {
                labelData: [],
                showModel: false,
            }
        },
        computed: {
            ...mapState([
                'newContract'
            ])
        },
        mounted(){
            this.initData().then(res => {
                this.labelData = res.data
            }).catch(err => {
                this.I(err)
            })
        },
        methods: {
            initData(){
                return this.$http('GET', '/contract/get_contract_label.php')
            },
            choose(id, labelName){
                let ind = -1;
                for (let i = 0; i < this.newContract.label.labelId.length; i++) {
                    if (this.newContract.label.labelId[i] == id) {
                        ind = i;
                    }
                }
                if (ind != -1) {
                    this.newContract.label.labelName.splice(ind, 1)
                    this.newContract.label.labelId.splice(ind, 1)
                } else {
                    this.newContract.label.labelName.push(labelName)
                    this.newContract.label.labelId.push(id)
                }
                console.log(this.newContract)
            },
            inArr(id){
                if (this.newContract.label.labelId.length > 0) {
                    for (let i = 0; i < this.newContract.label.labelId.length; i++) {
                        if (this.newContract.label.labelId[i] == id) {
                            return true
                        }
                    }
                    return false
                }
            },
            go_back(){
                this.$router.go(-1)
            },
            showMod(){
                this.showModel = true;
            },
            hideMod(){
                var val = this.$refs.newLabel.value;
                if (val.length > 5 ||val=='') {
                    return;
                }
                this.$http('POST', '/contract/add_contract_label.php', {'user_id': 1, 'label_name': val}).then(res => {
                    this.$refs.newLabel.value = ''
                    this.labelData = res.data
                }).catch(err => {
                    this.I(err)
                })
                this.showModel = false;
            }
        },
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    @import "../../../assets/main";
    
    .labels {
        padding: 10px;
        overflow: hidden;
        p {
            margin: 5px;
            display: inline-block;
            padding: 0 0.2rem;
            font-size: 0.7rem;
            border: 1px solid #9eabba;
            color: #555555;
            border-radius: 1px;
        }
        .active {
            background: $mainColor;
            color: $baiColor;
            border: 1px solid $mainColor;
        }
    }
    
    .addBtn {
        padding: 0 15px;
        span {
            border: 1px solid $mainColor;
            color: $mainColor;
            padding: 0 0.2rem;
        }
    }
    
    .addLabel {
        input {
            display: block;
            padding: 0 10px;
            line-height: 1.4rem;
            margin: 0.5rem auto 1rem;
            width: 70%;
            border: $borderStyle;
            border-radius: 3px;
        }
        button {
            display: block;
            padding: 0 10px;
            line-height: 1.4rem;
            margin: 0.5rem auto 1rem;
            width: 50%;
            border: 0;
            background: $mainColor;
            color: $baiColor;
            border-radius: 2px;
        }
    }


</style>
