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
export default new VueRouter({
  routes:[
    {
      path:'/cycles',
      component:Create,
      name:'create',
    },
    {
      path:'/budgets',
      component:Budgets,
      name:'budgets'
    },
    {
      path:'*',
      component:Error404,
    },
    {
      path:'/',
      component:Home,
    },
    {
      path:'/login',
      component:Login,
    },
    {
      path:'/items',
      component:Items,
      name:'items'
    },
    {
      path:'/departments',
      component:Departments,
      name:'departments'
    },
    {
      path:'/departmentItems',
      component:DepartmentItems,
      name:"departmentItems"
    },
    {
      path:'/quotation-department-items',
      component:QuotationDepartmentItems,
      name:"quotationDepartmentItems"
    }
  ],
    mode:'hash'
})

Vue.use(VueRouter);
