<template>
    <div class='reset-wrap'>
        <div class='title'>请输入密码</div>
        <div class='set'>
            <input id='tel' type='tel' placeholder="请输入密码" />
        </div>
        <div class='title'>请再次输入密码</div>
        <div class='set-again'>
            <input id='password' type='password' placeholder="请再次输入密码" />
        </div>
        <p class='tips'>两次密码不一致，请重新输入</p>
        <div class='affirm'>确定</div>
    </div>
</template>
<script>
export default {
    
}
</script>
<style lang="stylus" scoped>
.reset-wrap
    width 90vw
    margin 0 auto
    .affirm
        height 50px
        background-color #259bff
        color #Fff
        line-height 50px
        text-align center
        font-size 18px
        border-radius 5px
    .tips
        font-size 13px
        color #ff2727
        height 40px
        line-height 40px
    .title
        height 40px
        line-height 40px
    .set,.set-again
        width 90vw
        background #f5f5f5
        margin 0 auto
        height 50px
        border 1px solid #ccc
        border-radius 10px
        display flex
        align-items center
        box-sizing border-box
        padding 0 15px 0 10px
        label
            width 14.7vw
            text-align center
            font-size 17px
        input
            background #f5f5f5
            margin-left 5%
            font-size 15px
            flex 1  

</style>
