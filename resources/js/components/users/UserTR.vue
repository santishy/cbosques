<template>
  <tr>
    <td >
      {{user.id}}
    </td>
    <td v-if="editing_name" >
      <div>
        <input-user name='name' @click="" @close="doneEdit" :value="user.name" :index="index" :user="user"/>
      </div>
    </td>
    <td v-else class="cursor center" @click="editingName">
      {{user.name}}
    </td>
    <td v-if="editing_email" >
      <input-user name="email" type="email" @close="doneEdit" :user="user" :index="index" :value="user.email"/>
    </td>
    <td v-else class="cursor center" @click="editingEmail">
      {{user.email}}
    </td>
    <td v-if="editing_password">
      <input-user type="password" name="password" @close="doneEdit" :user="user" :index="index" :value="user.password"/>
    </td>
    <td v-else class="cursor center" @click="editingPassword">
      *********
    </td>
    <td v-if="editing_roles">
      <roles-checkbox :assigned-roles="user.roles"
                      :user="user"
                      :index="index"
                      @close="doneEdit"/>
    </td>
    <td v-else class="cursor center" @click="editingRoles">
      {{user.abilitys}}
    </td>
    <td v-if="editing_departments">
      <departments-list
        action="update"
        :user="user"
        @close="doneEdit"
        :index="index"
        :hasError="hasError"
        :key="user.id"
        :assigned-departments="user.departments" />
    </td>
    <td v-else  @click="editingDepartments">
      {{user.assignedDepartments}}
    </td>

    <td>
      <div @click="destroy" >
        <i class="fas fa-trash"></i>
      </div>
    </td>
  </tr>
</template>

<script>
import DepartmentsList from '../departments/DepartmentsList';
import Input from './Input';
import RolesCheckbox from './RolesCheckbox';

import {mapMutations} from 'vuex';
export default {
  props:['user','index'],
  data(){
    return{
      editing_name:false,
      editing_email:false,
      editing_roles:false,
      editing_password:false,
      editing_departments:false,
      hasError:{},
      error:false
    }
  },
  methods:{
    ...mapMutations(['destroyUser']),
    isEditing(){
      this.editing = true;
    },
    editingName(){
      this.editing_name=!this.editing_name;
    },
    editingEmail(){
      this.editing_email = !this.editing_email;
    },
    editingRoles(){
      this.editing_roles = !this.editing_roles
    },
    editingPassword(){
      this.editing_password = !this.editing_password
    },
    editingDepartments(){
      this.editing_departments = !this.editing_departments
    },
    doneEdit(event){
      console.log('done edit')
      this[event] = false;
    },
    editRoles(event){
      this.users.some((user,index)=>{
        if(user.id === event.pivot.user_id)
          console.log(this.users[index])
      })
    },
    destroy(){
      Swal.fire({
          title: '¿Estas seguro?',
          text: "Se eliminará permanentemente de la base datos",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, Eliminar!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.value) {
            axios({
              url:'/api/users/'+this.user.id+'/',
              method:'DELETE'
            }).then((response)=>{
              Swal.fire(
                'Eliminado!',
                'Se a borrado de la base de datos.',
                'success'
              )
              this.destroyUser(this.index);
            }).catch((error)=>{
              console.log(error)
            })
          }
        })

    }
  },
  components:{
    'input-user':Input,
    'roles-checkbox':RolesCheckbox,
    'departments-list':DepartmentsList
  }
}
</script>
<style lang="scss">
.cursor{
  cursor:pointer
}

</style>
