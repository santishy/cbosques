require('./bootstrap');
/*
  *
  Activar los tooltip
*/


window.Vue = require('vue');
window.Vuex = require('vuex')

Vue.component('InfiniteLoading',require('vue-infinite-loading'));
Vue.component('app-component', require('./components/AppComponent.vue').default);
Vue.component('index',require('./views/cycles/Index').default);
Vue.component('notifications-component',require('./components/NotificationsComponent'));

Vue.use('InfiniteLoading');
import vueRouter from './routes.js';
import {store} from './store.js';


const app = new Vue({
    el: '#app',
    router:vueRouter,
    store
});
