<template>
  <div class="form-group">
    <close v-if="action=='update'"@close="doneEdit"/>
    <form>
      <div v-for="(department,index) in departments" class="custom-control custom-radio">
        <input type="radio"
               :id="'customRadio'+department.id"
               :value="department.id"
               :checked='isChecked(department)'
               @change="assignDepartment"
               name="department_id"
               :class="['custom-control-input', hasError.departments ? 'is-invalid' : '']">
        <label class="custom-control-label" :for="'customRadio'+department.id">{{department.name}}</label>
      </div>
      <small v-if="hasError.departments" class="text-danger">{{hasError.departments[0]}}</small>
    </form>
  </div>
</template>

<script>
import {mapActions,mapMutations} from 'vuex';
import {mapState} from 'vuex';
import Close from '../Close';
export default {
  props:['hasError','action','assigned-departments','user','index'],
  components:{
    'close':Close,
  },
  data(){
    return {
      department_id:true
    }
  },
  created(){
    return this.getDepartments();
  },
  methods:{
    doneEdit(){
      this.$emit('close','editing_departments');
    },
    ...mapActions(['getDepartments']),
    ...mapMutations(['updateUser']),
    assignDepartment(event){
      if(event.target.checked)// AQUIIIII NO ES IGUAL QUE EL OTRO METODO NO ENTRA CUANDO NO ESTA CHEKEADO Y CAMBIA
        if(this.action !== 'update'){
          this.department_id=event.target.value
          return this.$emit('assignedDepartment',this.department_id)
        }
      return this.update(event)
    },
    update(event){
      axios({
        method:'PUT',
        url:'/api/users/'+this.user.id+'/',
        data:{column:'department_id',value:event.target.value}
      }).then((response)=>{
        if(response.data.data){
          let data = new Object();
          data.index = this.index;
          data.user = response.data.data;
          this.updateUser(data);
        }
      }).catch((error)=>{
        console.log(error)
      })
    },
    isChecked(department){
      if(this.action!='update')
        return;
      return this.assignedDepartments.some(assignDepartment => {
        console.log(assignDepartment.id +' '+department.id)
        if(assignDepartment.id == department.id)
          return true;
      })
    },
  },
  computed:{
    ...mapState(['departments'])
  },

}
</script>

<style lang="css" scoped>
</style>
