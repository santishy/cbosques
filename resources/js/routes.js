import Vue from 'vue';
import VueRouter from 'vue-router';
import Create from './views/cycles/Create';
import  Error404 from  './views/Error404';
import Login from './views/auth/Login';
import Home from './views/Home';
import Budgets from './views/budgets/Budgets';
import Items from './views/budgets/Items';
import Departments from './views/departments/Departments'
import DepartmentItems  from './views/departments/DepartmentItems'
import QuotationDepartmentItems from './views/quotations/QuotationDepartmentItems'
import Register from './views/auth/Register';
import UserIndex from './views/auth/UserIndex';
import QuotationCreation from './views/quotations/QuotationCreation';
import QuotationIndex from './views/quotations/QuotationIndex.vue';
import ShowQuotation from './views/quotations/ShowQuotation';
import AllNotifications from './views/notifications/AllNotifications'
import AuthorizationDenied from './views/auth/AuthorizationDenied';
import General from './views/Reports/General';
import {store} from './store';
let vueRouter = new VueRouter({
  routes:[
    {
      path:'/cycles',
      component:Create,
      name:'create',
      meta:{
          requiresAuth:true,
          permissions:['admin']
        }
    },
    {
      path:'/budgets',
      component:Budgets,
      name:'budgets',
      meta:{
          requiresAuth:true,
          permissions:['admin']
        }
    },

    {
      path:'/',
      component:Home,
      meta:{
          requiresAuth:true
        }
    },
    {
      path:'/login',
      component:Login,
      meta:{
          requiresAuth:false
        }
    },
    {
      path:'/items/:budget',
      component:Items,
      name:'items',
      meta:{
          requiresAuth:true,
          permissions:['admin']
        }
    },
    {
      path:'/departments',
      component:Departments,
      name:'departments',
      meta:{
          requiresAuth:true,
          permissions:['admin'],
        }
    },
    {
      path:'/departmentItems',
      component:DepartmentItems,
      name:"departmentItems",
      meta:{
          requiresAuth:true,
          permissions:['admin'],
        }
    },
    {
      path:'/quotation-department-items',
      component:QuotationDepartmentItems,
      name:"quotationDepartmentItems",
      meta:{
          requiresAuth:true,
          permissions:['admin','cotizador','autorizador'],
        }
    },
    {
      path:'/register',
      component:Register,
      name:"register",
      meta:{
        requiresAuth:true,
        permissions:['admin'],
      }
    },
    {
      path:'/users',
      component:UserIndex,
      name:'users-index',
      meta:{
        requiresAuth:true,
        permissions:['admin']
      }
    },
    {
      path:'/quotation/create/:id',
      component:QuotationCreation,
      name:'quotation-creation',
      meta:{
        requiresAuth:true,
        permissions:['admin','cotizador','autorizador'],
      }
    },
    {
      path:'/quotations/show/:id,:notification_id', // el parametro num, solo es para que cambie la url
      component:ShowQuotation,
      name:'quotations-show',
      meta:{
        requiresAuth:true,
        permissions:['admin','autorizador'],
      },
      props:true
    },
    {
      path:'/notifications/index',
      component:AllNotifications,
      name:'all-notifications',
      meta:{
        requiresAuth:true,
        permissions:['admin','autorizador'],
      }
    },
    {
      path:'/quotation-index',
      component:QuotationIndex,
      name:'quotation-index',
      meta:{
        requiresAuth:true,
        permissions:['admin','autorizador'],
      }
    },
    {
      path:'/reports-general',
      component:General,
      name:'report-general',
      meta:{
        requiresAuth:true,
        permissions:['admin']
      }
    },
    {
      path:'/authorization-denied',
      component:AuthorizationDenied,
      name:'authorization-denied'
    },
    {
      path:'*',
      component:Error404,
    },

  ],
    mode:'hash'
})

// function que se encarga de revisar los permisos que tiene el usuario actual
function hasRoles(permissions){
  if(typeof permissions != 'undefined'){
    let roles = store.getters.getRoles;
    return roles.some((role)=>{
      if(permissions.includes(role))
        return true;
    })
    return false
  }
}
vueRouter.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)) {
    if(store.getters.isLoggedIn) {
      store.dispatch('getUnreadNotifications')
      if(to.matched.some(record => record.meta.permissions))
      {
        if(hasRoles(to.matched[0].meta.permissions)){
          return next()
        }
        else {
          return next({name:'authorization-denied'})
        }
      }
      return next()
    }
    return next('/login')
  } else {
    return next()
  }
})
Vue.use(VueRouter);
export default vueRouter;
