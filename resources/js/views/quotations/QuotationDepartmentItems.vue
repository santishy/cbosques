<template>
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <department-list/>
      </div>
    </div>
  </div>
</template>

<script>
import DepartmentList from '../departments/DeparmentList'
export default {
    components:{
      'department-list':DeparmentList,
    },
    data(){
      return{
        department_id:'',
      }
    },


}
</script>

<style lang="css" scoped>
</style>
