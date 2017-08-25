<template>
    <div>
        <div class='card' v-for='(item,index) in messageinfo' :key="item">
            <div class='img-wrap'>
                <img src='../.././assets/img/header.png'/>
            </div>
            <div class='reply'>
                <div class='r-btn'>
                    <router-link :to='{name:"msgDetail"}' tag="div">查看</router-link>
                </div>
                <div class='id'>
                    <span>{{item.userId}}</span>回复了你
                </div>
                <div class='time'>
                    {{item.time}}
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            messageinfo:[
                {
                    userId:'xixixix',
                    time:'03-33 12:22'
                },
                 {
                    userId:'xixix2ix',
                    time:'03-33 12:22'
                },
                 {
                    userId:'xixixix',
                    time:'03-33 12:22'
                },
                {
                    userId:'你是谁',
                    time:'03-33 12:22'
                }
            ],
            
        }
    }
}
</script>
<style lang="stylus" scoped>
.card
    width 90vw
    margin 0px auto
    display flex
    height 70px
    align-items center
    border-bottom 1px solid #999
    .img-wrap
        flex 0 0 10vw
        border-radius 50%
        img
            width 100%
    .reply
        padding-left 10px
        align-self center 
        flex 1
        position relative
        .r-btn
            position absolute
            right 0
            bottom 0
            background-color #259bff
            color #fff
            width 12.5vw
            height 22px
            line-height 22px
            text-align center
            border-radius 10px
        .id
            font-size 16px    
            span
                color #259bff
            height 20px  
        .time   
            font-size 13px
            color #999999        
</style>
