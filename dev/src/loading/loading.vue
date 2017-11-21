<template>
    <div id="loadingDiv" ref="loadingDiv">
        <div class="divInner" ref="divInner">
        
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return {}
        },
        mounted(){
            this.initLoading()
        },
        computed: {},
        methods: {
            initLoading(){
                let _PageHeight = document.documentElement.clientHeight,
                    _PageWidth = document.documentElement.clientWidth;
                let _LoadingTop = _PageHeight > 61 ? (_PageHeight - 61) / 2 : 0,
                    _LoadingLeft = _PageWidth > 215 ? (_PageWidth - 215) / 2 : 0;
                this.$refs.loadingDiv.style.height = _PageHeight
                this.$refs.divInner.style.left = _LoadingLeft
                this.$refs.divInner.style.top = _LoadingTop
            }
        }
    }
</script>
<style lang="scss" scoped>
    #loadingDiv {
        height: 100%;
        position: absolute;
        left: 0;
        width: 100%;
        top: 0;
        background: #f3f8ff;
        z-index: 10000;
        .divInner {
            width: 100%;
            height: 100%;
            position: absolute;
            cursor1: wait;
            line-height: 57px;
            padding-left: 50px;
            padding-right: 5px;
            background: #fff url(../assets/img/loading.gif) no-repeat scroll 0px -120px;
            color: #696969;
            font-family: \'Microsoft YaHei\';
        }
    }
</style>
