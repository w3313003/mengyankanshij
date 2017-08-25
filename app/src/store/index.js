import Vue from 'vue'
import Vuex from 'vuex'
import state from './state.js'
import mutations from './Mutations'
import getters from './getters'
import actions from './Actions'
Vue.use(Vuex)

export default  new Vuex.Store({
    state,
    mutations,
    getters,
    actions
});
