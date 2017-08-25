<template>
    <div>
        <ul class='wrap-ul'>
            <li v-for='item in moneyList' :key="item">
                <div class='left'>
                    <p class='way'>
                        通过微信充值{{item.videoprice}}元
                    </p>
                    <p class='time'>{{item.time | formatdate}}</p>
                </div>
                <div class='right'>
                    +{{item.videoprice}}元
                </div>
            </li>
        </ul>
        <div class='btn-wrap'>
            <div class='btn'>
                <router-link to='/wCash' tag='div'>
                    去提现
                </router-link>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    created() {
        this.axios.post('/api/index/Userconter/record').then(res => {
            this.moneyList = res.data;
            if (this.moneyList.length < 1) {
                this.$toast('当前没有购买记录')
            }
        })

    },
    data() {
        return {
            moneyList: []
        }
    },
    filters: {
        formatdate(str) {
            if (!str) return;
            var date = new Date(str * 1000),
                y = date.getFullYear(),
                m = date.getMonth() + 1,
                d = date.getDate();
            m = m < 10 ? `0${m}` : m;
            d = d < 10 ? `0${d}` : d;
            return `${y}-${m}-${d}`;
        }
    }
}
</script>
<style lang="stylus" scoped>
@import '../.././assets/func.styl'
.wrap-ul
    width 100%
    height 80vh
    overflow scroll
    li
        width 90vw
        margin 0 auto
        border-bottom 1px solid #e6e6e6
        height 60px
        display flex
        justify-content space-between
        align-items center
        .left
            display flex
            flex-direction column
            justify-content center
            line-height 20px
            .way
                font-size 17px                
            .time
                color #999
                font-size 15px
        .right
            font-size 20px
            color #00a1e9
            &.red
                color red
.btn-wrap
    height 10vh
    display flex
    align-items center
    justify-content center
    .btn
        background color
        width 40%
        text-align center
        height 30px
        color #fff
        line-height 30px
        border-radius 5px
        box-shadow 0 3px 5px rgba(0,0,0,.5)

</style>
