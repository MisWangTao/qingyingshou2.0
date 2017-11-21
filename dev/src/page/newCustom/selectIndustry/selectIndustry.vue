<template>
    <div class="selectIndustry">
        <ul>
            <li v-for="item,key in industrylist" @click="clickp(item)" v-bind:class="{'active':activeid==item.id}">
                {{item.industry_name}}<i class="icon iconfont">&#xe614;</i>
            </li>
        
        </ul>
    </div>
</template>
<script>
    import {host, imghost} from '../../../config/config.js'
    import {mapState} from 'vuex'
    export default{
        props: ['customindustry', 'showselectIndustry'],
        data(){
            return {
                host,
                imghost,
                industrylist: [],
                activeid: 0,
            }
        },
        mounted(){
            this.getindustrylist().then(res => {
                this.industrylist = res.data
            })
        },
        computed: {
            ...mapState([
                'selectIndustry'
            ])
        },
        methods: {
            clickp(data){
                
                this.activeid = data.id
                
                this.selectIndustry.industry_id = data.id
                this.selectIndustry.industry_name = data.industry_name
                
                setTimeout(() => {
                    this.$router.go(-1)
                }, 200);
                
            },
            getindustrylist(){
                return this.$http('GET', '/custom/get_industry_list.php')
            }
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../../assets/main.scss";
    
    .selectIndustry {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 888;
        background: $baiColor;
        ul {
            margin: 0;
            li {
                padding: 0.5rem 0.8rem;
                border-bottom: $qianStyle;
                i {
                    font-size: 1.2rem;
                    float: right;
                    color: $mainColor;
                    display: none;
                }
            }
            li:last-child {
                border: 0;
            }
            .active {
                i {
                    display: block;
                }
            }
        }
    }

</style>
