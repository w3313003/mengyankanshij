<template>
    <div>
        <div class='phone'>
            <label for="tel">手机号</label>
            <input id='tel' type='tel' maxlength="11" placeholder="请输入手机号码" @focus="tel=true" v-model="phone" @blur="checkph" />
            <div @click='phone=""' style="width
                                                                                                :18px;height:19px;">
                <img src='../.././assets/img/b-delete.png' v-if='phone.length >= 1' />
            </div>
        </div>
        <div class='password'>
            <label for='password'>密码</label>
            <input id='password' type='password' placeholder="请输入密码" @focus="pas=true" v-model="password" />
            <div @click='password=""' style="width
                                                                                                :18px;height:19px">
                <img src='../.././assets/img/b-delete.png' v-if='password.length>=1' />
            </div>
        </div>
        <div class='tips'>
            <router-link :to='{name:"find"}'>忘记密码？ </router-link>
        </div>
        <div class='login-btn' @click='login'>
            登录
        </div>
        <p class='register'>
            <router-link :to="{path:'/login/register'}">手机号快速注册</router-link>
        </p>
    </div>
</template>
<script>
export default {
    data() {
        return {
            phone: '',
            password: '',
            code: '',
            countdown: 60,
            ISsend: true,
            tel: false,
            pas: false,
        }
    },
    methods: {
        checkph() {
            if (!checkph.test(this.phone) && this.phone.length>0) {
                this.$toast('手机号码格式错误，请重新输入')
                this.phone = '';
            }
        },
        sendPost() {
            if (this.phone == '') {
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
                    mobile: this.phone
                }).then(res => {

                })
            }
        },
        login() {
            if (this.phone == '' && this.phone.length>0) {
                this.$toast('请输入手机号码');
                return;
            };
            if (this.passwrod == '') {
                this.$toast('请输入密码');
                return;
            };
            const that = this;
            if (this.phone != '' && this.passwrod != '') {
                this.axios.post('/api/index/index/login', {
                    username: this.phone,
                    password: this.password,
                    code: this.code
                }).then(res => {
                    if(res.data == '账号已在其他地方登录'){
                        this.$toast('账号已在其他地方登录');
                        return;
                    }
                    if (res.data === '登录成功') {
                        sessionStorage.setItem('isLogin', true);
                        this.$messagebox.alert('登录成功').then(() => {
                            that.$router.push({ name: 'vBlock1' });
                        }, () => { return; });
                    };
                    if (res.data === '手机号或密码不存在') {
                        this.$toast('手机号或密码错误,请核对您的登录信息');
                    }
                }, res => {
                })
            }
        }
    }
}
</script>
<style lang="stylus" scoped>
@css{
    @media screen and (max-width: 650px) {
         label {
            font-size: 15px !important;
        }
    }
}
.phone,.password
    width 90vw
    background #f5f5f5
    margin 0 auto
    height 50px
    border 1px solid #ccc
    margin-top 20px
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
.tips
    color #259bff
    width 85vw
    margin 20px auto
    height 30px
    line-height 30px
    span
        color #ff2727
        font-size 14px
.code-wrap
        width 90vw
        margin 0 auto 30px
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
.login-btn
    width 88vw
    margin 0 auto
    height 50px
    line-height 50px
    text-align center
    font-size 20px
    color #fff
    background-color #259bff
    border-radius 10px
.register
    color #666
    margin-top 10px
    padding-right 10px
    text-align right                       
</style>
