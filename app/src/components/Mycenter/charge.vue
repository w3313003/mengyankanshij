<template>
    <div>
        <div class='logo-wrap'>
            <img src='../.././assets/img/logo1.png' />
        </div>
        <div class='amount'>账户余额{{res | formatPrice}}元</div>
        <div class='addBlock'>
            <div class='addwrap'>
                <div class='title'>
                    充值金额
                </div>
                <div class='addBox'>
                    <div class='additem' :class='{"choose":item.click}' v-for='(item,index) in money' :key="item" @click='ischoose(index)'>
                        <div class='money'>充{{item.count}}元</div>
                        <div class='gift' v-if='item.gifts!=""'>送{{item.gifts}}元</div>
                    </div>
                </div>
            </div>
            <div style="width:90%;margin:0 auto">
                充值金额
                <input type='text' v-model="sum" ref='sum' placeholder="请输入充值金额,不小于10元" style="width:70%;margin:0 auto" @focus="ssum">
            </div>
        </div>
        <div class='addBlock manner'>
            <div class='addwrap'>
                <div class='title'>
                    充值方式
                </div>
                <div class='addBox mannerbox'>
                    <div>
                        <mt-cell title="微信支付">
                            <img slot="icon" src="../.././assets/img/weix.png" />
                            <div class='radio' :class='{"radiocheck":isWeix}' @click='isWeix = true'></div>
                        </mt-cell>
                    </div>
                </div>
            </div>
        </div>
        <div class='confirm' @click='recharge'>
            立即充值
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            money: [
                {
                    count: 300,
                    gifts: 50,
                },
                {
                    count: 200,
                    gifts: 30,
                },
                {
                    count: 100,
                    gifts: 10,
                },
                {
                    count: 50,
                    gifts: ''
                }
            ],
            isWeix: true,
            sum: '',
            res: 0
        }
    },
    methods: {
        ischoose(index) {
            this.sum = this.money[index].count;
            this.money.forEach((item, i) => {
                if (!item.click) {
                    this.$set(item, 'click', false);
                };
                item.click = i === index ? true : false;
            });
        },
        ssum() {
            this.sum = '';
            this.money.forEach((item, i) => {
                item.click = false;
            });
        },
        recharge() {
            if (this.sum === '' || this.sum < 10) {
                this.$messagebox.alert('重新输入金额').then(() => {
                    this.sum = ''
                }, () => {
                    return;
                })
            } else {
                this.axios.post('/api/index/recharge/recharge', {
                    picesum: this.sum
                }).then(res => {
                    window.location.href = res.data;
                })
            }
        }
    },
    created() {
        this.$nextTick(() => {
            this.axios.post('/api/index/Userconter/index').then(res => {
                this.res = res.data.picesum;
            })
        })
    },
    filters: {
        formatPrice(num) {
            return Number.parseFloat(num).toFixed(2);
        }
    }


}
</script>
<style lang="stylus" scoped>
@import "../.././assets/func.styl"
.logo-wrap
    width 44vw
    margin 5vh auto 3vh
    img
        width 100%
.amount
    color #666
    text-align center
.addBlock
    width 100%
    border-top 1px solid #666
    margin-top 3vh
    .addwrap
        width 90%
        margin 0 auto
        .title
            height 5vh
            line-height 5vh
        .addBox
            width 90%
            margin 0 auto 
            display flex
            flex-wrap wrap
            justify-content space-between        
            .additem
                width 47%
                text-align center
                margin-bottom 20px
                height 50px
                background #e6e6e6
                border-radius 5px
                display flex
                flex-direction column
                justify-content  center
                font-size 15px
                .money
                    font-size 13px
                .gift
                    font-size 11px
                    color red 
                    margin-top 5px
        .mannerbox
            display flex
            flex-direction column                              
.manner
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
@css{
    .radio{
        width : 22px;
        height : 22px;
        background :#fff;
        border : 1px solid #9d9d9d;
        border-radius : 50%;
    }
    .radiocheck{
        background-color  : #00a1e9;
        background-image : url("../.././assets/img/check.png");
        background-repeat : no-repeat;
        background-position : center center;
        border: 1px solid #00a1e9; 
    }
    body .addBlock .addwrap .addBox .choose{
        background : #00a1e9;
    }
}    
</style>
