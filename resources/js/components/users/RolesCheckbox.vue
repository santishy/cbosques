<template>
  <div class="form-group">
  <close @close="doneEdit"/>
    <form>
      <div v-for="(role,index) in roles" class="custom-control custom-checkbox">
        <input @change="assignRole"
               :index="index" type="checkbox"
               :class="['custom-control-input', hasError.roles ? 'is-invalid' : '']"
               :id="role.name"
               :checked='isChecked(role)'
               :value="role.id">
        <label class="custom-control-label" :for="role.name">{{role.display_name}}</label>
      </div>
      <small v-if="hasError.roles" class="text-danger">{{hasError.roles[0]}}</small>
    </form>
  </div>
</template>
<script>
import {mapMutations} from 'vuex';
import Close from '../Close';
export default {
  props:['assigned-roles','user','index'],
  components:{
    'close':Close
  },
  data(){
    return {
      roles:[],
      hasError:{
      }
    }
  },
  created(){
    console.log(this.assignedRoles)
    this.getRoles();
  },
  methods:{
    ...mapMutations(['updateUser']),
    getRoles(){
      axios({
        url:'/api/roles/',
        method:'GET',
      }).then((response) => {
        this.roles = response.data;
      }).catch((error) => {
        console.log(error)
      })
    },
    assignRole(event){

        axios({
          method:'PUT',
          url:'/api/users/'+ this.user.id +'/',
          data:{'value':event.target.value,'column':'roles'}
        }).then((response)=>{
          let data = new Object();
          if(response.data.data)
          {
            data.index = this.index;
            data.user = response.data.data;
            this.updateUser(data);
          }
        }).catch((error)=>{
          console.log(error)
        })
    },
    isChecked(role){
      return this.assignedRoles.some(assignRole => {
        if(assignRole.id == role.id)
          return true;
      })
    },
    doneEdit(){
      console.log('close')
      this.$emit('close','editing_roles');
    },
  },
  computed:{

  }
}
</script>

<style lang="css" scoped>
</style>
