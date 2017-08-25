<template>
    <div class='reg-wrap'>
        <p class='title'>请输入手机号码</p>
        <div class='phonenum'>
            <input type='text' placeholder="请输入手机号码" maxlength="11" v-model='phonenum' @blur="checkphone" />
        </div>
        <p class='title'>请输入密码</p>
        <div class='phonenum password'>
            <input type='password' placeholder="以字母开头且长度不小于6位" v-model='password' @blur='checkpassword' />
        </div>
        <p class='title'>孩子年龄</p>
        <div class='phonenum password'>
            <input type='text' placeholder="请输入年龄" maxlength="3" v-model='age' @blur="checkage" />
        </div>
        <p class='title'>孩子姓名</p>
        <div class='phonenum password'>
            <input type='text' placeholder="请输入姓名" maxlength="5" v-model='name' />
        </div>
        <p class='title'>性别</p>
        <div class='phonenum password'>
            <mt-switch v-model="sex"></mt-switch>
            <span v-if='sex'>男</span>
            <span v-else>女</span>
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
        <div class='code-wrap invitecode'>
            <div class='code'>
                <input type='text' placeholder="请输入邀请码" maxlength="4" v-model='invitecode' />
            </div>
        </div>
        <div class='getNext' @click='send'>
            下一步
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            phonenum: '',
            password: '',
            code: '',
            age: '',
            sex: true,
            invitecode: '',
            countdown: 60,
            ISsend: true,
            name: ''
        }
    },
    created() {
        if (this.$route.path.length > 15) {
            var code = this.$route.path.split('/')[this.$route.path.split('/').length - 1];
            this.$nextTick(() => {
                this.invitecode = code;
            })
        }
    },
    methods: {
        checkpassword() {
            const reg = /^[A-Z]\w{5,}/i;
            if (!reg.test(this.password)) {
                this.$toast('以字母开头且密码不能少于六位');
            }
        },
        checkphone() {
            const reg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(14[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
            if (!reg.test(this.phonenum)) {
                this.$toast('请输入正确的手机号码');
                this.phonenum = '';
            }
        },
        checkage() {
            const reg = /\d/;
            if (!reg.test(this.age)) {
                this.$toast('年龄只能为数字');
            }
        },
        sendPost() {
            if (this.phone == '' && this.phone.length > 0) {
                this.$toast('请输入手机号码')
                return;
            } else {
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
            }

        },
        send() {
            if (this.phone == '' && this.phone.length > 0) {
                this.$toast('请输入手机号码')
            };
            const pas = /^[A-Z]\w{5,}/i,
                ph = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(14[0-9]{1})|(17[0-9]{1}))+\d{8})$/,
                age = /\d/;
            if (ph.test(this.phonenum) && pas.test(this.password) && age.test(this.age)) {
                this.axios.post('/api/index/index/register', {
                    phone: this.phonenum,
                    password: this.password,
                    yourscode: this.invitecode,
                    sex: this.sex,
                    age: this.age,
                    code: this.code,
                    name: this.name
                }).then(res => {
                    if (res.data === '注册完成') {
                        this.$messagebox.alert('注册成功').then(() => {
                            this.$router.push({ name: 'login' })
                        });
                    };
                    if (res.data === '验证码错误') {
                        this.$toast('验证码错误');
                        window.reload(true);
                    }
                })
            } else {
                this.$messagebox.alert('请完善信息后重新注册');
            }
        }
    }
}
</script>
<style lang="stylus" scoped>
.reg-wrap  
    width 90vw
    margin 10px auto
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
    .invitecode
        margin 20px 0        
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
