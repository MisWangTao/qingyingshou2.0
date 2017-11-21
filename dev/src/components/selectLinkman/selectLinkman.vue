<template>
    <div>
        <div class="custom_name">{{linkmanData.dapart_name}}</div>
        <div>
            <div class="bumenItem" v-for="(item,key) in linkmanData.sub" @click="linkto(item)">
                {{item.dapart_name}}
                <i class="icon iconfont">&#xe681;</i>
            </div>
        </div>
        <div class="linkman">
            <div class="itemlist" v-for="(item,key) in linkmanData.users" @click="chooseThis(item.id,item.realname)">
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
            return {
                linkmanData:[],
                //innerData:''
            }
        },
        computed:{
            ...mapState([
                'selectLinkman'
            ])
        },
        mounted(){
            this.initData().then(res=>{
                this.linkmanData = res.data[0]
                this.setInnerData(res.data[0].sub)
            }).catch(err=>{
            
            })
        },
        methods:{
            ...mapMutations([
                'SETLINKMAN'
            ]),
            initData(){
                return this.$http('GET','/depart/get_depart_tree.php')
            },
            linkto(item){
                if((item.sub && item.sub.length>0) ||(item.users && item.users.length>0)){
                    this.$router.push({
                        path:'/departList/'+item.id,
                        query : {
                            departData:item,
                            departArr : item.dapart_name
                        }
                    })
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
                        ding_id : this.linkmanData.ding_id,
                        ding_name : this.linkmanData.dapart_name,
                    })
                }else{
                    arr.splice(aa,1)
                }
                this.SETLINKMAN(arr)
            },
            backLast(){
                this.$router.go(-1)
            }
            /*setInnerData(data){
                let u = '<ul class="dd-list">';
                for (let i in data) {
                    u += '</li class=dd-item>'+data[i].dapart_name +'</li>'
                }
                u += '</ul>'
                console.log(u)
                return u;
            },
            aaa(){
                this.I(this.$router)
            }*/
        }
    }
</script>
<style lang="scss" scoped>
    .bumenItem{
        padding:0.5rem;
        background-color:#fff;border-bottom:1px solid #eee;
        i{
            float:right;
        }
    }
    .custom_name{
        padding:0.5rem;
        font-size:0.7rem;
    }
    .linkman{
        margin-top:1rem;
        background-color:#fff;
    }
    .itemlist{
        position: relative;
        .left{
            float:left;
            margin: 0.3rem 0.5rem;
            display:inline-block;
            width:1.4rem;
            height:1.4rem;
            border-radius:50%;
            vertical-align: top;
            margin-top: 0.3rem;
            img{
                width:1.4rem;
                height:1.4rem;
                border-radius:50%;
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
            padding: 0 1.5rem;
            background-color:#38ADFF;
            color:#fff;
            line-height: 2rem;
            text-align:center;
            border-radius:5px;
            display:block;
            float:right;
            // margin-right:0.5rem;
            border-radius: 0;
        }
    }
</style>
