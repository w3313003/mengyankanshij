<template>
    <div class='index-wrap' ref='scroll'>
        <div class='video-wrap'>
            <!-- <iframe preload="meta" :src='info.videourl' controls ref='video' @timeupdate='ttt'>
                                                                                                                                                                                                        </iframe> -->
            <!-- <iframe preload="meta" src='http://v.qq.com/iframe/player.html?vid=u0332wyg5oa&tiny=0&auto=0' controls ref='video' @timeupdate='ttt'> -->
            <div ref='videos' id='video'></div>
            <!-- <video controls src='http://v.qq.com/iframe/player.html?vid=u0332wyg5oa&tiny=0&auto=0' ></video> -->
            <div class='mask' v-if='false'>
                <p>视频加载失败,</p>
                <p> 请点击重新加载。</p>
                <p class='btn' @click="reload">点击刷新＞＞</p>
            </div>
            <div class='mask' v-if='false'>
                <p>视频购买失败,</p>
                <p> 请重新尝试购买。</p>
                <p class='btn'>点击返回＞＞</p>
            </div>
            <div class='mask' v-if='false'>
                <p>视频购买成功,您可以观看此视频,</p>
                <p>当前账户余额￥50.00。</p>
                <p class='btn'>点击观看＞＞</p>
            </div>
            <div class='mask' v-if='false'>
                <p>购买本视频将从您的账户余额中扣除9.90元,</p>
                <p>您的当前账户余额为0.00元,余额不足。</p>
                <p class='btn'>前往充值＞＞</p>
            </div>
            <div class='mask' v-if='nochance'>
                <p style="font-size:17px;line-height:20px;">{{tips}}</p>
                <p class='btn' style="height:50px;line-height:50px" @click='isbuy=true'>前往购买＞＞</p>
            </div>
        </div>
        <div class='video-desc'>
            <div class='video-desc1'>
                <div class='video-title'>{{info.videoname}}</div>
                <div class='video-type'>{{info.pid}}</div>
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
        <div class='video-price' v-if='varryshow'>
            <p class='title'>系列视频打包购买享优惠</p>
            <div class='price'>
                <div class='price-img'>
                    <router-link :to='{name:"series"}' tag='span'>
                        <img :src='varrys1.pic' />
                    </router-link>
                </div>
                <div class='price-desc'>
                    <div class='p-title'>{{varrys1.series}}系列</div>
                    <div class='p-cont'>
                        <p v-for='item in varrysname' :key="item">
                            {{item}}
                        </p>
                    </div>
                    <div class='p-innerwrap'>
                        <div class='cur-price'>打包价:￥{{varrys1.pack | formatPrice}}</div>
                        <div class='old-price'>原价:￥{{varrys1.oldPirce | formatPrice}}</div>
                    </div>
                    <div class='b-btn' @click='isseriesbuy=true'>
                        <span>立即购买</span>
                    </div>
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
            <ul class='about-v-ul' id='about-v2'>
                <li v-for='(item,index) in videoList' :key="item" v-if='index<4' @click='wVideo(item)'>
                    <video :src='item.videourl' autoplay='autoplay' v-show='false' class='a-video'>
                    </video>
                    <div class='about-v-img'>
                        <img :src='item.pic'>
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
            <ul class='rating-ul'>
                <li v-for='item in rList' :key="item">
                    <div class='header-img'>
                        <img :src='item.u_pic'>
                    </div>
                    <div class='r-content'>
                        <div class='user-id'>{{item.u_nickname}}</div>
                        <div class='rating-text'>{{item.u_message}}</div>
                        <div class='r-row'>
                            <div class='r-time'>{{item.time |formatdate }}</div>
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
        <mt-actionsheet :actions="buyvideo" v-model="isbuy">
        </mt-actionsheet>
        <mt-actionsheet :actions="buyseriesvideo" v-model="isseriesbuy">
        </mt-actionsheet>
    </div>
</template>
<script>
import Vue from 'vue'
export default {
    data() {
        return {
            videoList: [
            ],
            rList: [],
            info: {},
            isclick: true,
            isColl: true,
            tips: '',
            varryshow: false,
            nochance: false,
            buy: false,
            rContent: '',
            rUSER: false,
            varrysname: [],
            varrys: [],
            varrys1: [],
            series: '',
            num: '',
            spanfoucs: false,
            currentSid: [],
            isbuy: false,
            isseriesbuy: false,
            buyvideo: [{
                name: '余额付款',
                method: () => {
                    window.that.axios.post('/api/index/recharge/mypay', {
                        id: window.that.info.id,
                        videoname: window.that.info.videoname,
                        videoprice: window.that.info.single
                    }).then(res => {
                        this.$messagebox.alert(res.data).then(() => {
                            location.reload(true)
                        })
                    })
                }
            }, {
                name: '微信支付',
                method: () => {
                    window.that.axios.post('/api/index/recharge/pay', {
                        id: window.that.info.id,
                        videoname: window.that.info.videoname,
                        videoprice: window.that.info.single
                    }).then(res => {
                        window.location.href = res.data;
                    })
                }
            }
            ],
            buyseriesvideo: [{
                name: '余额付款',
                method: () => {
                    window.that.axios.post('/api/index/recharge/mypay', {
                        id: window.that.currentSid,
                        videoname: window.that.varrys1.series,
                        videoprice: window.that.varrys1.pack
                    }).then(res => {
                        this.$messagebox.alert(res.data).then(() => {
                            location.reload(true)
                        })
                    })
                }
            }, {
                name: '微信支付',
                method() {
                    window.that.axios.post('/api/index/recharge/pay', {
                        id: window.that.currentSid,
                        videoname: window.that.varrys1.series,
                        videoprice: window.that.varrys1.pack
                    }).then(res => {
                        console.log(res)
                        window.location.href = res.data;
                    })
                }
            }
            ]
        }
    },
    methods: {
        // ttt() {
        //     if (this.buy === false) {
        //         let time = this.$refs.video.currentTime;
        //         console.log(time)
        //         if (this.$refs.video.currentTime > this.num) {
        //             this.nochance = true;
        //             this.$refs.video.pause();
        //             this.$refs.video.load();
        //         }
        //     } else {
        //         return;
        //     }
        // },
        // pay() {
        //     let callpay = function () {
        //         if (typeof WeixinJSBridge == "undefined") {
        //             if (document.addEventListener) {
        //                 document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
        //             } else if (document.attachEvent) {
        //                 document.attachEvent('WeixinJSBridgeReady', jsApiCall);
        //                 document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
        //             }
        //         } else {
        //             jsApiCall();
        //         }
        //     };
        //     this.axios.post('/api/index/recharge/pay', {
        //         id: this.info.id,
        //         videoname: this.info.videoname,
        //         videoprice: this.info.single
        //     }).then(res => {
        //         console.log(res);
        //         window.location.href = res.data;
        //     })
        // },
        // buy() {
        //     this.axios.post('/api/index/recharge/pay', {
        //         id: this.currentSid,
        //         videoname: this.varrys1.series,
        //         videoprice: this.varrys1.pack
        //     }).then(res => {
        //         window.location.href = res.data;
        //     })
        // },
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
                this.rContent = '';
                this.rList = res.data.vmessages;
                this.$messagebox('评论成功');
            })
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
            this.$router.push({ name: 'vBlock2' })
        }
    },
    mounted() {
        this.$nextTick(() => {
            window.that = this;
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
            this.$indicator.open('加载中');
            this.axios.post('/api/index/videoclass/videomyinfo', {
                id: sessionStorage.getItem('currentid')
            }).then(res => {
                console.log(res.data);
                if (res.data.infomess == '未购买') {
                    var reg = /\d{1,}/;
                    this.num = res.data.barrages.barrage.match(reg)[0];
                    this.tips = res.data.barrages.barrage;
                    this.buy = false;
                    this.info = res.data.filesinfo;
                    this.rList = res.data.videomess;
                    if (res.data.varrys) {
                        this.varryshow = true;
                        this.varrys = res.data.varrys[0];
                        var varry = [];
                        this.varrys.forEach((val, i) => {
                            varry.push(val.id);
                            this.varrysname.push(val.videoname);
                        });
                        this.currentSid = varry;
                        this.varrys1 = this.varrys[0];
                        var sum = 0;
                        this.varrys.forEach(v => {
                            sum += v.single;
                        })
                        this.$set(this.varrys1, 'oldPirce', sum);
                    } else {
                        this.varryshow = false;
                    }
                    this.videoList = res.data.aboutvideo;
                    this.$indicator.close();
                    if (!localStorage.getItem('watcharr')) {
                        let arr = [];
                        localStorage.setItem('watcharr', JSON.stringify(arr))
                    } else {
                        var arr = JSON.parse(localStorage.getItem('watcharr'));
                        arr.push(this.info);
                        localStorage.setItem('watcharr', JSON.stringify(arr));
                    }
                    var video = new tvp.VideoInfo();
                    video.setVid(this.info.videourl);
                    video.setHistoryStart(0);
                    video.setTagStart(0);
                    var player = new tvp.Player();
                    player.create({
                        video: video,
                        modId: this.$refs.videos.id,
                        autoplay: false
                    });
                    let that = this;
                    player.onplaying = function () {
                        var timer = setInterval(() => {
                            if (this.getPlaytime() >= that.num) {
                                that.nochance = true;
                                this.pause();
                                clearInterval(timer);
                            };
                        }, 10)
                    }
                } else {
                    this.buy = true;
                    this.info = res.data.filesinfo;
                    this.rList = res.data.videomess;
                    if (res.data.varrys) {
                        this.varryshow = true;
                        this.varrys = res.data.varrys[0];
                        this.varrys.forEach((val, i) => {
                            this.varrysname.push(val.videoname);
                        });
                        this.varrys1 = this.varrys[0];
                        this.$set(this.varrys1, 'oldPirce', this.varrys.reduce((p, c) => {
                            return p.single + c.single;
                        })
                        );
                    } else {
                        this.varryshow = false;
                    }
                    this.videoList = res.data.aboutvideo;
                    this.$indicator.close();
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
        },
        formatPrice(value) {
            return Number.parseFloat(value).toFixed(2);
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
        z-index:9999
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
    overflow: scroll;  /** 隐藏超出的内容 **/
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
.video-price
    width 90vw
    margin 0 auto
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
