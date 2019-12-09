<template>
  <div  class="container logo">
      <div :style="{height:'100vh'}" class="row d-flex justify-content-center align-items-center">
          <div class="col-md-6 col-xs-11 col-sm-10 col-lg-6">
              <div class="card text-primary border-primary mt-5">
                  <div class="card-body ">
                    <h3 class="card-title"><span class="font-weight-bolder"><i class="fas fa-sign-in-alt"></i></span> Ingresar Control Presupuestal</h3>
                    <hr>
                      <form @submit.prevent="methodLogin">
                          <div class="form-group row">
                              <label for="email" class="col-md-4 col-form-label text-md-right">
                                Email <span class="font-weight-bolder"><i class="fas fa-user-alt"></i> </span>
                              </label>
                              <div class="col-md-6">
                                  <input id="email" v-model="email" type="email" class="form-control " name="email" value="" required autocomplete="email" autofocus>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">
                                Contraseña <span class="font-weight-bolder" ><i class="fas fa-key"></i> </span>
                              </label>

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
            <img src="/images/logo-horizontal.png" class="img-fluid">
      </div>
      <div class="row">

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
    }
  }
}
</script>
<style media="screen">
.bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
</style>
