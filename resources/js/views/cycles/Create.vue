<template>
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-lg-3 col-sm-4 col-xs-8">
        <div class="card border-dark mb-3" >
          <div class="card-header">Crea el nuevo ciclo escolar</div>
          <div class="card-body text-dark">
            <h5 class="card-title">Ingresa los datos
            {{numero}}</h5>
            <form @submit.prevent="store">
              <div class="form-group ">
                <label for="initialized_at">Inicio</label>
                <input type="date" v-model="initialized_at" name="initialized_at" :class="['form-control', hasError.initialized_at ? 'is-invalid' : '' ]">
                <small v-if="hasError.initialized_at" class="text-danger text-center">{{hasError.initialized_at[0]}}</small>
              </div>
              <div class="form-group">
                <label for="finalized_at">Fin</label>
                <input type="date" v-model="finalized_at" name="finalized_at" id="finalized_at" :class="['form-control', hasError.finalized_at ? 'is-invalid' : '']">
                <p>
                  <small v-if="hasError.finalized_at" style="padding:0px" class="text-danger text-center">{{hasError.finalized_at[0]}}</small>
                </p>
              </div>
              <div class="form-group">
                <button class="btn btn-primary btn-block" name="button">Crear</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-9 col-lg-9 col-sm-8 col-xs-12">
        <index-cycles/>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import {mapMutations} from 'vuex'
import {mapActions} from 'vuex'
import Index from './Index';


export default {
  name:'create',
  data(){
    return{
      initialized_at:'',
      finalized_at:'',
      hasError:{}
    }
  },

  components:{
    'index-cycles':Index
  },

  methods:{
    store(){
      this.hasError={}
      axios({
        url:'/api/cycles',
        method:'post',
        data:{'initialized_at':this.initialized_at,'finalized_at':this.finalized_at}
      }).then((response)=>{
        this.setCycle(response.data)
        this.deactivateCycles();
      }).catch((error)=>{
          if(error.response.data.errors)
            {
              this.hasError = error.response.data.errors;
            }
      })
    },
    ...mapMutations(['setCycle','deactivateCycles']),
    ...mapActions(['getCycles'])
  },
  computed:{
    ...mapState(['numero']),

  }
}
</script>
