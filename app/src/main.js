// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import axios from "axios"
import Mint from "mint-ui"
import "mint-ui/lib/style.css"
import store from './store'
// axios.defaults.baseURL = 'http://www.test.com/';
// axios.defaults.withCredentials = true;
// window.HOST = 'http://www.test.com/';



Vue.use(Mint)
Vue.prototype.axios = axios;
window.checkph = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1})|(14[0-9]{1})|(17[0-9]{1}))+\d{8})$/;
window.watchArr = [];
Vue.config.productionTip = false
/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: {
    App
  },
});
Vue.filter('formatDate', function (value) {
  var date = new Date(value * 1000);
  var m = date.getMonth() + 1;
  var d = date.getDate();
  m = m < 10 ? `0${m}` : m;
  d = d < 10 ? `0${d}` : d;
  return `${m}-${d}`
});
