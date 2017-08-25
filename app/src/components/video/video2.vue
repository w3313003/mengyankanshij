<template>
    <div class='index-wrap'>
        <div class='video-wrap'>
            <div ref='videos' id='video'></div>
            <div class='mask' v-if='nochance'>
                <p style="width:70%;margin:0 auto;font-size:17px;line-height:20px;">{{tips}}</p>
                <router-link to='/Mycenter/invite'>
                    <p class='btn' style="height:50px;line-height:50px">前往邀请＞＞</p>
                </router-link>
            </div>
        </div>
        <div class='video-desc'>
            <div class='video-desc1'>
                <div class='video-title'>{{info.videoname}}</div>
                <div class='video-type'>陆地动物</div>
            </div>
            <div class='video-desc2'>
                简介：{{info.videocont | formatContent}}
            </div>
            <div class='video-desc3'>
                <div class='v-date'>
                    <img src='../.././assets/img/date.png'>
                    <span>{{info.time | formatdate}}</span>
                </div>
                <div class='v-count'>
                    <img src='../.././assets/img/fire.png'>
                    <span>{{info.looks}}次观看</span>
                </div>
            </div>
        </div>
        <div class='comment'>
            <div class='thumbs' v-if='isclick'>
                <img src='../.././assets/img/thumb.png' @click='thumbs'>
                <span @click='thumbs'>{{info.thusum}}</span>
            </div>
            <div class='thumbs' v-else>
                <img src='../.././assets/img/a-thumb.png'>
                <span style="color:#00a1e9">{{info.thusum}}</span>
            </div>
            <div class='star' v-if='isColl'>
                <img src='../.././assets/img/star.png' @click='coll'>
                <span @click='coll'>收藏数{{info.collecnum}}</span>
            </div>
            <div class='star' v-else>
                <img src='../.././assets/img/a-star.png'>
                <span style="color:#00a1e9">已收藏|收藏数{{info.collecnum}}</span>
            </div>
            <div class='rating' @click='rating'>
                <img src='../.././assets/img/rating.png'>
                <span>评论</span>
            </div>
        </div>
        <div class='about-v'>
            <p>相关视频</p>
            <ul class='about-v-ul' id='about-v1'>
                <li v-for='(item,index) in aboutinfo' :key="item" v-if='index<4' @click='wVideo(item)'>
                    <div class='about-v-img'>
                        <video :src='item.videourl' preload="auto" v-show='false' class='a-video'>
    
                        </video>
                        <img :src="item.pic">
                    </div>
                    <div class='about-v-desc'>
                        <div class='v-desc-r1'>
                            <div class='v-desc-r1-1'>{{item.videoname}}</div>
                            <div class='v-desc-r1-2'>{{item.pid}}</div>
                        </div>
                        <div class='v-desc-r2'>
                            视频简介：{{item.videocont | formatContent}}
                        </div>
                        <div class='v-desc-r3'>
                            <img src='../.././assets/img/date.png'> {{item.time | formatdate}}
                        </div>
                        <div class='v-desc-r4'>
                            <img src='../.././assets/img/fire.png'> {{item.looks}}次观看
                        </div>
                    </div>
                </li>
            </ul>
            <div class='getMore' @click='getvideodesc'>
                查看更多
            </div>
            <!--留言列表  -->
            <ul class='rating-ul'>
                <li v-for='(item,index) in rList' :key="item">
                    <div class='header-img'>
                        <img :src='item.u_pic'>
                    </div>
                    <div class='r-content'>
                        <div class='user-id'>{{item.u_nickname}}</div>
                        <div class='rating-text'>{{item.u_message}}</div>
                        <div class='r-row'>
                            <div class='r-time'>{{item.time | formatdate}}</div>
                            <div class='r-count'></div>
                            <span @click='rUser(item)'>回复</span>
                        </div>
                    </div>
                </li>
            </ul>
            <div class='rating-box'>
                <div class='rating-wrap'>
                    <div class='rating-input'>
                        <input type='text' ref='ratingInput' v-model="rContent" @focus="Rfoucs" @blur="Rblur">
                    </div>
                    <span :class='{avtive:spanfoucs}' @click='sendR' v-if='!rUSER'>发布</span>
                    <span :class='{avtive:spanfoucs}' @click='rUSERid' v-else>发布</span>
                </div>
            </div>
        </div>
    
    </div>
</template>
<script>
export default {
    data() {
        return {
            info: {},
            aboutinfo: [],
            rList: [],
            isclick: true,
            isColl: true,
            nochance: false,
            rContent: '',
            rUSER: false,
            spanfoucs: false,
            tips: ''
        }
    },
    methods: {
        thumbs() {
            this.axios.post('/api/index/Videoclass/colloc', {
                id: this.info.id,
                colle: 'zan',
            }).then(res => {
                if (res.data === '点赞成功') {
                    this.info.thusum++;
                    this.isclick = false;
                }
            })
        },
        coll() {
            this.axios.post('/api/index/Videoclass/colloc', {
                id: this.info.id,
                colle: 'colle',
            }).then(res => {
                if (res.data === '收藏成功') {
                    this.info.collecnum++;
                    this.isColl = false;
                } else {
                    this.isColl = false;
                }
            })
        },
        rating() {
            let top = this.$refs.ratingInput.offsetTop;
            window.scrollTo(0, top);
            this.$refs.ratingInput.focus();
        },
        sendR() {
            this.axios.post('/api/index/Videoclass/filemessage', {
                id: this.info.id,
                name: this.info.videoname,
                content: this.rContent
            }).then(res => {
                this.rContent = '';
                this.rList = res.data.vmessages;
                this.$messagebox('评论成功');
            })
        },
        rUser(item) {
            let top = this.$refs.ratingInput.offsetTop;
            window.scrollTo(0, top);
            this.$refs.ratingInput.focus();
            this.rContent = `@${item.u_nickname}:`;
            this.rUSER = true;
            this.$store.commit('rCurrentid', item.id)
        },
        rUSERid() {
            let id = this.$store.state.currentId;
            this.axios.post('/api/index/Videoclass/filedmess', {
                aid: this.info.id,
                name: this.info.videoname,
                content: this.rContent,
                pid: id,
            }).then(res => {
                console.log(res)
                this.rContent = '';
                this.rList = res.data.vmessages;
                this.$messagebox('评论成功');
            })
        },
        wVideo(item) {
            if (item.type === 0) {
                sessionStorage.setItem('currentid', item.id);
                this.$router.push({ name: 'video2', params: { id: item.id } });
                location.reload(true);
            } else {
                sessionStorage.setItem('currentid', item.id)
                this.$router.push({ name: 'video', params: { id: item.id } });
            }
        },
        Rfoucs() {
            var foot = document.getElementsByTagName('footer')[0];
            foot.style.display = 'none';
            this.spanfoucs = true;
        },
        Rblur() {
            var foot = document.getElementsByTagName('footer')[0];
            foot.style.display = 'flex';
            this.spanfoucs = false;
        },
        getvideodesc() {
            this.$router.push({ name: 'vBlock1' })
        }
    },
    mounted() {
        this.$nextTick(() => {
            if ((/Android/gi).test(navigator.userAgent)) {
                window.addEventListener('resize', function () {
                    if (document.activeElement.tagName == 'INPUT' ||
                        document.activeElement.tagName == 'TEXTAREA') {
                        window.setTimeout(function () {
                            document.activeElement.scrollIntoViewIfNeeded();
                        }, 0);
                    }
                });
            };
            this.axios.post('/api/index/videoclass/videoinfo', {
                id: sessionStorage.getItem('currentid')
            }).then(res => {
                if (res.data.message === '观看次数已用完') {
                    this.tips = res.data.barrages.barrage;
                    this.nochance = true;
                    this.rList = res.data.videomess;
                    this.aboutinfo = res.data.aboutvideo;
                    this.info = res.data.freemyinfo;
                    var video = new tvp.VideoInfo();
                    video.setVid(this.info.videourl);
                    video.setHistoryStart(0);
                    video.setTagStart(0)
                    var player = new tvp.Player();
                    player.create({
                        video: video,
                        modId: this.$refs.videos.id,
                        autoplay: false
                    });
                    let that = this;
                    player.onplaying = function () {
                        that.nochance = true;
                        this.pause();
                    }
                    if (!localStorage.getItem('watcharr')) {
                        let arr = [];
                        localStorage.setItem('watcharr', JSON.stringify(arr))
                    } else {
                        var arr = JSON.parse(localStorage.getItem('watcharr'));
                        arr.push(this.info);
                        localStorage.setItem('watcharr', JSON.stringify(arr));
                    }
                } else {
                    this.rList = res.data.videomess;
                    this.aboutinfo = res.data.aboutvideo;
                    this.info = res.data.freemyinfo;
                    if (!localStorage.getItem('watcharr')) {
                        let arr = [];
                        localStorage.setItem('watcharr', JSON.stringify(arr))
                    } else {
                        var arr = JSON.parse(localStorage.getItem('watcharr'));
                        arr.push(this.info);
                        localStorage.setItem('watcharr', JSON.stringify(arr));
                    };
                    var video = new tvp.VideoInfo();
                    video.setVid(this.info.videourl);
                    video.setHistoryStart(0);
                    video.setTagStart(0)
                    var player = new tvp.Player();
                    player.create({
                        video: video,
                        modId: this.$refs.videos.id,
                        autoplay: false
                    });
                }

            });
        })

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




<style lang='stylus' scoped>
@css{
    #video{
        height:100%
    }
}
@import '../.././assets/func.styl'
.video-wrap
    width 100%
    height 175px
    position relative
    video
        width 100%
        height 100%
    .mask
        width 100%
        height 100%
        position absolute
        background-color rgba(0,0,0,.7)  
        left 0
        top 0
        display flex
        flex-direction column
        justify-content center
        p
            text-align center  
            height 35px
            font-size 20px
            color #fff
            &.btn
                color color    
.video-desc
    width 90vw
    margin 20px auto 0
    padding-bottom 10px
    border-bottom 1px solid #666
    overflow scroll
    .video-desc1
        display flex
        justify-content space-between
        margin 10px 0 
        .video-type
            font-size 12px
            color color
    .video-desc2
        font-size 14px
        line-height 20px
        color #666
        width 100%  
        overflow scroll      
    .video-desc3
        height 16px
        display flex
        line-height 16px
        .v-date,.v-count
            width 50%
            height 100%
            font-size 12px
            color #666
            img
                width 14px
                height 14px        
.comment
    width 90vw
    margin 0 auto
    height 40px
    line-height 40px
    display flex
    align-items:center
    border-bottom 1px solid #666
    div
        flex 1
        height 14px
        line-height 14px
        font-size 12px
        &.blue
            color color
        img
            width 14px
            height 14px 
            vertical-align bottom
.about-v
    width 90 vw
    margin 0 auto
    p
        height 30px
        line-height 30px
        font-size 15px
    .about-v-ul
        width 100%
        li
            display flex
            justify-content space-between
            box-sizing border-box
            padding 2px
            border 1px solid #666
            margin-bottom 10px
            .about-v-img
                width 43%
                height 100%
                overflow hidden
                position relative
                .time-l
                    position absolute
                    right 0
                    bottom 0
                    width 12.5vw
                    height 14px
                    line-height 14px
                    background rgba(12,146,199,.7)
                    color #fff
                    text-align center
                    font-size 12px
                img
                    width 100%                   
            .about-v-desc
                width 54%
            .v-desc-r1
                display flex
                justify-content space-between
                height 20px
                line-height 20px   
                .v-desc-r1-1 
                    font-size 14px
                .v-desc-r1-2
                    font-size 12px
                    color color
            .v-desc-r2
                font-size 12px 
                width 100%
                line-height 14px
                display: -webkit-box; /** 对象作为伸缩盒子模型显示 **/
                -webkit-box-orient: vertical; /** 设置或检索伸缩盒对象的子元素的排列方式 **/
                -webkit-line-clamp: 3; /** 显示的行数 **/
                overflow: hidden;  /** 隐藏超出的内容 **/
                @media only screen and (max-width)
                    font-size 10px
            .v-desc-r3
                height 14px
                font-size 12px
                margin 10px 0
                img
                    width 14px
                    height 14px
            .v-desc-r4
                height 14px
                font-size 12px
                margin 10px 0
                img
                    width 14px
                    height 14px
                    vertical-align bottom 
    .getMore
        text-align center
        letter-spacing 3px 
    .rating-ul
        width 90vw
        margin 0 auto
        li
            width 100%
            border-bottom 1px solid #afafaf
            display flex
            box-sizing border-box
            padding-bottom 10px
            padding-top 5px
            .header-img
                flex 0 0 8vw
                img
                    width 100%
                    border-radius 50%
            .r-content
                flex 1
                display flex
                flex-direction column
                justify-content space-between
                box-sizing border-box
                padding-left 8px
                .user-id
                    color color
                    font-size 15px
                    height 20px
                    line-height 20px
                .rating-text
                    font-size 15px
                    width 100% 
                    
                .r-row
                    display flex
                    justify-content space-between
                    font-size 15px
                    margin-top 10px
                    .r-time
                        color #afafaf
                    span
                        color  color
    .rating-box
        width 90vw
        height 40px
        margin 0 auto  
        display flex
        flex-direction column                         
        justify-content center
        .rating-wrap
            width 100%
            height 25px
            display flex
            .rating-input
                flex 1
                border 1px solid #666
                height 30px
                border-radius 20px
                box-sizing border-box
                padding-left 20px
                overflow hidden
                input
                    font-size 13px
                    vertical-align bottom
                    height 80%
            span
                flex 0 0 40px  
                height 30px  
                font-size 15px
                text-align center
                line-height 30px
                &.avtive
                    display inline-block
                    background color
                    border-radius 10px
</style>
