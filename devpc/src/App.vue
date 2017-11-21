<template>
    <div id="app">
        <menus v-show="true"></menus>
        <top v-show="true"></top>
        <router-view></router-view>
    </div>
</template>

<script>
    import menus from './components/menu/menu.vue'
    import top from './components/top/top.vue'
    import {mapState, mapGetters, mapActions} from 'vuex'
    export default {
        data(){
            return {}
        },
        mounted(){
        
        },
        computed: {

        },
        created(){
            
        },
        components: {
            menus,
            top
        },
    }
</script>

<style>

</style>
