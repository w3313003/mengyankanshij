<template>
    <div class='index-wrap' ref='scroll'>
        <div class='center-wrap'>
            <div class='user-header'>
                <div class='user-img'>
                    <img :src='userinfo.pic' />
                </div>
                <div class='user-id'>
                    <div>{{userinfo.username}}</div>
                    <section>
                        <img src='../.././assets/img/vip.png'>
                    </section>
                </div>
            </div>
            <div class='center-item'>
                <ul>
                    <li>
                        <router-link :to='{name:"charge"}' tag="div">
                            <div class='li-innerwrap'>
                                <div class='img-wrap'>
                                    <img src='../.././assets/img/1.png' />
                                </div>
                                <div class='li-title'>会员充值</div>
                                <div class='c-price'> {{userinfo.picesum}}元</div>
                                <img src='../.././assets/img/arrow.png' class='arrow' />
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to='{name:"mRecord"}' tag="div">
                            <div class='li-innerwrap'>
                                <div class='img-wrap'>
                                    <img src='../.././assets/img/2.png' />
                                </div>
                                <div class='li-title'>充值记录/提现</div>
                                <img src='../.././assets/img/arrow.png' class='arrow' />
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to='{name:"bRecord"}' tag="div">
                            <div class='li-innerwrap'>
                                <div class='img-wrap'>
                                    <img src='../.././assets/img/3.png' />
                                </div>
                                <div class='li-title'>购买记录</div>
                                <img src='../.././assets/img/arrow.png' class='arrow' />
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to='{name:"wRecord"}' tag="div">
                            <div class='li-innerwrap'>
                                <div class='img-wrap'>
                                    <img src='../.././assets/img/4.png' />
                                </div>
                                <div class='li-title'>观看记录</div>
                                <img src='../.././assets/img/arrow.png' class='arrow' />
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to='{name:"cRecord"}' tag="div">
                            <div class='li-innerwrap'>
                                <div class='img-wrap'>
                                    <img src='../.././assets/img/5.png' />
                                </div>
                                <div class='li-title'>收藏记录</div>
                                <img src='../.././assets/img/arrow.png' class='arrow' />
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to='{name:"pData"}' tag="div">
                            <div class='li-innerwrap'>
                                <div class='img-wrap'>
                                    <img src='../.././assets/img/6.png' />
                                </div>
                                <div class='li-title'>个人资料</div>
                                <img src='../.././assets/img/arrow.png' class='arrow' />
                            </div>
                        </router-link>
                    </li>
                    <li>
                        <router-link :to='{name:"invite"}' tag="div">
                            <div class='li-innerwrap'>
                                <div class='img-wrap'>
                                    <img src='../.././assets/img/7.png' />
                                </div>
                                <div class='li-title'>爱心邀请</div>
                                <img src='../.././assets/img/arrow.png' class='arrow' />
                            </div>
                        </router-link>
                    </li>
                </ul>
            </div>
            <div class='Signout' @click='out'>
                退出登录
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return {
            click: false,
            userinfo:{},
        }
    },
    created() {
        this.$nextTick(() => {
            this.axios.post('/api/index/Userconter/index').then(res => {
                this.userinfo = res.data;
            })
        })
    },
    methods: {
        out() {
            this.axios.post('/api/index/index/loginout').then(res => {
                if (res.data === '退出成功') {
                    sessionStorage.clear('isLogin');
                    this.$messagebox.alert('退出成功').then(() => {
                        this.$router.push({ name: 'login' })
                    })
                }
            })
        }
    },
}
</script>

<style lang="stylus">
.center-wrap
    background url('../.././assets/img/center-bg.png')
    background-size cover
    height 93vh
    width 100%
    .user-header
        width 100%
        height 20vh
        display flex
        box-sizing border-box
        padding-left 6vw
        .user-img
            width 100px
            height 100px
            margin-top 20px
            margin-right 10vw
            border-radius 50%
            overflow hidden
            @media only screen and (max-width:335px)
                width 80px
                height 80px
            img
                width 100%
        .user-id
            div
                color #fff
                font-size 20px
                margin-top 30px
                text-align center
            section
                width 55px
                height 25px
                margin 20px
                img
                    width 100%
    .center-item
        ul
            width 90vw
            margin 0 auto
            li
                height 50px
                display flex
                justify-content center
                flex-direction column
                .li-innerwrap
                    width 100%
                    flex 0 0 30px
                    display flex
                    line-height 30px
                    align-items center
                    .img-wrap
                        width 30px
                        height 30px
                        display flex
                        justify-content center
                        align-items center
                        img
                            width 100%
                    .li-title
                        margin-left 10px
                        color #fff
                        flex 1
                    .c-price
                        color #fff    
                    .li-count
                        width 35px
                        height 15px
                        color #fff
                        line-height 15px
                        font-size 10px
                        background red
                        border-radius 5px           
                        text-align center 
                    .arrow
                        width 9px
                        height 20px  
                        margin-left 10px  
    .Signout
        width 200px
        height 27px
        line-height 27px
        color #fff       
        text-align center
        background #eb5414      
        margin 20px auto 0
        border-radius 10px
</style>
