<template>
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-md-10 col-sm-12">
        <div class="card border-primary shadow-sm mb-3">
          <table class="table table-striped table-responsive-sm table-responsive-xl">
            <thead>
              <th>ID</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Password</th>
              <th>Habilidad</th>
              <th>Departamentos</th>
              <th>Acciones</th>
            </thead>
            <tbody>
              <user-tr v-for="(user,index) in users"
                       :key="user.id"
                       :index="index"
                       :error="error"
                       :user="user"/>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import UserTR from '../../components/users/UserTR';
import {mapActions} from 'vuex';
import {mapState} from 'vuex'
export default {
  created(){
    this.getUsers();
  },
  components:{
    'user-tr' : UserTR,
  },
  data(){
    return{
      error:false,
    }
  },
  methods:{
    ...mapActions(['getUsers']),
  },
  computed:{
    ...mapState(['users']),
  }
}
</script>

<style lang="css" scoped>
</style>
