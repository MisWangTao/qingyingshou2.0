<template>
    <div class="searchInput">
        <div class="inner">
            <i class="icon iconfont">&#xe637;</i>
            <input type="search" ref="searchInput" placeholder="请输入搜索内容..." value="" @input="changeVal()"/>
            <span @click="hideSearch()">取消</span>
        </div>
    </div>
</template>

<script>
    export default{
        methods: {
            changeVal(){
                this.$emit('searchVal', this.$refs.searchInput.value)
            },
            hideSearch(){
                this.$emit('hideSearch')
                this.$refs.searchInput.value = ''
            }
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss" scoped>
    .searchInput {
        padding: 6px 15px;
        background: #ffffff;
        margin-bottom: 0.5rem;
        .inner {
            width: 100%;
            position: relative;
            i {
                position: absolute;
                top: 0.3rem;
                left: 0.3rem;
                font-size: 0.7rem;
                color: #dce1f6;
            }
            input {
                display: inline-block;
                padding: 0 0 0 20px;
                width: 88%;
                height: 1.4rem;
                border-radius: 5px;
                border: 1px solid #d4dbec;
                background: #f3f6f9;
            }
            span {
                display: inline-block;
                width: 10%;
                text-align: center;
            }
        }
    }
</style>
