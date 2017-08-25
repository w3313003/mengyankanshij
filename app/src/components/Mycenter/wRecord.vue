<template>
    <div>
        <div class='clearbtn' @click='clear'>
            <span v-if='this.message.length>0'>一键清空</span>
            <span v-else>暂无记录</span>
        </div>
        <div class='item' v-for='(item,index) in message' :key="item">
            <div class='item-img'>
                <img :src='item.pic'>
                <div class='time'>
                    {{item.looks}}次观看
                </div>
            </div>
            <div class='item-cont'>
                <div class='delete' @click='deleteItem(item,index)'>
                    <img src="../.././assets/img/delete.png" slot="icon"> 删除
                </div>
                <p>{{item.videoname}}</p>
                <p class='text'>视频简介:{{item.videocont | formatContent}}</p>
                <div class='price'>
                    <div style="height:30px;line-height:30px;">
                        <img src='../.././assets/img/price-icon.png' height="15" width="15" /> {{item.single}}元
                    </div>
                </div>
                <div class='time'>
                    <div class='left'>
                        <div class='img-wrap'>
                            <img src='../.././assets/img/date.png'>
                        </div>
                        {{item.time | formatdate}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            message: []
        }
    },
    methods: {
        deleteItem(index) {
            this.$messagebox.confirm('确定执行此操作?').then(() => {
                this.message.splice(index, 1);
                var arr = JSON.parse(localStorage.getItem('watcharr'));
                arr.splice(index, 1);
                localStorage.setItem('watcharr', JSON.stringify(arr));
            }, () => { return });
        },
        clear() {
            this.message = [];
            localStorage.removeItem('watcharr');
            this.$toast('清理成功')
        }
    },
    created() {
        this.message = JSON.parse(localStorage.getItem("watcharr"));
        console.log(this.message)
    },
    filters: {
        formatContent(str) {
            if (!str) return false;
            return str.replace(/<[^>]+>/g, "");
        },
        formatdate(str) {
            if (!str) return;
            var date = new Date(str * 1000),
                y = date.getFullYear(),
                m = date.getMonth() + 1,
                d = date.getDate();
            m = m < 10 ? `0${m}` : m;
            d = d < 10 ? `0${d}` : d;
            return `${y}-${m}-${d}`;
        },
        formatTimeLength(str) {
            var m = Number.parseInt(str / 60),
                s = Number.parseInt(str % 60);
            s = s < 10 ? `0${s}` : s;
            return `${m}:${s}`;
        }
    },
}
</script>
<style lang="stylus" scoped>
.clearbtn
    color red
    text-align center
    height 24px
    line-height 24px
.item
    width 90vw
    margin 20px auto 0
    display flex
    justify-content space-between
    box-sizing border-box
    padding-bottom 15px
    border-bottom 1px solid #666
    .item-img
        width 45%
        position relative
        img
            width 100%
        .time
            padding 0 5px
            height 15px
            line-height 15px
            color #fff
            position absolute
            right 0
            bottom 3px
            background-color:rgba(212,102,28,.8)  
            font-size 12px
            text-align center  
    .item-cont
        width 50%
        display flex
        flex-direction column
        position relative
        .delete
            width 14.7vw
            height 30px
            line-height 30px
            background #ff2828
            font-size 15px
            text-align center
            color #fff
            position absolute
            right 0
            bottom 0
            border-radius 4px
        p:first-child
            height 24px
            line-height 24px
        .text
            width 100%
            overflow hidden
            font-size 15px
            text-overflow ellipsis
            line-height 17px
            display: -webkit-box; 
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            color #666
        .price
            color #00a1e9  
            font-size 14px
            flex 1
            display flex
            align-items center
        .time
            display flex
            justify-content space-between
            .left
                font-size 15px
                color #666
                .img-wrap
                    width 15px
                    height 15px
                    display inline-block
                    img
                        width 100%
            .right
                background red            

</style>
