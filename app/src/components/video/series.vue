<template>
    <div>
        <div class='video-price' v-for='(item,index) in series' :key="index">
            <p class='title'>系列视频打包购买享优惠</p>
            <div class='price'>
                <div class='price-img'>
                    <img :src='item.pic' />
                </div>
                <div class='price-desc'>
                    <div class='p-title'>{{item.name}}系列</div>
                    <div class='p-cont'>
                        <p v-for='item in item.itemname' :key="item">
                            {{item}}
                        </p>
                    </div>
                    <div class='p-innerwrap'>
                        <div class='cur-price'>打包价:￥{{item.pPirce | formatPrice }}</div>
                        <div class='old-price'>原价:￥{{item.oPirce | formatPrice}}</div>
                    </div>
                    <div class='b-btn' @click='buy(item)'>
                        <span>立即购买</span>
                    </div>
                </div>
            </div>
        </div>
        <mt-actionsheet :actions="actions" v-model="abuy">
        </mt-actionsheet>
    
    </div>
</template>

<script>
import Vue from 'vue'
export default {
    created() {
        this.axios.post('/api/index/videoclass/videomyinfo', {
            id: sessionStorage.getItem('currentid')
        }).then(res => {
            console.log(res.data.varrys);
            res.data.varrys.forEach((val, index) => {
                let obj = {},
                    arr = [],
                    sum = 0,
                    id = [];
                obj.name = val[0].series;
                obj.pic = val[0].pic;
                obj.pPirce = val[0].pack;
                val.forEach(v => {
                    id.push(v.id);
                    sum += v.single
                    arr.push(v.videoname);
                });
                obj.id = id;
                obj.oPirce = sum;
                obj.itemname = arr;
                this.series.push(obj);
            });
        });
    },
    data() {
        return {
            series: [],
            abuy: false,
            actions: [{
                name: '余额支付',
                method:() => {
                    Vue.prototype.axios.post('/api/index/recharge/mypay', {
                        id: item.id,
                        videoname: item.name,
                        videoprice: item.pPirce
                    }).then(res => {
                        this.$messagebox.alert(res.data).then(()=>{
                            location.reload(true)
                        })
                    })
                }
            }, {
                name: '微信支付',
                method() {
                    Vue.prototype.axios.post('/api/index/recharge/pay', {
                        id: item.id,
                        videoname: item.name,
                        videoprice: item.pPirce
                    }).then(res => {
                        window.location.href = res.data;
                    })
                }
            }
            ]
        }
    },
    filters: {
        formatPrice(value) {
            return Number.parseFloat(value).toFixed(2);
        }
    },
    methods: {
        buy(item) {
            this.abuy = true;
            window.item = item;
        },
    }
}
</script>

<style lang="stylus" scoped>
.video-price
    width 90vw
    padding 10px 0 20px
    margin 0 auto
    border-bottom 1px solid #666
    .title
        height 25px
        font-size 15px
        line-height 25px
    .price
        width 100%
        display flex
        .price-img
            flex 0 0 39vw
            img
                width 100%
        .price-desc
            flex 1
            box-sizing border-box
            padding-left 10px
            .p-title
                font-size 15px
            .p-cont
                margin 5px 0    
            .p-cont > p
                color #666666
                font-size 10px
                height 12px
            .p-innerwrap
                display flex
                justify-content space-between 
                .cur-price
                    font-size 13px
                    color #ff0f26
                .old-price
                    font-size 10px
                    color #666666
                    text-decoration line-through 
            .b-btn
                text-align right
                margin-top 5px
                span
                    display inline-block
                    font-size 15px
                    width 17.5vw
                    text-align center
                    height 17px
                    line-height 17px
                    border-radius 3px
                    color #fff
                    background #fbc01d      
</style>
