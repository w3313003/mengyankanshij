<template>
    <div class='contact-wrap'>
        <div class='title'>
            萌眼看世界客服微信
        </div>
        <div class='codewrap'>
            <img :src='pic' />
        </div>
        <div class='time'>
            <p>工作时间:</p>
            <p>周一到周五 9:00-17:00</p>
        </div>
    </div>
</template>
<script>
import date from './date'
export default {
    computed: {
        FpickerValue() {
            var y = this.pickerValue.getFullYear(),
                m = this.pickerValue.getMonth() + 1,
                d = this.pickerValue.getDate();
            m = m < 10 ? `0${m}` : m;
            d = d < 10 ? `0${d}` : d;
            return `${y}-${m}-${d}`;
        }
    },
    data() {
        return {
            pickerValue: '',
            datas: '你啥时候',
            currentTime: 0,
            prventTime: 0,
            isshow: false,
            pic: ''
        }
    },
    components: {
        date
    },
    computed: {
        day() {
            return (this.currentTime - this.prventTime) / 1000 / 60 / 60 / 24;
        }
    },
    created() {
        this.$nextTick(() => {
            this.axios.post('/api/index/Userconter/services').then(res => {
                console.log(res.data[0].spic);
                this.pic = res.data[0].spic
            })
        })

    },
    methods: {
        pick() {
            this.$refs.picker.open();
        },
        pickconsole() {
            console.log(this.FpickerValue)
        },
        prveTime(data) {
            this.prventTime = data;
            console.log(data)
        },
        currTime(data) {
            this.currentTime = data;
            console.log(data);
            this.isshow = true;
        }

    }
}
</script>

<style lang="stylus" scoped>
@css{
    .contact-wrap{
        background-color : rgb(0.158,232);
        height : 90vh;
    }
}
.contact-wrap
    background-color #009ee8
    height 90vh
    .title
        font-size 18px
        text-align center
        height 10vh
        line-height 10vh
        padding-top 5vh
    .codewrap
        width 34vw
        margin 0 auto
        img
            width 100%
    .time
        text-align center
        margin-top 20px
        p
            font-size 18px
            line-height 25px        
</style>
