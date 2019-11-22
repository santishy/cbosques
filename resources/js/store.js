import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex)

import actions from './actions'
import mutations from './mutations'
import getters from './getters';

export const store = new Vuex.Store({
  state:{
    cycles:[],
    status:'',
    access_token:sessionStorage.getItem('access_token') || '',
    user:{},
    users:[],
    unreadNotifications:[],
    hasError:{},
    roles:JSON.parse(sessionStorage.getItem('roles')) || '',
    departments:[]
  },
  mutations,
  actions,
  getters,
})
