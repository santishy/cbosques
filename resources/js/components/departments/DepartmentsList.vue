<template>
  <div class="form-group">
    <close @close="doneEdit"/>
    <form>
      <!-- <div class="form-group">
        <div class="custom-control custom-radio" v-for="(department,index) in departments">
          <input type="radio"
                 class="custom-control-input"
                 :id="department.id"
                 :checked='isChecked(department)'
                 :value="department.id">
          <label class="custom-control-label" for="PENDIENTE">PENDIENTE</label>
        </div>
      </div> -->
      <div v-for="(department,index) in departments" class="custom-control custom-radio">
        <input type="radio"
               :id="'customRadio'+department.id"
               v-model="department_id"
               :value="department.id"
               @change="assignDepartment"
               name="department_id"
               :class="['custom-control-input', hasError.departments ? 'is-invalid' : '']">
        <label class="custom-control-label" :for="'customRadio'+department.id">{{department.name}}</label>
      </div>
      <!-- <div v-for="(department,index) in departments" class="custom-control custom-checkbox">
        <input @change="assignDepartment"
               type="checkbox"
               :class="['custom-control-input', hasError.departments ? 'is-invalid' : '']"
               :id="department.id"
               :checked='isChecked(department)'
               :value="department.id">
        <label class="custom-control-label" :for="department.id">
          {{department.name}}
        </label>
      </div> -->
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
      department_id:''
    }
  },
  created(){
    return this.getDepartments();
  },
  methods:{
    doneEdit(){
      console.log('close')
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
