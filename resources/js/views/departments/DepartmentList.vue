<template>
  <ul class="list-group border-primary shadow-sm mb-3">
    <li class="list-group-item disabled font-weight-bolder" aria-disabled="true">
      Elige un departamento
    </li>
    <li v-for="(department,index) in departments" v-model="department_id" @click="setDepartmentId"
        :data-id="department.id" style="cursor:pointer" class="list-group-item list-group-item-action"
        :data-index="index+2" >
        {{department.name}}
    </li>
  </ul>
</template>
<script>
export default {
  mounted(){
    this.getData('api/departments')
  },
  data(){
    return {
      departments:[],
      selected_element:null,
      department_id:''
    }
  },
  name:'DeparmentList',
  methods:{
    getData(route){
      axios({
        url:route,
        method:'GET'
      }).then((response)=>{
        if(response.data.data.length){
          return this.departments.push(...response.data.data)
        }
      }).catch((error)=>{
        console.log(error)
      })
    },
    /*
    *
    *En este metodo es llamado cuando se da click a un departamento, para activar la clase
    guardar el elemente seleccionado y desactivar la clase active para el anterior elemento
    seleccionado
    *
    */
    setDepartmentId(event){
      if(this.selected_element){
        this.selected_element.classList.remove('active')
      }
      this.department_id=event.target.dataset.id
      event.target.classList.add('active')
      this.$emit('setDepartmentId',this.department_id);
      this.selected_element = event.toElement;
      this.getItemsByDepartment(); // obtiene los departamentos por el item seleccionado
    },
    /*
    *
    *Obtiene los presupuestos por el departamento seleccionado
    *
    */
    getItemsByDepartment(){
      this.$emit('loading')
      axios({
        url:'api/department/items',
        params:{
          id:this.department_id
        },
        method:'GET'
      }).then((response)=>{
          this.$emit('getItemsByDepartment',response.data.data)
      })
    },
  }
}
</script>

<style lang="css" scoped>
</style>
