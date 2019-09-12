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
              <div class="form-group">
                <label for="created_at">Inicio</label>
                <input type="date" v-model="created_at" name="created_at" class="form-control" value="">
              </div>
              <div class="form-group">
                <label for="finalized_at">Fin</label>
                <input type="date" v-model="finalized_at" name="finalized_at" id="finalized_at" value="" class="form-control">
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
      created_at:'',
      finalized_at:''
    }
  },
created(){
  this.getCycles();
},
  components:{
    'index-cycles':Index
  },
  
  methods:{
    store(){
      axios({
        url:'http://budgets.dev/api/cycles',
        method:'post',
        data:{'created_at':this.created_at,'finalized_at':this.finalized_at}
      }).then((response)=>{
        this.setCycle(response.data)
        this.deactivateCycles();
      }).catch((error)=>{
        console.log(error)
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
