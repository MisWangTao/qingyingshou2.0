<template>
    <div>
        <searchInput @searchVal="search"></searchInput>
        <div id="selectCustomer">
            <ul>
                <li :class="{'active': item.id == selectCustomer.customId}" v-for="(item,key) in customData"
                    @click="chooseCustom(item.id,item.custom_name)" v-show='isShow(item) >= 0'>{{item.custom_name}}
                    <i class="icon iconfont" v-show="item.id == selectCustomer.customId">&#xe614;</i></li>
            </ul>
        </div>
    </div>
</template>

<script>
    import searchInput from '../searchInput/searchInput.vue'
    import {mapState} from 'vuex'
    export default{
        data(){
            return {
                customData: [],
                searchVal: '',
            }
        },
        computed: {
            ...mapState([
                'selectCustomer'
            ]),
            
        },
        components: {
            searchInput
        },
        mounted(){
            this.initData()
        },
        methods: {
            initData(){
                this.$http("GET", 'custom/get_custom_list.php').then(res => {
                    this.customData = res.data
                }).catch(err => {
                    this.I(err)
                })
            },
            search(val){
                this.searchVal = val
            },
            isShow(item){
                return item.custom_name.indexOf(this.searchVal);
            },
            chooseCustom(id, customName){
                this.selectCustomer.customId = id;
                this.selectCustomer.customName = customName
                this.$forceUpdate()
                let _this = this
                setTimeout(function () {
                    _this.$router.go(-1)
                }, 200)
            },
            
        }
        
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    @import "../../assets/main";
    
    #selectCustomer {
        overflow: hidden;
        ul {
            background: $baiColor;
            padding: 0 10px;
            li {
                list-style: none;
                line-height: 1.8rem;
                font-size: 0.7rem;
                border-bottom: $qianStyle;
                i {
                    display: none;
                    color: $mainColor;
                }
            }
            .active {
                color: $mainColor;
                i {
                    float: right;
                    margin: 0 6px;
                    display: inline-block;
                }
            }
            li:last-child {
                border: 0;
            }
        }
    }
</style>
