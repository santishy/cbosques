<template>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-4 col-xs-12 col-lg-4">
        <div class="card border-primary mb-3 shadow-sm">
          <div class="card-body text-dark">
            <h3>Crear Departamento</h3>
            <hr>
            <form @submit.prevent="store">
              <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" v-model="name" name="name" :class="['form-control',hasError.name ? 'is-invalid' : '']">
                <small v-if="hasError.name" class="text-danger">{{hasError.name[0]}}</small>
              </div>
              <div class="form-group">
                <button class="btn btn-primary btn-block">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-8 col-sm-8 col-xs-12 col-lg-8">
        <div class="card border-primary mb-3 bg-light shadow-sm">
          <div class="card-body text-dark">
            <h3>Departamentos</h3>
            <hr>
            <table class="table text-center table-striped">
              <thead>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
              </thead>
              <tbody>
                <tr v-for="(department,ind) in array">
                  <td>{{department.id}}</td>
                  <td>
                    <div v-if="department.editing">
                      <input :class="['form-control',hasErrorEditing.name ? 'is-invalid' : '']"  type="text" name="" v-model="form.name">
                      <small v-if="hasErrorEditing.name && department.editing" class="text-danger">{{hasErrorEditing.name[0]}}</small>
                    </div>
                    <div v-else>
                      {{department.name}}
                    </div>
                  </td>
                  <td class="d-flex justify-content-center">
                      <div class="mr-2" v-show="!department.editing"  @click="isEditing(parseInt(ind,10))">
                         <i class="fas fa-highlighter" ></i>
                      </div>
                      <div class="mr-2" v-show="department.editing" @click="updateDatabaseRecord(ind)">
                          <i class="fas fa-check"></i>
                      </div>
                      <div @click="destroy(ind)" >
                        <i class="fas fa-trash"></i>
                      </div>
                  </td>
                </tr>
                <!-- <infinite-loading @infinite="infiniteHandler"></infinite-loading> -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import actionsMixin from '../../mixins/actionsMixin';
export default {
  name:'departments',
  data(){
    return{
      array:[],
      url:'api/departments',
      page:1,
      name:'',
      hasError:{}
    }
  },
  mixins:[actionsMixin],
  created(){
    axios({
      method:'GET',
      url:this.url,
    }).then((response)=>{
      if(response.data.data.length)
      {
        this.array.push(...response.data.data)
        this.addingPropertyToObjects(this.array)
      }
    }).catch((error)=>{
      console.log(error)
    })
  },
  methods:{
    infiniteHandler($state){

    },
    /*
    *
    *Almacena en la base de datos
    */
    store(){
      this.hasError={};
      axios({
        url:this.url,
        method:'POST',
        data:{name:this.name}
      }).then((response)=>{
        if(response.status == 200){
          Vue.set(response.data,'editing',false)
          this.array.unshift(response.data)
          this.name='';
        }
      }).catch((error)=>{
        if(error.response.data.errors)
          this.hasError=error.response.data.errors
        console.log(error)
      })
    }
  }
}
</script>
