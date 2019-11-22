<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-xs-10">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Registrar usuario</div>
              <form id="formData" @submit.prevent="userRegister">
                <div class="form-group row">
                  <label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>
                  <div class="col-md-6">
                    <input id="name"
                           type="text"
                           :class="['form-control', hasError.name ? 'is-invalid' : '']"
                           name="name"
                           v-model="form.name"
                           autocomplete="name"
                           autofocus>
                    <small v-if="hasError.name" class="text-danger">{{hasError.name[0]}}</small>
                  </div>
                 </div>
                 <div class="form-group row">
                  <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                   <div class="col-md-6">
                    <input v-model="form.email"
                           id="email" type="email"
                           :class="['form-control',hasError.email ? 'is-invalid' : '']"
                           name="email">
                    <small class="text-danger" v-if="hasError.email">{{hasError.email[0]}}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                    <div class="col-md-6">
                      <input id="password"
                             v-model="form.password"
                             type="password"
                             :class="['form-control', hasError.password ? 'is-invalid' : ''] "
                             name="password"
                             autocomplete="new-password">
                      <small v-if="hasError.password" class="text-danger">{{hasError.password[0]}}</small>
                    </div>
                </div>
                <div class="form-group row">
                  <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar Password</label>
                  <div class="col-md-6">
                    <input id="password-confirm"
                      v-model="form.password_confirmation"
                      type="password"
                      :class="['form-control',hasError.password_confirmation ? 'is-invalid' : '']"
                      name="password_confirmation"
                      autocomplete="new-password">
                    <small v-if="hasError.password_confirmation" class="text-danger">{{hasError.password_confirmation[0]}}</small>
                </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Registrar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-xs-10">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Asignar roles</div>
              <form>
                <div v-for="(role,index) in roles" class="custom-control custom-checkbox">
                  <input @change="assignRole"
                         :index="index" type="checkbox"
                         :class="['custom-control-input', hasError.roles ? 'is-invalid' : '']"
                         :id="role.name"
                         :value="role.id">
                  <label class="custom-control-label" :for="role.name">{{role.display_name}}</label>
                </div>
                <small v-if="hasError.roles" class="text-danger">{{hasError.roles[0]}}</small>
               </form>
            </div>
          </div>
          <div class="card mt-2">
            <div class="card-body">
              <div class="card-title">
                Asignar Departamentos
              </div>
              <departments-list :hasError="hasError" @assignedDepartments="setAssignedDepartments"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions} from 'vuex';
import {mapMutatios} from 'vuex';
import DepartmentsList from '../../components/departments/DepartmentsList'
export default {
  data(){
    return {
      form:{},
      roles:[],
      assignedRoles:[],
      assignedDepartments:[],
      hasError:{}
    }
  },
  components:{
    'departments-list' :DepartmentsList,
  },
  created(){
    this.getRoles().then((response)=>{
      this.roles = response;
    }).catch((error)=>{
      console.log(error)
    })
  },
  methods:{
    ...mapActions(['register','getRoles']),
    setFormData(){
      var formData = new FormData(document.getElementById('formData'));
      formData.append('roles',JSON.stringify(this.assignedRoles))
      formData.append('departments',JSON.stringify(this.assignedDepartments))
      return formData;
    },
    clearValuesForFormData(){
      this.form={};
      this.assignedRoles=[];
      this.assignedDepartments=[];
    },
    userRegister(){
      this.hasError={}
      this.register(this.setFormData())
          .then((response)=>{
            if(response.data){
              Swal.fire({
                type: 'success',
                title: 'Usuario agregado correctamente',
                text: 'Se enviaran sus credenciales al correo registrado.',
              })
              this.clearValuesFormData();
            }
      }).catch((error)=>{
        if(error.response.data.errors){
          this.hasError = error.response.data.errors;
        }
      });
    },
    assignRole(event){
      if(event.target.checked){
          this.assignedRoles.push(event.target.value)
      }
      else
        {
          let index = this.assignedRoles.indexOf(event.target.value)
          if(index != -1)
            this.assignedRoles.splice(index,1);
          console.log(this.assignedRoles)
        }
      //this.assignedRoles.push
    },
    setAssignedDepartments(event){
      this.assignedDepartments = event;
    },
  }
}
</script>

<style lang="css" scoped>
</style>
