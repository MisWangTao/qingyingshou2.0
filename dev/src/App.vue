<template>
    <div id="app">
        <loading v-show="loading"></loading>
        <menus v-show="getShowNav"></menus>
        <router-view></router-view>
    </div>
</template>

<script>
    import menus from './components/menu/menu.vue'
    import loading from './loading/loading.vue'
    import {mapState, mapGetters, mapActions} from 'vuex'
    export default {
        data(){
            return {}
        },
        mounted(){
        
        },
        computed: {
            ...mapGetters([
                'getShowNav'
            ]),
            ...mapState([
                'loading'
            ])
        },
        created(){
            //console.log(mapState(['showNav']))
            //console.log(mapActions(['showHeader', 'hideHeader']))
        },
        watch: {
            $route(to, from){
                if (to.path == '/' || to.path == '/home' || to.path == '/contractList' || to.path == '/customer' || to.path == '/statistics') {
                    /*this.showNav = true;*/
                    this.$store.dispatch('showHeader')
                } else {
                    /*this.showNav = false;*/
                    this.$store.dispatch('hideHeader')
                }
            }
        },
        
        
        components: {
            menus,
            loading,
        }
    }
</script>

<style>

</style>
