<template>
    <div class='find-wrap'>
        <p class='title'>请输入注册的手机号码</p>
        <div class='phonenum'>
            <input type='text' placeholder="请输入手机号码" maxlength="11" v-model='phonenum' @blur="checkph" />
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
        <p class='title'>请输入密码
            <span style="font-size:15px;color:#666">(不能与近期密码相同)</span>
        </p>
        <div class='phonenum'>
            <input type='password' placeholder="请输入密码" maxlength="11" v-model='password' @blur="checkpassword" />
        </div>
        <p class='title'>请再次输入密码</p>
        <div class='phonenum'>
            <input type='password' placeholder="请输入再次密码" maxlength="11" v-model='rPassword' />
        </div>
        <div class='getNext' @click='reset'>
            下一步
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            phonenum: '',
            code: '',
            password: '',
            rPassword: '',
            countdown: 60,
            ISsend: true,

        }
    },
    methods: {
        sendPost() {
            var ph = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(14[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
            if (!ph.test(this.phonenum)) return;
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
        checkph() {
            if (!checkph.test(this.phonenum)) {
                this.$toast('手机号码格式错误');
                this.phonenum = '';
            }
        },
        checkpassword() {
            const reg = /^[A-Z]\w{5,}/i;
            if (!reg.test(this.password)) {
                this.$toast('以字母开头且密码不能少于六位');
            }
        },
        reset() {
            if ((this.password !== this.rPassword) && (this.password !== '')) {
                this.$messagebox.alert('两次输入的密码不一致').then(() => {
                    this.phonenum = '';
                    this.code = '';
                    this.password = '';
                    this.rPassword = '';
                })
            }
            if ((this.password === this.rPassword) && (this.password !== '') && checkph.test(this.phonenum)) {
                this.axios.post('/api/index/index/reset', {
                    mobile: this.phonenum,
                    password: this.password,
                    tpassword: this.rPassword,
                    code: this.code
                }).then(res => {
                    if (res.data === '修改密码完成') {
                        this.$messagebox.alert('密码修改成功').then(() => {
                            this.$router.push({ name: 'login' });
                        })
                    };
                    if (res.data === '密码不能为原始密码') {
                        this.$messagebox.alert('密码不能与近期密码相同');
                        this.password = '';
                        this.rPassword = '';
                    };
                    if (res.data === '验证码或手机号码不正确') {
                        this.$messagebox.alert('验证码或手机号码不正确').then(() => {
                            this.phonenum = '';
                            this.code = '';
                            this.password = '';
                            this.rPassword = '';
                        })
                    }
                }, res => {
                    this.$toast('请检查您的网络')
                })
            }
        }
    }
}
</script>
<style lang="stylus" scoped>
.find-wrap  
    width 90vw
    margin 0 auto
    .error
        margin 10px 0
        color #ff2727
    .title
        font-size 18px
        font-weight 400
        height 37px
        line-height 37px
    .phonenum
        width 100%
        background-color #f5f5f5
        border-radius 7px
        border 1px solid #cccccc
        height 50px    
        display flex
        align-items center
        margin-bottom 17px
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
    .getNext
        height 50px
        line-height 50px
        background-color #259bff
        color #fff
        text-align center
        border-radius 5px
        margin-top 50px        

</style>
