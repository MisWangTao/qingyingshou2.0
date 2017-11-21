<template>
    <div class="content">
        <searchInput @searchVal="search"></searchInput>
        <div class="customer" v-for="(item,key) in companlist" v-show='isShow(item) >= 0'>
            <router-link tag="div" class="lists" :to="'kehuxinxi/'+item.id">
                <div class="img">
                    <img v-if="item.logo" :src="host+item.logo" alt="">
                    <img v-else :src="imghost+'logo_defaullt@2x.png'" alt="">
                </div>
                <div class="right">
                    <p>{{item.custom_name}}<img v-if=" item.custom_nature=='2' " :src="imghost+'qi@2x.png'" alt=""></p>
                    <p v-show="item.industry_name">{{item.industry_name}}</p>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
    import searchInput from '../../components/searchInput/searchInput.vue'
    import {host, imghost} from '../../config/config.js'
    export default{
        components: {
            searchInput
        },
        data(){
            return {
                companlist: [],
                host,
                imghost,
                searchVal: '',
            }
        },
        mounted(){
            this.getCompanyList().then(res => {
                this.companlist = res.data
            })
        },
        methods: {
            getCompanyList(){
                return this.$http('GET', '/custom/get_custom_list.php')
            },
            
            search(val){
                this.searchVal = val
            },
            isShow(item){
                return item.custom_name.indexOf(this.searchVal);
            }
        }
        
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    @import "../../assets/main.scss";
    .content {
        padding-bottom: 4rem;
    }
    .customer {
        padding: 0 15px;
        background: $baiColor;
        overflow: hidden;
        .lists {
            padding: 10px 0;
            border-bottom: $borderStyle;
            overflow: hidden;
            .img {
                float: left;
                img {
                    vertical-align: top;
                    margin-top: 0.26rem;
                    display: block;
                    width: 1.8rem;
                    height: 1.8rem;
                    border-radius: 50%;
                    
                }
            }
            .right {
                float: left;
                margin-left: 0.5rem;
                p:first-child {
                    font-size: 0.75rem;
                    line-height: 0.75rem;
                    color: #0c1c2c;
                    img {
                        margin-left: 0.1rem;
                        width: 0.8rem;
                        vertical-align: top;
                    }
                }
                p:nth-child(2) {
                    margin-top: 0.4rem;
                    padding: 0 0.3rem;
                    display: inline-block;
                    border: 1px solid #3891f9;
                    border-radius: 3px;
                    color: #4d9af3;
                    font-size: 0.6rem;
                    
                }
                
            }
        }
    }
    
    .customer:last-child .lists {
        border: 0;
    }
</style>
