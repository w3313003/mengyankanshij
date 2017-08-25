<template>
    <div class='reg-wrap'>
        <div class='slogan'>可提现金额:{{sum}}元</div>
        <p class='title'>请输入手机号码</p>
        <div class='phonenum'>
            <input type='text' placeholder="请输入手机号码" maxlength="11" v-model='phonenum' @blur="checkphone" />
        </div>
        <p class='title'>请输入银行卡号</p>
        <div class='phonenum'>
            <input type='password' placeholder="请输入银行卡号" v-model='card' />
        </div>
        <p class='title'>姓名</p>
        <div class='phonenum'>
            <input type='text' placeholder="请输入姓名" maxlength="3" v-model='name' />
        </div>
        <p class='title'>提现金额</p>
        <div class='phonenum password'>
            <input type='text' placeholder="请输入金额(不得低于十元)" v-model='wSum' @blur='checksum' />
        </div>
    
        <div class='code-wrap'>
            <div class='code'>
                <input type='text' placeholder="请输入验证码" maxlength="6" v-model='code' />
            </div>
            <div class='getCode' @click='sendPost' v-if='ISsend'>
                <span>获取验证码</span>
            </div>
            <div class='getCode gray' v-else>
                <span>还剩{{countdown}}秒</span>
            </div>
        </div>
        <div class='confirm' @click='wCash'>
            立即提现
        </div>
    </div>
</template>

<script>
export default {
    created() {
        this.axios.post('/api/index/Userconter/wtables').then(res => {
            this.sum = res.data
        })
    },
    data() {
        return {
            phonenum: '',
            card: '',
            code: '',
            name: '',
            sum: '',
            wSum: '',
            countdown: 60,
            ISsend: true
        }
    },
    methods: {
        checkphone() {
            if (!checkph.test(this.phonenum)) {
                this.$toast('手机号码格式错误，请重新输入')
                this.phonenum = '';
            }
        },
        checksum() {
            let reg = /\d/g;
            if (!reg.test(this.wSum)) {
                this.$toast('只能输入数字');
                this.wSum = '';
                return;
            }
            if (this.wSum < 10) {
                this.$toast('金额不小于十元');
                this.wSum = '';
                return;
            };
            if (this.wSum > this.sum) {
                this.$toast('不得大于您的可提现余额');
                this.wSum = '';
                return;
            }
        },
        sendPost() {
            let reg = /\d/g;
            if(!checkph.test(this.phonenum) || !reg.test(this.wSum)){
                this.$toast('信息有误，请检查后重新输入');
                this.phonenum = this.code = this.name = this.wSum = '';
                return ;
            };
            this.ISsend = false;
            let timer = setInterval(() => {
                this.countdown--;
                if (this.countdown === 0) {
                    this.countdown = 60;
                    clearInterval(timer);
                    this.ISsend = true;
                }
            }, 1000);
            this.axios.post('/api/index/index/mobiles', {
                mobile: this.phonenum
            }).then(res => {
                console.log(res.data)
            })
        },
        wCash(){
            let reg = /\d/g;
            if(!checkph.test(this.phonenum) || !reg.test(this.wSum)){
                this.$toast('信息有误，请检查后重新输入');
                this.phonenum = this.code = this.name = this.wSum = '';
                return ;
            };
            this.axios.post('/api/index/Userconter/withds',{
                phone:this.phonenum,
                wprice:this.wSum,
                truename:this.name,
                card: this.card,
                code:this.code
            }).then(res => {
                if(res.data==='提现申请成功'){
                    this.$toast('提现成功');
                } else if(res.data === '提现申请失败'){
                    this.toast('提现失败');
                }
            })
        }
    }

}
</script>

<style lang="stylus" scoped>
@import '../.././assets/func.styl'
.reg-wrap  
    width 90vw
    margin 10px auto
    .slogan
        text-align center
        font-size 25px
        color red
    .error
        margin 10px 0
        color #ff2727
    .title
        font-size 18px
        font-weight 400
        height 37px
        line-height 37px
    .password
        margin-bottom 15px    
    .phonenum
        width 100%
        background-color #f5f5f5
        border-radius 7px
        border 1px solid #cccccc
        height 50px    
        display flex
        align-items center
        input
            font-size 17px
            background-color #f5f5f5
            padding 10px
    .code-wrap
        height 50px
        display flex
        justify-content space-between
        .code
            width 45%
            background-color #f5f5f5
            height 100%
            display flex
            align-items center
            border-radius 4px
            border 1px solid #ccc
            input
                background-color #f5f5f5
                width 70%
                padding 5px
                font-size 15px
        .getCode
            width 45%
            background-color #259bff
            color #fff
            text-align center
            line-height 50px
            border 1px solid #259bff
            border-radius 4px
            &.gray
                background-color #666
                border none                
.confirm
    width 51.5vw
    margin 0 auto
    background-color color
    color #fff
    text-align center
    height 30px
    line-height 30px
    border-radius 5px
    margin-top 20px


</style>
