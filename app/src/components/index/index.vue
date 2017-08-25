<template>
    <div>
        <div class='innerwrap' ref='inner'>
            <div class='header'>
                <div class='input-wrap'>
                    <router-link to='/search'>
                        <input type='text' placeholder="请输入你想检索的视频的关键词">
                    </router-link>
                    <div class='img-wrap'>
                        <img src='../.././assets/img/search-icon.png' />
                    </div>
                </div>
            </div>
            <div class='swiper-outerwrap'>
                <mt-swipe :auto="4000" :prevent='true'>
                    <mt-swipe-item v-for='item in banner' :key="item">
                        <img :src='item.bannerurl'>
                    </mt-swipe-item>
                </mt-swipe>
            </div>
            <div class='index-content'>
                <p class='title'>精彩推荐</p>
                <p class='title title-e'>VIDEO RECOMMENDED</p>
                <div class='tab'>
                    <div class='new' @click='ulToggle'>
                        <span class='show' v-if='isNew'>NEW</span>
                        <span v-else>最新</span>      
                    </div>
                    <div class='hot' @click='ulToggle'>
                        <span v-if='!isHot'>热门</span>
                        <span v-else class='ishot'>HOT</span>
                    </div>
                </div>
                <transition name="new" mode="in-out">
                    <ul class='content-ul newUl' v-if='isNew'>
                        <li v-for='(item,index) in newList' :key='item' v-if='index<8' @click='wVideo(item)'>
                            <div class='time'>
                                {{item.time | formatDate}}
                            </div>
                            <img :src='item.pic'>
                            <p class='title'>
                                {{item.videoname}}
                            </p>
                        </li>
                    </ul>
                </transition>
                <transition name="hot" mode="in-out">
                    <ul class='content-ul hotUl' v-if='isHot'>
                        <li v-for='(item,index) in hotList' v-if='index<8' :key='item' @click='wVideo(item)'>
                            <div class='time count'>
                                <span>
                                    <img src='../.././assets/hot.png'>
                                </span>
                                <span>{{item.looks}}</span>
                            </div>
                            <img :src='item.pic'>
                            <p class='title'>
                                {{item.videoname}}
                            </p>
                        </li>
    
                    </ul>
                </transition>
                <div class='getMore'>
                    <router-link to='/video/vBlock1'>More +</router-link>
                </div>
            </div>
            <div class='about'>
                <div class='about-wrap'>
                    <p class='a-title'>关于我们</p>
                    <p class='a-title-e'>ABOUT US</p>
                    <div class='about-img'>
                        <img src='../.././assets/img/logo1.png'>
                    </div>
                    <p class='about-page'>
                        《萌眼看世界》是中国首个依托优质纪实影像，对5到12岁的孩子进行全脑开发的创新教育课程。我们坚信每一个孩子都是天才，希望孩子通过丰富高质的视频认知，开发孩子的脑域，全面提升孩子想象力、创造力、记忆力、专注力、思维力等多方面的潜在能力。《萌眼看世界》通过给孩子观看大量有质感、有科学内容的优质视频，不断刺激右脑的图像化、高速自动处理、直观像、音感等敏感区域的神经元系统，让右脑细胞充分被激活，同时激发左脑的成长。
                    </p>
                </div>
            </div>
            <div class='member'>
                <div class='member-wrap'>
                    <p class='title'>会员制度</p>
                    <p class='title title-e'>MEMBERSHIP RULES </p>
                    <div class='member-img'>
                        <img src='../.././assets/img/member.png' />
                    </div>
                    <div class='m-box'>
                        <p class='box-q'>
                            一、如何成为会员？
                        </p>
                        <p class='box-a'>
                            1、注册成功后，即可成为“萌眼看世界”的会员；
                        </p>
                    </div>
                    <div class='m-box'>
                        <p class='box-q'>
                            二、会员福利：
                        </p>
                        <p class='box-a'>
                            1、会员可以免费观看《萌眼看世界》的三个百科视频；
                        </p>
                        <p class='box-a'>
                            2、会员可以通过“爱心邀请”，让自己的朋友享受免费观看《萌眼看世界》百科视频的福利；
                        </p>
                        <p class='box-a'>
                            3、会员充值成功后，即可成为“萌眼看世界”的超级会员；
                        </p>
    
                    </div>
                    <div class='m-box'>
                        <p class='box-q'>
                            三、“萌眼看世界”超级会员享受以下福利：
                        </p>
                        <p class='box-a'>
                            1、充值100元送10元，即充值100元后，账户余额显示为110元；
                        </p>
                        <p class='box-a'>
                            2、充值200元送30元，即充值200元后，账户余额显示为230元；
                        </p>
                        <p class='box-a'>
                            3、充值300元送50元，即充值300元后，账户余额显示为350元；充值成功300元的会员，还可以免费得到“萌眼看世界”彩虹卫衣一件（新疆、青海、内蒙、港澳台、国际等偏远地区邮费自理）；
                        </p>
                        <p class='box-a'>
                            4、超级会员在购买萌眼看世界非课程类产品时，可以享受折上折的优惠，详见各商品页面。
                        </p>
                        <p class='box-a'>
                            5、会员可随时对余额申请退费，退费时，赠送金额会自动扣除。注：赠送金额大于余额时，退费将不被受理；
                        </p>
                        <p class='box-a'>
                            6、鉴于萌眼看世界的课程产品有相应的知识产权属性，所以对于已经购买的产品不予退费。
                        </p>
                    </div>
                    <div class='m-box'>
                        <p class='box-q'>
                            四、会员制度的最终解释权归“萌眼看世界”项目所属公司。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    computed: {
        formatDate() {
            this.newList.forEach(val => {
                return val.time = `${new Date(val.time).getMonth() + 1}-${new Date(val.time).getDate()}`
            })
        }
    },
    data() {
        return {
            newList: [],
            banner: [],
            hotList: [],
            isNew: true,
            isHot: false
        }
    },
    created() {
        this.axios.get('/api/index/index/index').then(res => {
            this.newList = res.data.videonew;
            this.newList.sort((a, b) => {
                return b.time - a.time;
            });
            this.hotList = res.data.videohot;
            this.hotList.sort((a, b) => {
                return b.looks - a.looks;
            });
            this.banner = res.data.banner;
        })
    },
    methods: {
        ulToggle() {
            this.isNew = !this.isNew;
            this.isHot = !this.isHot;
        },
        wVideo(item) {
            if (item.type === 0) {
                this.$store.commit('setVideo2', item);
                sessionStorage.setItem('currentid', item.id)
                this.$router.push({ name: 'video2', params: { id: item.id } });
            } else {
                sessionStorage.setItem('currentid', item.id)
                this.$router.push({ name: 'video', params: { id: item.id } });
            }
        }
    },
}
</script>
<style lang="stylus">
@css{
    .newNav-enter-active,.newNav-leave-avtive{
        transition:all 1s;
    }
    .newNav-enter,.newNav-leave-to{
        opacity : 0;
    }
}
@import '../.././assets/func.styl'
.header
    width 100vw
    box-sizing border-box
    padding 7px 15px
    height 35px
    margin-bottom 10px
    .input-wrap
        width 90vw
        margin 0 auto
        height 30px
        border 1px solid #000
        box-sizing border-box
        border-radius 10px
        overflow hidden
        box-sizing border-box
        padding-right 20px
        display flex
        justify-content space-between
        align-items center
        .img-wrap
            width 20px
            height 20px
            img
                width 100%
        input
            margin-left 10px
            width 70vw
            height 100%
            line-height 20px
.swiper-outerwrap
    width 100vw
    height 26vh  
    overflow hidden  
    img
        width 100%
        max-height 26vh
.index-content
    width 90%
    margin 20px auto
    .title
        color: color
        font-size 20px
        text-align center
        position relative
        &:nth-child(2)
            font-size:13px
    .title-e::before
        content ""
        position absolute
        top 50%
        left 0
        transform translateY(-50%)
        width 25%
        height 1px
        background-color color
    .title-e::after
        content ""
        position absolute
        top 50%
        right 0
        transform translateY(-50%)
        width 25%
        height 1px
        background-color color
    .tab
        margin-top 20px
        display: flex
        justify-content space-around
        span
            font-size 20px
        span.show
            color color
            border-bottom 1px solid color
        span.ishot
            color red
            border-bottom 1px solid red
    .content-ul
        display flex
        justify-content space-between
        flex-wrap wrap
        &.new-enter-active
            transition  all 0.5s
        &.new-leave-active
            transition  all 0.1s
        &.new-enter
            transform translate3d(-100%,0,0)
        &.new-leave-to
            transform translate3d(-100%,0,0)

        &.hot-enter-active,&.hot-leave-active
            transition  all 1s
        &.hot-enter
            transform translate3d(100%,0,0)
        &.hot-leave-to
            transform translate3d(100%,0,0)
            opacity 0
        li
            width  48%
            border-radius 5px
            position relative
            margin-top 20px
            img
                width 100%
            .time
                width 11vw
                height 5vh  
                background color
                font-size 12px
                color #fff
                position absolute
                text-align center
                line-height 5vh
            .title
                width 100%
                height 5vh
                position absolute
                bottom 0
                left 0
                font-size 12px
                overflow hidden
                white-space nowrap
                text-overflow ellipsis
                background rgba(0,0,0,.5)
                color #fff        
                line-height 5vh
            .count
                background #c41a12
                display flex
                justify-content center
                font-size 10px
                align-items center
                img
                    height 12px
                    width 12px
                    vertical-align middle         
    .getMore
        width 100%
        height 20px
        margin 10px 0
        a
            display block
            width 50px
            height 20px
            margin 0 auto
            border 1px solid color
            border-radius 4px
            font-size 11px
            text-align center
            color color
            line-height 20px
.about  
    width 100%
    background #009ee8
    .about-wrap
        width 90%
        margin 0 auto
        overflow hidden
        .a-title
            color #Fff
            font-size 20px
            text-align center
            margin 10px 0 5px
        .a-title-e
            color #fff
            font-size 13px
            text-align center
            position relative
            &::before
                content ""
                position absolute
                top 50%
                left  0
                transform translateY(-50%)
                width 40%
                height 1px
                background-color #fff 
            &::after  
                content ""
                position absolute
                top 50%
                right  0
                transform translateY(-50%)
                width 40%
                height 1px
                background-color #fff
        .about-img
            width 45vw
            margin 5px auto
            img
                width 100%
        .about-page
            color #fff
            font-size 14px
            text-indent 28px
            line-height 20px
            padding-bottom 30px 
.member
    width 100%
    .member-wrap
        width 90%
        margin 10px auto
        .title
            color: color
            font-size 20px
            text-align center
            position relative
            margin-bottom 5px
            &:nth-child(2)
                font-size:13px
        .title-e
            position relative        
            &::before
                content ""
                position absolute
                top 50%
                left 0
                transform translateY(-50%)
                width 30%
                height 1px
                background-color color
            &::after
                content ""
                position absolute
                top 50%
                right 0
                transform translateY(-50%)
                width 30%
                height 1px
                background-color color
        .member-img
            width 100%
            margin 5px 0 15px
            img
                width 100%
        .m-box
            width 100%
            margin-bottom 20px
            .box-q
                font-size 18px
                text-indent 24px
                color color
                height 50px
            .box-a
                font-size 12px
                text-indent 24px
                line-height 15px                 
                                               
</style>


