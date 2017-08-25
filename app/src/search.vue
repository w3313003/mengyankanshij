<template>
    <div>
        <div class='search-box'>
            <input placeholder="请输入视频的关键词" v-model="searchwrod" @keyup.enter='searchs' />
            <div class='img-wrap' @click='searchs'>
                <img src='./assets/img/search-icon.png' />
            </div>
        </div>
        <div class='search-list' v-if='hasRecord'>
            <div class='title'>
                <span>历史搜索记录</span>
                <div @click="hasRecord=false">
                    <img src='./assets/img/trash-icon.png' />
                </div>
            </div>
            <div class='content' v-for='(item,index) in searchList' :key="item" @click='searchitem(item)'>
                <span >{{item}}</span>
                <div @click.stop='deleteitem(index)'>
                    <img src='./assets/img/b-delete.png' />
                </div>
            </div>
        </div>
        <div v-if='isSearche'>
            <ul>
                <li v-for='(item,index) in searchList' :key="index" class='searchLi' @click='wVideo(item)'>
                    <div class='s-wrap'>
                        <div class='left-img-wrap'>
                            <img :src='item.pic'>
                        </div>
                        <div class='right-wrap'>
                            <p class='title'>
                                视频名：
                                <span style="color:red"> {{item.videoname}} </span>
                            </p>
                            <p>
                                已播放
                                <span style="color:red">{{item.looks}}</span>次
                            </p>
                            <p style="color:#666;font-size:14px">
                                {{item.time | formatdate}}
                            </p>
    
                        </div>
                    </div>
    
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            hasRecord: false,
            isSearche: false,
            searchwrod: '',
            searchList: []
        }
    },
    created() {
        if (this.$store.getters.getHistory.length > 0) {
            this.hasRecord = true;
        };
        this.searchList = this.$store.getters.getHistory;
    },
    methods: {
        searchs() {
            this.$indicator.open({
                text: '加载中...',
                spinnerType: 'double-bounce'
            })
            this.hasRecord = false;
            this.isSearche = true;
            this.searchList.push(this.searchwrod);
            this.$store.commit('saveHistory', this.searchList);
            this.axios.post('/api/index/videoclass/search', {
                search: this.searchwrod
            }).then(res => {
                this.searchList = res.data;
                this.hasRecord = false;
                this.$indicator.close();
            })
        },
        deleteitem(index) {
            this.searchList.splice(index, 1);
            if (this.searchList.length === 0) {
                this.hasRecord = false;
            }
        },
        wVideo(item) {
            if (item.type === 0) {
                this.$store.commit('setVideo2', item);
                sessionStorage.setItem('currentid', item.id)
                this.$router.push({ name: 'video2', params: { id: item.id } });
            } else {
                sessionStorage.setItem('currentid', item.id)
                this.$router.push({ name: 'video', params: { id: item.id } });
            }
        },
        searchitem(item){
            this.searchwrod = item;
            this.searchs();
        }
    },
    filters: {
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
    }
}
</script>

<style lang="stylus" scoped>
@css{
    .searchLi{
        padding-top: 5px;
        padding-bottom:10px;
        border-bottom : 1px solid #666;
    }
    .s-wrap{
        display :flex;
        width: 90vw;
        margin: 0 auto;
    }
    .s-wrap .left-img-wrap{
        flex: 0 0 40%;
    }
    .s-wrap .left-img-wrap img{
        width :100%
    }
    .right-wrap{
        flex:1;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:space-around;
    }
}
.search-box
    width 90vw
    margin 10px auto
    height 25px
    border-radius 10px
    border 1px solid #666
    box-sizing border-box
    padding 0 10px
    display flex
    justify-content space-between
    align-items center
    input
        width 80%
    .img-wrap
        width 20px
        height 20px
        img
            width 100%
.search-list
    width 85vw
    margin 0 auto
    .title
        display flex
        justify-content space-between
        img
            width 16px
            height 16px 
.content
    width 80vw
    margin 10px auto
    display flex
    justify-content space-between
    img
        width 14px
        height 14px                                  
</style>
