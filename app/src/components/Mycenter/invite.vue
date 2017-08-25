<template>
    <div class='invite-wrap'>
        <div class='header-pic'>
            <img :src='userinfo.pic'>
        </div>
        <div class='user-id'>
            {{userinfo.username}}
        </div>
        <div class='invite-cont'>
            <div class='title'>
                您已成功邀请好友
            </div>
            <div class='count'>
                <router-link :to="{name:'inviteuser'}" tag='div'>
                    <img src='../.././assets/img/invite-icon.png'>
                    <span>{{sum}}位</span>                    
                </router-link>
            </div>
            <div class='sum'>
                消费总金额
                <span>￥{{count}}元</span>
            </div>
        </div>
        <div class='codebox'>
            <p class='title'>您的邀请码</p>
            <div class='qrcode'>
                {{userinfo.mycode}}
            </div>
            <div class='affirm'>
                <router-link to='/Mycenter/poster' tag='div'>生成邀请海报</router-link>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    created() {
        this.$nextTick(() => {
            this.axios.post('/api/index/Userconter/index').then(res => {
                this.userinfo = res.data;
                console.log(this.userinfo)
            })
        });

    },
    mounted() {
        this.axios.post('/api/index/userconter/invitation').then(res=>{
            console.log(res.data);
            this.sum = res.data.num;
            this.count = res.data.alarr;
        })
    },
    data() {
        return {
            userinfo: {},
            sum:'',
            count:''
        }
    }
}
</script>
<style lang="stylus" scoped>
@css{
    #qrcode{
        width :150px;
        height :150px;
        overflow: hidden;
        margin: 0 auto;
    }
    #qrcode img{
        width : 100%
    }
}
.header-pic
    width 100px
    height 100px
    margin 20px auto
    border-radius 50%
    overflow hidden
img
    width 100%
.user-id
    font-size 20px
    font-weight bold
    text-align center
.invite-cont
    height 100px
    text-align center
    display flex
    flex-direction column
    justify-content space-around
    font-size 20px
    border 1px solid #e6e6e6 
    border-right none
    border-left none
    margin-top 20px
    .count
        display flex
        justify-content center
        span
            color #00a1e9
        img
            width 30px
            height 20px 
    .sum
        span
            color #00a1e9
.codebox
    text-align center
    font-size 20px
    margin-top 20px
    .qrcode
        margin 20px auto
        color red
        font-weight bold
        img
            width 39vw                          
    .affirm
        width 31vw
        margin 0 auto
        height 30px
        line-height 30px
        background-color #00a1e9
        color #fff
        font-size 16px
        border-radius 10px
</style>
