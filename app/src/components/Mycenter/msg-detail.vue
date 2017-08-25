<template>
    <div>
        <div class='card' v-for='(item,index) in messageinfo' :key="item">
            <div class='img-wrap'>
                <img src='../.././assets/img/header.png'/>
            </div>
            <div class='reply'>
                <div class='r-btn'>
                    回复
                </div>
                <div class='id'>
                    <span>{{item.userId}}</span>
                </div>
                <div class='cont'>
                    {{item.cont}}
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
                    time:'03-33 12:22',
                    cont:'就是的哈时间和大家稍等哈就是大家说的那说不定你千万别那么却并未'
                },
                 {
                    userId:'xixix2ix',
                    time:'03-33 12:22',
                    cont:'就是的哈时间和大家稍等哈就是大家说的省市那说不定你千万别那么却并哈时间和大家稍等哈就是大家说的省市那说不定你哈时间和大家稍等哈就是大家说的省市那说不定你'
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
    padding 10px 0
    align-items center
    border-bottom 1px solid #999
    overflow hidden
    .img-wrap
        flex 0 0 10vw
        border-radius 50%
        height 100%
        align-self flex-start
        img
            width 100%
    .reply
        padding-left 10px
        align-self center 
        flex 1
        position relative
        width 100%
        overflow hidden
        .r-btn
            position absolute
            right 0
            bottom 0
            color #259bff
            width 12.5vw
            height 22px
            line-height 22px
            text-align center
        .id
            font-size 16px    
            span
                color #259bff
            height 20px
        .cont
            line-height 20px
            padding 5px 0    
            width 100%
            overflow hidden  
        .time   
            font-size 13px
            color #999999        
</style>
