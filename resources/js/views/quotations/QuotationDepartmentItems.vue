<template>
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <department-list v-on:getItemsByDepartment="ItemsByDepartment" v-on:setDepartmentId="DepartmentId"/>
      </div>
      <div class="col-lg-8">
        <table class="table  table-hover text-center">
          <thead>
            <th>ID</th>
            <th>Concepto</th>
            <th>Presupuesto</th>
          </thead>
          <tbody>
            <tr v-for="item in items">
              <td>{{item.id}}</td>
              <td>{{item.concept}}</td>
              <td>{{item.qty}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import DepartmentList from '../departments/DepartmentList'
export default {
    components:{
      'department-list':DepartmentList
    },
    data(){
      return{
        department_id:'',
        items:[]
      }
    },
    methods:{
      /*
      *
      *es un evento que regresa el componente departmentList que que retorna el id del departamento
      *
      */
      DepartmentId(id){
        this.department_id = id;
      },
      /*
      *
      *Son los items obtenidos por departamento, pero estos son emitidos desde el componente departmentlist
      *
      */
      ItemsByDepartment(data){
        if(data.length)
          return this.items = data;
        return this.items=[]
      },
    }

}
</script>

<style lang="css" scoped>
</style>
