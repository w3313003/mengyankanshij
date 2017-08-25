<template>
    <div class='bg'>
        <img src='../.././assets/img/posters.png' />
        <div class='qrcode'>
            <div id='qrcode'></div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            userinfo: {}
        }
    },
    methods: {
        test() {
            console.log(document.querySelector('#qrcode img').src)
        }
    },
    created() {
        this.$nextTick(() => {
            this.axios.post('/api/index/Userconter/index').then(res => {
                this.userinfo = res.data;
                setTimeout(() => {
                    var qrcode = new QRCode(document.getElementById('qrcode'), {
                        text: `http://www.renjing.xin/?#/login/register/${this.userinfo.mycode}`,
                        width: 100,
                        height: 100,
                        colorDark: '#000000',
                        colorLight: '#ffffff'
                    });
                }, 0);
            });
        });
    },
    mounted() {
        this.$nextTick(() => {
            setTimeout(() => {
                console.log(document.querySelector('#qrcode img').src)
            },100);
        })
    }
}
</script>
<style lang="stylus" scoped>
@css{
    #qrcode{
        display: flex;
        justify-content : center;
        margin-bottom :10px;
    }
}
.bg
    width 100%
    height 100%
    position relative
    background-size length(100vw,90vh)
    display flex
    align-items center
    justify-content center
    img
        width 100%  
    .qrcode
        position absolute
        left 50%
        top 50%
        transform translate(-45%,-50%)
        text-align center
        color #00a1e9
        font-size 16px
        .code
            width 100px
            height 100px
        p
            height 20px

</style>
