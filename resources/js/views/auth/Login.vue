<template>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Login</div>
                  <div class="card-body">
                      <form @submit.prevent="methodLogin">
                          <!-- @csrf -->

                          <div class="form-group row">
                              <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                              <div class="col-md-6">
                                  <input id="email" v-model="email" type="email" class="form-control " name="email" value="" required autocomplete="email" autofocus>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

                              <div class="col-md-6">
                                  <input id="password" v-model="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                              </div>
                          </div>

                          <div class="form-group row">
                              <div class="col-md-6 offset-md-4">
                                  <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="remember" id="remember" >

                                      <label class="form-check-label" for="remember">
                                          Recordar
                                      </label>
                                  </div>
                              </div>
                          </div>

                          <div class="form-group row mb-0">
                              <div class="col-md-8 offset-md-4">
                                  <button type="submit" class="btn btn-primary">
                                      Ingresar
                                  </button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import {mapActions} from 'vuex';
export default {
  data(){
    return{
      email:"",
      password:"",
    }
  },
  created(){

  },
  methods:{
    ...mapActions(['login']),
    methodLogin(){
      const email = this.email;
      const password = this.password
      this.login({email,password}).then((response) =>{
        
        this.$router.push('/')
      })
       .catch((error) => {
         console.log(error)
       })
      // this.$store.dispatch('login', { email, password })
      //  .then(() => this.$router.push('/'))
      //  .catch((error) => {
      //    console.log(error)
      //  })
      // axios({
      //   method:'POST',
      //   url:'http://budgets.dev:3000/api/auth/login',
      //   data:{
      //     'email':this.email,
      //     'password':this.password
      //   }
      // }).then((response)=>{
      //
      //   localStorage.setItem('access_token',response.data.access_token);
      //   window.axios.defaults.headers.common['Authorization'] = 'Bearer '+localStorage.getItem('access_token');
      // }).catch((error)=>{
      //   console.log(error)
      // })
    }
  }
}
</script>
