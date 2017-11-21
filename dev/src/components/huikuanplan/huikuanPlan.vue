<template>
    <div id="huikuanPlan">
        <div class="allMoney">
            合同金额：<span>1,223,232,323.12</span>
        </div>
        <div class="huikuanItem">
            <div class="itemNum">
                第 1 期
            </div>
            <div class="planItem planDate">
                <span class="labels">计划日期</span>
                <input type="date"><i class="icon iconfont">&#xe681;</i>
            </div>
            <div class="planItem planMoney">
                <span class="labels">回款金额</span>
                <input type="text">
            </div>
            <div class="planItem planType">
                <span class="labels">计划类型</span>
                <input type="text"><i class="icon iconfont">&#xe681;</i>
            </div>
            <div class="planItem planRemark">
                <span class="labels">备注</span>
                <input type="text" placeholder="30字以内备注信息">
            </div>
        </div>
        <div class="huikuanItem">
            <div class="itemNum">
                第 2 期
            </div>
            <div class="planItem planDate">
                <span class="labels">计划日期</span>
                <input type="date"><i class="icon iconfont">&#xe681;</i>
            </div>
            <div class="planItem planMoney">
                <span class="labels">回款金额</span>
                <input type="text">
            </div>
            <div class="planItem planType">
                <span class="labels">计划类型</span>
                <input type="text"><i class="icon iconfont">&#xe681;</i>
            </div>
            <div class="planItem planRemark">
                <span class="labels">备注</span>
                <input type="text" placeholder="30字以内备注信息">
            </div>
        </div>
        <div class="addPlan">
            +添加回款计划
            <span>自动生成</span>
        </div>
        <div class="tixing">
            <span>到期提醒</span>
            <span>提前7天</span>
            <input type="checkbox">
            <img :src="imghost+'switch_off@2x.png'" alt="">
        </div>
        <div class="ok">
            确 定
        </div>
        <div class="tiaoguo">
            暂不添加，跳过
        </div>
    </div>
</template>
<script>
    import {host, imghost} from '../../config/config'
    export default{
        data(){
            return {
                imghost,
            }
        },
        mounted(){
            console.log(imghost)
        }
    }
</script>
<style lang="scss" scoped>
    @import "../../assets/main";
    
    #huikuanPlan {
        input {
            border: none;
        }
        .allMoney {
            height: 0.6rem;
            padding: 0.5rem 0.5rem 0 0.5rem;
            font-size: 0.6rem;
            color: #5a6879;
            text-align: right;
            line-height: 0.6rem;
            span {
                color: #3891f9;
            }
        }
        .huikuanItem {
            margin-top: 0.5rem;
            padding: 0 0.5rem;
            background-color: #fff;
            div {
                border-bottom: 1px solid #eee;
            }
            div.planItem {
                padding: 0.3rem 0 0.3rem 0.5rem;
                line-height: 0.6rem;
                i {
                    float: right;
                    line-height: 1.2rem;
                }
            }
            .labels {
                display: inline-block;
                color: #999;
                font-size: 0.7rem;
                width: 30%;
            }
            .itemNum {
                height: 1.25rem;
                font-size: 0.6rem;
                line-height: 1.25rem;
                padding-left: 0.5rem;
                border-bottom: 1px solid #eee;
            }
        }
        .addPlan {
            position: relative;
            text-align: center;
            height: 1.5rem;
            line-height: 1.5rem;
            color: #3891f9;
            padding: 0 0.5rem;
            span {
                position: absolute;
                top: 0;
                right: 0.5rem;
            }
        }
        .tixing {
            position: relative;
            padding: 0.5rem;
            background-color: #fff;
            span:first-child {
                display: inline-block;
                font-size: 0.65rem;
                color: #999;
                width: 30%;
            }
            span:last-child {
                display: inline-block;
                font-size: 0.6rem;
                width: 30%;
            }
            input {
                border: none;
                width: 4rem;
                height: 1rem;
                position: absolute;
                right: 0;
                top: 0.5rem;
                z-index: 12;
                opacity: 0;
            }
            img {
                width: 2rem;
                position: absolute;
                right: 0.5rem;
                top: 0.5rem;
                z-index: 10;
            }
        }
        .ok {
            width: 80%;
            height: 2rem;
            border-radius: 5px;
            background-color: #3891f9;
            text-align: center;
            line-height: 2rem;
            color: #fff;
            font-size: 0.8rem;
            margin: 4rem auto 0;
        }
        .tiaoguo {
            margin: 0.8rem auto 0;
            text-align: center;
            height: 0.6rem;
            line-height: 0.6rem;
            color: #666;
        }
    }
</style>
