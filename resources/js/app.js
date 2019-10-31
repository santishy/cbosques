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
//Vue.use(Swal)
const app = new Vue({
    el: '#app',
    router:vueRouter,
    store,
    created(){
      const interceptor = axios.interceptors.response.use(
              response => response,
              error => {
                  // Reject promise if usual error
                  if (error.response.status !== 400) {
                      return Promise.reject(error);
                  }

                  /*
                   * When response code is 401, try to refresh the token.
                   * Eject the interceptor so it doesn't loop in case
                   * token refresh causes the 401 response
                   */
                  axios.interceptors.response.eject(interceptor);

                  return axios.post('/api/auth/refresh', {
                      token:localStorage.getItem('access_token')
                  }).then(response => {
                      console.log('entro aki?')
                      console.log(response) //guardar el token
                      error.response.config.headers['Authorization'] = 'Bearer ' + response.data.access_token;
                      return axios(error.response.config);
                  }).catch(error => {
                      store.dispatch('logout')
                      //vueRouter.push('/login');
                      return Promise.reject(error);
                  })
              });
    }
});
