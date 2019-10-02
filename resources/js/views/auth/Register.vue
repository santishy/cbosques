<template>
  <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card">
                  <div class="card-header">Registrar usuario</div>
                  <div class="card-body">
                      <form @submit.prevent="userRegister">
                          <div class="form-group row">
                              <label for="name" class="col-md-4 col-form-label text-md-right">Nombre</label>
                              <div class="col-md-6">
                                  <input id="name" type="text" class="form-control" name="name" v-model="form.name"  required autocomplete="name" autofocus>

                                  <!-- @error('name')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror -->
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>


                              <div class="col-md-6">
                                  <input v-model="form.email" id="email" type="email" class="form-control" name="email" required autocomplete="email">

                                  <!-- @error('email')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror -->
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                              <div class="col-md-6">
                                  <input id="password" v-model="form.password" type="password" class="form-control " name="password" required autocomplete="new-password">

                                  <!-- @error('password')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror -->
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar Password</label>

                              <div class="col-md-6">
                                  <input id="password-confirm" v-model="form.password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
      </div>
  </div>
</template>

<script>
import {mapActions} from 'vuex';
import {mapMutatios} from 'vuex';
export default {
  data(){
    return {
      form:{}
    }
  },
  created(){
    console.log('registro')
  },
  methods:{
    ...mapActions(['register']),
    userRegister(){
      this.register(this.form).then((response)=>{
        console.log(response)
      }).catch((error)=>{
        console.log(error)
      })
    }
  }
}
</script>

<style lang="css" scoped>
</style>
