import Vue from 'vue'
import Router from 'vue-router'
import index from '@/components/index/index'
import vBlock1 from '@/components/video/vBlock1'
import vBlock2 from '@/components/video/vBlock2'
import video from '@/components/video/video'
import video2 from '@/components/video/video2'
import contact from '@/components/contact/contact'
import search from '.././search'
import series from '@/components/video/series'
// 个人中心
import Mycenter from '@/components/Mycenter/Mycenter'
import pData from '@/components/Mycenter/pData'
import wCash from '@/components/Mycenter/wCash'
import area from '@/components/Mycenter/area'
import msg from '@/components/Mycenter/msg'
import msgDetail from '@/components/Mycenter/msg-detail'
import charge from '@/components/Mycenter/charge'
import mRecord from '@/components/Mycenter/mRecord'
import bRecord from '@/components/Mycenter/bRecord'
import wRecord from '@/components/Mycenter/wRecord'
import cRecord from '@/components/Mycenter/cRecord'
import invite from '@/components/Mycenter/invite'
import poster from '@/components/Mycenter/poster'
import inviteuser from '@/components/Mycenter/inviteuser'
// 登录
import login from '@/components/login/login'
import register from '@/components/login/register'
import reset from '@/components/login/reset'
import find from '@/components/login/find'
import login1 from "@/components/login/login1"
import login2 from "@/components/login/login2"

Vue.use(Router)
var router;
export default router = new Router({
  routes: [{
      path: '/',
      name: 'index',
      component: index,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        if (islogin) {
          next();
        } else {
          next({
            name: 'login'
          })
        }
      }
    },
    // 搜索
    {
      path: '/search',
      name: 'search',
      component: search,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 百科视频
    {
      path: '/video/vBlock1',
      name: 'vBlock1',
      component: vBlock1,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    {
      path: '/video/:id',
      name: 'video',
      component: video,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    {
      path: '/video2/:id',
      name: 'video2',
      component: video2,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    {
      path: '/series',
      name: 'series',
      component: series,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 大脑视频
    {
      path: '/video/vBlock2',
      name: 'vBlock2',
      component: vBlock2,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    {
      path: '/contact',
      name: 'contact',
      component: contact,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 个人中心
    {
      path: '/Mycenter',
      name: 'Mycenter',
      component: Mycenter,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    {
      path: '/Mycenter/pData/area',
      name: 'area',
      component: area,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 提现页
    {
      path: '/wCash',
      name: 'wCash',
      component: wCash,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    {
      path: '/Mycenter/msgDetail',
      name: 'msgDetail',
      component: msgDetail,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 充值
    {
      path: '/Mycenter/charge',
      name: 'charge',
      component: charge,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 充值记录
    {
      path: '/Mycenter/mRecord',
      name: 'mRecord',
      component: mRecord,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 购买记录
    {
      path: '/Mycenter/bRecord',
      name: 'bRecord',
      component: bRecord,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 观看记录
    {
      path: '/Mycenter/wRecord',
      name: 'wRecord',
      component: wRecord,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 收藏记录
    {
      path: '/Mycenter/cRecord',
      name: 'cRecord',
      component: cRecord,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 个人资料
    {
      path: '/Mycenter/pData',
      name: 'pData',
      component: pData,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 爱心邀请
    {
      path: '/Mycenter/invite',
      name: 'invite',
      component: invite,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    {
      path: '/Mycenter/poster',
      name: 'poster',
      component: poster,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    {
      path: '/Mycenter/inviteuser',
      name: 'inviteuser',
      component: inviteuser,
      beforeEnter(to, form, next) {
        Vue.prototype.axios.post('/api/index/index/apps').then(res => {
          console.log(res.data)
          if (res.data == true) {
            alert('账号已在其他地方登录');
            var opened = window.open('about:blank', '_self');
            // /*opened.opener = null;
            opened.close();
          }
        });
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        islogin ? next() : next({
          name: 'login'
        });
      }
    },
    // 登录
    {
      path: '/login',
      name: 'login',
      component: login,
      beforeEnter(to, form, next) {
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        // if (islogin) {
        //   next({
        //     name: 'index'
        //   })
        // } else {
        var url = location.href,
          num = url.indexOf('/#'),
          arr = url.split('/#');
        location.href = arr.join('/?#');
        next();
        // }
      }
    },
    {
      path: '/login1',
      name: 'login1',
      component: login1,
      beforeEnter(to, form, next) {
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        // if (islogin) {
        //   next({
        //     name: 'index'
        //   })
        // } else {
        var url = location.href,
          num = url.indexOf('/#'),
          arr = url.split('/#');
        location.href = arr.join('/?#');
        next();
        // }
      }
    },
    {
      path: '/login2',
      name: 'login2',
      component: login2,
      beforeEnter(to, form, next) {
        let islogin = JSON.parse(sessionStorage.getItem('isLogin'));
        // if (islogin) {
        //   next({
        //     name: 'index'
        //   })
        // } else {
        var url = location.href,
          num = url.indexOf('/#'),
          arr = url.split('/#');
        location.href = arr.join('/?#');
        next();
        // }
      }
    },
    {
      path: '/login/register/',
      name: 'register',
      component: register
    },
    {
      path: '/login/register/:id',
      name: 'register1',
      component: register,
    },
    {
      path: '/login/reset',
      name: 'reset',
      component: reset
    },
    {
      path: '/login/find',
      name: 'find',
      component: find
    },
  ],
})
// router.beforeEach((to, from, next) => {
//   Vue.prototype.axios.post('/api/index/index/apps').then(res => {
//     console.log(res.data)
//     if (res.data == true) {
//       alert('账号已在其他地方登录');
//       var opened = window.open('about:blank', '_self');
//       // /*opened.opener = null;
//       opened.close();
//     } else {
//       next();
//     }
//   })
// })
