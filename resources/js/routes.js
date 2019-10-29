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
import QuotationCreation from './views/quotations/QuotationCreation';
import QuotationIndex from './views/quotations/QuotationIndex.vue';
import ShowQuotation from './views/quotations/ShowQuotation';
import AllNotifications from './views/notifications/AllNotifications'
import {store} from './store';
let vueRouter = new VueRouter({
  routes:[
    {
      path:'/cycles',
      component:Create,
      name:'create',
      meta:{
          requiresAuth:true
        }
    },
    {
      path:'/budgets',
      component:Budgets,
      name:'budgets',
      meta:{
          requiresAuth:true
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
          requiresAuth:true
        }
    },
    {
      path:'/departments',
      component:Departments,
      name:'departments',
      meta:{
          requiresAuth:true
        }
    },
    {
      path:'/departmentItems',
      component:DepartmentItems,
      name:"departmentItems",
      meta:{
          requiresAuth:true
        }
    },
    {
      path:'/quotation-department-items',
      component:QuotationDepartmentItems,
      name:"quotationDepartmentItems",
      meta:{
          requiresAuth:true
        }
    },
    {
      path:'/register',
      component:Register,
      name:"register",
      meta:{
        requiresAuth:true
      }
    },
    {
      path:'/quotation/create/:id',
      component:QuotationCreation,
      name:'quotation-creation'
    },
    {
      path:'/quotations/show/:id,notification', // el parametro num, solo es para que cambie la url
      component:ShowQuotation,
      name:'quotations-show',
      requiresAuth:true,
      props:true
    },
    {
      path:'/notifications/index',
      component:AllNotifications,
      name:'all-notifications'
    },
    {
      path:'/quotation-index',
      component:QuotationIndex,
      name:'quotation-index'
    },
    {
      path:'*',
      component:Error404,
    },

  ],
    mode:'hash'
})
vueRouter.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters.isLoggedIn) {
      next()
      return
    }
    next('/login')
  } else {
    next()
  }
})
Vue.use(VueRouter);
export default vueRouter;
