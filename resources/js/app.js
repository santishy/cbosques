require('./bootstrap');
/*
  *
  Activar los tooltip
*/


window.Vue = require('vue');
window.Vuex = require('vuex')
axios.defaults.headers.common['Authorization'] = 'Bearer '+window.token

Vue.component('InfiniteLoading',require('vue-infinite-loading'));
Vue.component('app-component', require('./components/AppComponent.vue').default);
Vue.component('index',require('./views/cycles/Index').default);

Vue.use('InfiniteLoading');
import VueRouter from './routes.js';
import {store} from './store.js';


const app = new Vue({
    el: '#app',
    router:VueRouter,
    store
});
