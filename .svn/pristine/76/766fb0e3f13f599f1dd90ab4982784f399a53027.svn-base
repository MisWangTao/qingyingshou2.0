<template>
    <div>
        <div class="custom_name">
            <span v-for="(item,key) in departArr">
                <span v-show="key != 0"> > </span>{{item}}
            </span>
        </div>
        <div>
            <div class="bumenItem" v-for="(item,key) in departData.sub" @click="linkto(item)">
                {{item.dapart_name}}
                <i class="icon iconfont">&#xe681;</i>
            </div>
        </div>
        <div class="linkman">
            <div class="itemlist" v-for="(item,key) in departData.users" @click="chooseThis(item.id,item.realname)">
                <span class="left"><img :src="item.ding_avatar" alt=""></span>
                <span class="right">{{item.realname}}</span>
                <input :checked="isChoose(item.id)" type="radio">
                <i v-show="isChoose(item.id)" class="icon iconfont">&#xe614;</i>
            </div>
        </div>
        <div class="linkmanBottm">
            <span>已选{{selectLinkman.length}}人</span>
            <span @click="backLast" class="sure">确定</span>
        </div>
    </div>
</template>
<script>
    import {mapState,mapMutations} from 'vuex'
    export default {
        data(){
            return{
                departData : {},
                departList : [],
                departArr : [],//部门层级关系
            }
        },
        computed : {
            ...mapState([
                'selectLinkman'
            ])
        },
        mounted(){
            this.departArr.push(this.$route.query.departArr)
            this.departData = this.$route.query.departData
            this.departList.push({
                'id':this.$route.params.id,
                'data' : this.$route.query.departData,
            })
        },
        methods:{
            ...mapMutations([
                'SETLINKMAN'
            ]),
            linkto(item){
                this.$forceUpdate()
                if((item.sub && item.sub.length>0) ||(item.users && item.users.length>0)){
                    this.$router.push({
                        path:'/departList/'+item.id,
                    })
                    this.departData = item
                    this.departList.push({
                        'id' : item.id,
                        'data': item,
                    })
                    this.departArr.push(item.dapart_name)
                }
            },
            isChoose(id){
                let aa = 1;
                for(let i=0; i<this.selectLinkman.length; i++){
                    if(this.selectLinkman[i].id == id){
                        aa = 2
                    }
                }
                return aa == 1 ? false : true
            },
            chooseThis(id,names){
                var aa = -1;
                for(let i=0; i<this.selectLinkman.length; i++){
                    if(this.selectLinkman[i].id == id){
                        aa = i
                    }
                }
                let arr = this.selectLinkman
                if(aa == -1){
                    arr.push({
                        id:id,
                        realname : names,
                        ding_id : this.departData.ding_id,
                        ding_name : this.departData.dapart_name,
                    })
                }else{
                    arr.splice(aa,1)
                }
                this.SETLINKMAN(arr)
            },
            backLast(){
                let a = -this.departList.length -1
                this.$router.go(a)
            }
        },
        watch: {
            $route(to, from){
                for(let i=0; i<this.departList.length; i++){
                    if(to.params.id == this.departList[i].id){
                        this.departData = this.departList[i].data
                    }
                }
                if(to.params.id != this.departList[this.departList.length-1].id){
                    this.departArr.splice(-1)
                }
            }
        },
    }
</script>
<style lang="scss" scoped>
    .custom_name{
        padding:0.5rem;
        font-size:0.7rem;
    }
    .bumenItem{
        padding:0.5rem;
        background-color:#fff;border-bottom:1px solid #eee;
        i{
            float:right;
        }
    }
    .linkman{
        margin-top:1rem;
        background-color:#fff;
    }
    .itemlist{
        position: relative;
        .left{
            float:left;
            display:inline-block;
            width:17%;
            height:2rem;
            text-align:center;
            img{
                width:1.4rem;
                height:1.4rem;
                border-radius:50%;
                vertical-align: top;
                margin-top: 0.3rem;
                
            }
        }
        input{
            position:absolute;
            left:0;
            top: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            z-index: 3;
        }
        i {
            position:absolute;
            right:0.5rem;
            top: 0.5rem;
            font-size: 1rem;
            color: #3891f9;
            z-index: 1;
        }
        .right {
            display:inline-block;
            line-height:2rem;
            width:83%;
            height:2rem;
            border-bottom: 1px solid #f3f4f5;
        }
    }
    .itemlist:last-child .right {
        border: 0;
    }
    .linkmanBottm{
        width:100%;
        position:fixed;
        height:2rem;
        left:0;
        bottom:0;
        background-color:#fff;
        span{
            display:inline-block;
            padding:0.5rem;
        }
        .sure{
            width:20%;
            background-color:#38ADFF;
            color:#fff;
            text-align:center;
            border-radius:5px;
            display:block;
            float:right;
            margin-right:0.5rem;
        }
    }
</style>
