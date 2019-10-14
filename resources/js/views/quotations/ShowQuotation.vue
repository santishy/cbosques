<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Cotización</h5>
            <div class="row d-flex justify-content-center">
              <div class="col-sm-4 col-xs-10">
                <p class="card-text mb-2">Descripción</p>
              </div>
              <div class="col-sm-8 col-xs-10">
                <p class="card-text mb-2">{{notification.description}}</p>
              </div>
            </div>
            <div class="row d-flex justify-content-center">
              <div class="col-sm-4 col-xs-10">
                <p class="card-text mb-2">Costo</p>
              </div>
              <div class="col-sm-8 col-xs-10">
                <p class="card-text mb-2">{{notification.qty}}</p>
              </div>
            </div>
            <div class="row d-flex justify-content-center">
              <div class="col-sm-4 col-xs-10">
                <p class="card-text mb-2">IVA</p>
              </div>
              <div class="col-sm-8 col-xs-10">
                <p v-if="notification.iva" class="card-text mb-2">Incluido</p>
                <p v-else class="card-text mb-2">No Incluido</p>
              </div>
            </div>
            <div class="row d-flex justify-content-center">
              <div class="col-sm-4 col-xs-10">
                <p class="card-text mb-2">Archivo</p>
              </div>
              <div class="col-sm-8 col-xs-10">
                <a :href="'api/quotations/download/'+notification.archive+'?token='+access_token">
                  <span class="fas-download">
                    <i class="fas fa-file-download"></i>
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapState} from 'vuex'
export default {
  props:['notification','id'],
  mounted(){
    
  },
  computed:{
    ...mapState(['access_token'])
  },
  methods:{

  }
}
</script>

<style lang="scss" scoped>
.fas-download{
  cursor:pointer;
  color:Dodgerblue;
  font-size:1.5rem;
}
</style>
