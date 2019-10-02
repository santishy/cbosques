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
      path:'*',
      component:Error404,
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
    }
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
