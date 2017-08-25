<template>
    <div class='index-wrap' ref='scroll'>
        <div class='vb1-box'>
            <div class='header'>
                <router-link to='/search'>
                    <div class='input-wrap'>
                        <input type='text' placeholder="请输入你想检索的视频的关键词">
                        <div class='img-wrap'>
                            <img src='../.././assets/img/search-icon.png' />
                        </div>
                    </div>
                </router-link>
            </div>
            <div class='vb1-container'>
                <div class='vb1-title'>
                    <p class='title'>
                        <router-link :to='{name:"vBlock1"}'>百科课堂</router-link>
                    </p>
                    <p class='title vb1-active'>全脑开发课堂</p>
                </div>
            </div>
            <div class='sortBlock'>
                <select @change='Sort' v-model="sort">
                    <option>按时间顺序排列</option>
                    <option>按时间倒序排列</option>
                    <option>按浏览量顺序排列</option>
                    <option>按浏览量倒序排列</option>
                </select>
            </div>
            <mt-loadmore :bottom-method="loadMore" :bottom-all-loaded='isbottom' ref="loadmore">
                <ul class='videoUl'>
                    <li v-for='(item,index) in videoList' v-if='index < 8+count' :key='item' @click='goWacth(item)'>
                        <div class='time'>
                            {{item.time | formatDate}}
                        </div>
                        <img :src='item.pic'>
                        <p class='title'>
                            {{item.videoname}}
                        </p>
                    </li>
                </ul>
            </mt-loadmore>
        </div>
    </div>
</template>


<script>
export default {
    computed: {
        formatDate() {
            this.newList.forEach(val => {
                return val.time = `${new Date(val.time).getMonth() + 1}-${new Date(val.time).getDate()}`
            })
        }
    },
    data() {
        return {
            videoList: [],
            sort: '按时间顺序排列',
            count: 0,
            isbottom: false
        }
    },
    created() {
        this.$indicator.open({
            text: '全力加载中...',
            spinnerType: 'fading-circle'
        });
        this.axios.get('/api/index/videoclass/videoclassarr').then(res => {
            res.data.videoarrs.forEach(val => {
                val.type === 1 ? this.videoList.push(val) : false;
            });
            this.videoList.sort((a, b) => {
                return b.time - a.time;
            });
            this.$indicator.close();
        });
    },
    methods: {
        loadMore() {
            if (this.count == this.videoList.length - 8) {
                this.isbottom = true;
                this.$refs.loadmore.onBottomLoaded();
                this.$toast('加载完毕')
                return;
            }
            setTimeout(() => {
                this.count += 4;
                this.$refs.loadmore.onBottomLoaded();
            }, 1000)

        },
        choose(index) {
            this.navList.forEach(item => {
                item.isClick = false;
            });
            this.navList[index].isClick = true;
        },
        Sort() {
            if (this.sort === '按时间顺序排列') {
                this.videoList.sort((a, b) => {
                    return b.time - a.time;
                });
            };
            if (this.sort === '按时间倒序排列') {
                this.videoList.sort((a, b) => {
                    return a.time - b.time;
                });
            };
            if (this.sort === '按浏览量顺序排列') {
                this.videoList.sort((a, b) => {
                    return a.looks - b.looks;
                });
            };
            if (this.sort === '按浏览量倒序排列') {
                this.videoList.sort((a, b) => {
                    return b.looks - a.looks;
                });
            };
        },
        goWacth(item) {
            sessionStorage.setItem('currentid', item.id)
            this.$router.push({ name: 'video', params: { id: item.id } });
        }
    },
}
</script>

<style lang="stylus" scoped>
@import "../.././assets/func.styl"
.nav-mask
    position fixed
    width 100%
    height 100vh
    background #fff
    z-index 10
    .nm-wrap
        margin 0 auto
        display flex
        flex-wrap wrap
        li
            width 18vw
            font-size 13px
            height 25px
            padding  10px 5px
            text-align center
            border-radius 5px
            line-height 25px
            white-space nowrap
            background #e6e6e6
            margin 10px 5px
            &.active
                color #eb5414
.vb1-box
    width 93vw
    margin 0 auto
    .header
        width 100%
        box-sizing border-box
        padding 7px 15px
        height 35px
        margin-bottom 10px
        .input-wrap
            width 100%
            height 30px
            border 1px solid #000
            border-radius 10px
            overflow hidden
            input
                margin-left 10px
                width 70%
                height 100%
                line-height 20px
    .vb1-container
        width 100%
        .vb1-title
            display flex
            justify-content space-around
            .title
                font-size 18px
                &.vb1-active
                    color color 
    .sortBlock
        position relative
        width 40vw
        border 1px solid #aaa
        height 25px
        font-size 15px   
        margin 10px auto 0
        text-align center
        line-height 25px
        ul
            width 100%
            position absolute
            background #fff
            z-index 2
            left -1px
            top 25px
            border 1px solid #aaa
            border-top none 
    .videoUl
        display flex
        justify-content space-between
        flex-wrap wrap
        li
            width  48%
            border-radius 5px
            position relative
            margin-top 20px
            img
                width 100%
            .time
                width 11vw
                height 5vh  
                background color
                font-size 12px
                color #fff
                position absolute
                text-align center
                line-height 5vh
            .title
                width 100%
                height 5vh
                position absolute
                bottom 0
                left 0
                text-align center
                font-size 12px
                overflow hidden
                white-space nowrap
                text-overflow ellipsis
                background rgba(0,0,0,.5)
                color #fff        
                line-height 5vh                    
</style>
