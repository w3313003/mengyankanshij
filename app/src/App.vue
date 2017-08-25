<template>
  <div class='wrap'>
    <div class='index-wrap' ref='scroll'>
      <transition name='router' mode='out-in'>
        <router-view></router-view>
      </transition>
    </div>
    <footer>
      <router-link to='/' class='r-item' @click.native='click'>
        <img src='./assets/foot-icon1.png' class='foot-img' v-if='!isclick1' />
        <img src='./assets/foot-a-icon1.png' class='foot-img' v-else/>
        <span :class="{'now':isclick1}">首页</span>
      </router-link>
      <router-link to='/video/vBlock1' class='r-item' @click.native='click'>
        <img src='./assets/foot-icon2.png' class='foot-img' v-if='!isclick2' />
        <img src='./assets/foot-a-icon2.png' class='foot-img' v-else/>
        <span :class="{'now':isclick2}">课程分类</span>
      </router-link>
      <router-link to='/contact' class='r-item' @click.native='click'>
        <img src='./assets/foot-icon3.png' class='foot-img' v-if='!isclick3' />
        <img src='./assets/foot-a-icon3.png' class='foot-img' v-else/>
        <span :class="{'now':isclick3}">联系客服</span>
      </router-link>
      <router-link to='/Mycenter' class='r-item' @click.native='click'>
        <img src='./assets/foot-icon4.png' class='foot-img' v-if='!isclick4' />
        <img src='./assets/foot-a-icon4.png' class='foot-img' v-else/>
        <span :class="{'now':isclick4}">个人中心</span>
      </router-link>
    </footer>
  </div>
</template>

<script>
import BScroll from "better-scroll"
export default {
  created() {
    // var useragent = navigator.userAgent;
    // if (useragent.match(/MicroMessenger/i) != 'MicroMessenger') {
    //   alert('请在微信浏览器中打开');
    //   var opened = window.open('about:blank', '_self');
    //   opened.opener = null;
    //   opened.close();
    // };
  },
  name: 'app',
  data() {
    return {
      isclick1: false,
      isclick2: false,
      isclick3: false,
      isclick4: false,
    }
  },
  methods: {
    click() {
      let path = this.$route.path;
      if (path.length === 1) {
        this.isclick1 = true;
        this.isclick2 = false;
        this.isclick3 = false;
        this.isclick4 = false;
      };
      if (path.indexOf('video') !== -1) {
        this.isclick1 = false;
        this.isclick2 = true;
        this.isclick3 = false;
        this.isclick4 = false;
      };
      if (path.indexOf('contact') !== -1) {
        this.isclick1 = false;
        this.isclick2 = false;
        this.isclick3 = true;
        this.isclick4 = false;
      };
      if (path.indexOf('Mycenter') !== -1) {
        this.isclick1 = false;
        this.isclick2 = false;
        this.isclick3 = false;
        this.isclick4 = true;
      };

    },
  },
  mounted() {
    if (this.$route.path.length === 0) {
      this.isclick1 = true;
    }
  }
}
</script>

<style lang='stylus'>
@css{
    .router-enter-active,.router-leave-active{
        transition:all 0.5s;
    }
    .router-enter{
      opacity :0;
      transform : translate3d(-100%,0,0)
    }   
    .router-leave-to{
      transform : translate3d(100%,0,0)
    }
    .wrap{
      display :flex;
      flex-direction:column;
      width : 100%;
      height: 100%;
    }
}
@import  "./assets/func.styl"
  footer
    flex 10vh
    border-top 1px solid #e5e5e5
    background #fff
    bottom 0
    display flex
    justify-content space-around
    flex-wrap wrap
    align-items center
    .foot-img
      width 20px
      height 20px
    .r-item
      display flex
      height 100%
      flex-direction column
      justify-content center
      text-align center
      align-items center
      span
        margin-top 10px
        font-size 15px
      .now
        color color
</style>
