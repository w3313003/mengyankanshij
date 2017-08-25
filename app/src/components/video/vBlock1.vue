<template>
    <div class='index-wrap' ref='scroll'>
        <div class='nav-mask' v-if='navshow'>
            <ul class='nm-wrap'>
                <li v-for='(item,index) in navList' :key='item' :class='{"active": item.isClick}' @click='choose(item,index)'>
                    {{item.name}}
                </li>
            </ul>
        </div>
        <div class='vb1-box'>
            <div class='header'>
                <router-link to='/search' tag='div'>
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
                    <p class='title vb1-active'>百科课堂</p>
                    <p class='title'>
                        <router-link :to='{name:"vBlock2"}'>全脑开发课堂</router-link>
                    </p>
                </div>
            </div>
            <div class='vb1-nav'>
                <div class='vnav-all' @click='chooseAll' :class="{'active':isAll}">全部</div>
                <div class='srcoll-nav' ref='navScroll'>
                    <ul class='nav-wrap'>
                        <li v-for='(item,index) in navList' :key='item' class='nav-item' :class='{"active":item.isClick}' @click='choose(item,index)' ref='nav'>
                            {{item.name}}
                        </li>
                    </ul>
                </div>
                <div class='nav-flod' @click='navshow=true'>+</div>
            </div>
            <div class='sortBlock'>
                <select @change='Sort' v-model="sort">
                    <option>按时间顺序排列</option>
                    <option>按时间倒序排列</option>
                    <option>按浏览量顺序排列</option>
                    <option>按浏览量倒序排列</option>
                </select>
            </div>
            <mt-loadmore :bottom-method="loadMore" :bottom-all-loaded='isbottom' ref="loadmore" v-if='isAll'>
                <ul class='videoUl'>
                    <li v-for='(item,index) in videoList' :key='item' v-if='index < 8+count' @click='goWacth(item)'>
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
            <mt-loadmore :bottom-method="loadmore" :bottom-all-loaded='isbottom1' ref="loadmore1" v-else>
                <ul class='videoUl'>
                    <li v-for='(item,index) in itemList' :key='item' v-if='index < 8+count1' @click='goWacth(item)'>
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
import BScroll from 'better-scroll'
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
            navList: [
            ],
            navshow: false,
            count: 0,
            isAll: true,
            count: 0,
            count1: 0,
            isbottom: false,
            isbottom1: false,
            videoList: [
            ],
            itemList: [],
            sort: '按时间顺序排列',
        }
    },
    created() {
        this.$indicator.open({
            text: '全力加载中...',
            spinnerType: 'fading-circle'
        });
        this.axios.get('/api/index/videoclass/videoclassarr').then(res => {
            res.data.classarr.forEach(val => {
                if (!val.isClick) {
                    this.$set(val, 'isClick', false)
                }
            });
            this.navList = res.data.classarr;
            this.initscroll();
            res.data.videoarrs.forEach(val => {
                val.type === 0 ? this.videoList.push(val) : false;
            });
            this.$indicator.close();
        }, res => {
            this.$indicator.open('网络错误');
        })
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
        loadmore() {
            if (this.count1 == this.itemList.length - 8) {
                this.isbottom1 = true;
                this.$refs.loadmore1.onBottomLoaded();
                this.$toast('加载完毕')
                return;
            }
            setTimeout(() => {
                this.count1 += 4;
                this.$refs.loadmore1.onBottomLoaded();
            }, 1000)
        },
        choose(item, index) {
            this.navList.forEach((item) => {
                item.isClick = false;
            });
            this.navList[index].isClick = true;
            this.navshow = false;
            this.isAll = false;
            this.itemList = [];
            this.videoList.forEach((val, i) => {
                if (val.pid === item.name) {
                    this.itemList.push(val)
                }
            });
            let navList = this.$refs.nav,
                el = navList[index];
            this.scroll.scrollToElement(el, 300, -5)

        },
        chooseAll() {
            this.isAll = true;
            this.navList.forEach(val => {
                val.isClick = false;
            })
        },
        initscroll() {
            if (!this.scroll) {
                this.scroll = new BScroll(this.$refs.navScroll, {
                    click: true,
                    startX: 0,
                    scrollX: true
                });
            } else {
                this.scroll.refresh();
            }
        },
        loadMore() {
            this.count += 2;
        },
        timereverse() {
            this.sort.forEach((item, index) => {
                index === 1 ? (item.isclick = true) : (item.isclick = false)
            })
        },
        Sort() {
            if (this.sort === '按时间顺序排列') {
                this.videoList.sort((a, b) => {
                    return a.time - b.time;
                });
                this.itemList.sort((a, b) => {
                    return a.time - b.time;
                });
            };
            if (this.sort === '按时间倒序排列') {
                this.videoList.sort((a, b) => {
                    return b.time - a.time;
                });
                this.itemList.sort((a, b) => {
                    return b.time - a.time;
                });
            };
            if (this.sort === '按浏览量顺序排列') {
                this.videoList.sort((a, b) => {
                    return a.looks - b.looks;
                });
                this.itemList.sort((a, b) => {
                    return a.time - b.time;
                });
            };
            if (this.sort === '按浏览量倒序排列') {
                this.videoList.sort((a, b) => {
                    return b.looks - a.looks;
                });
                this.itemList.sort((a, b) => {
                    return b.looks - a.looks;
                });
            };
        },
        goWacth(item) {
            sessionStorage.setItem('currentid', item.id)
            this.$router.push({ name: 'video2', params: { id: item.id } });
        }
    },
}
</script>
<style lang="stylus">
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
            box-sizing border-box
            padding-right 20px
            display flex
            justify-content space-between
            align-items center
            .img-wrap
                width 20px
                height 20px
                img
                    width 100%
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
    .vb1-nav
        width 100%
        display flex
        font-size 20px
        height 30px
        overflow hidden
        line-height 30px
        margin 10px 0
        .vnav-all
            font-size 18px
            &.active
                color color
        .srcoll-nav
            width 80% 
            overflow hidden
            .nav-wrap
                width 1070px;
                height 30px;
                overflow hidden
                li
                    font-size 18px
                .active
                    color color
                .nav-item
                    float left
                    padding 0 5px
        .nav-flod
            font-size 30px
    .sortBlock
        position relative
        width 40vw
        border 1px solid #aaa
        height 25px
        font-size 15px   
        margin 0 auto
        text-align center
        line-height 25px
        select
            border none
            outline none
            width 100%
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