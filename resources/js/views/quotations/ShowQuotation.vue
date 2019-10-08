<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Cotización</h5>
            <div class="row d-flex justify-content-center">
              <div class="col-sm-4 col-xs-10">
                <p class="card-text">Descripción</p>
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
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props:['notification'],
  mounted(){
    console.log(this.notification)
  }
}
</script>

<style lang="css" scoped>
</style>
