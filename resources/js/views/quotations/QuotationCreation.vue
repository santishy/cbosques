<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card border-dark mb-3" >
          <div class="card-header">Crear Cotización</div>
          <div class="card-body text-dark">
            <h5 class="card-title">Ingresa los datos</h5>
            <form @submit.prevent="store">
              <div class="form-group">
                <label for="description">Descripción</label>
                <input type="text" v-model="form.description" name="description" class="form-control">
              </div>
              <div class="form-group">
                <label for="qty">Costo</label>
                <input type="number" v-model="form.qty" name="qty" id="qty" value="" class="form-control">
              </div>
              <div class="form-group">
                <label for="iva">Incluye IVA</label>
                <select class="form-control" name="iva">
                  <option value="1">No</option>
                  <option value="2">Si</option>
                </select>
              </div>
              <div class="form-group">
                <label for="">Subir cotización</label>
                <input type="file" name="" value="">
              </div>
              <div class="form-group">
                <button class="btn btn-primary btn-block" name="button">Crear</button>
              </div>
            </form>
          </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
export default {
  data(){
    return{
      form:{}
    }
  },
  methods:{
    store(){
      axios({
        method:'POST',
        url:'/quotations',
        data:form,
      }).then((response))
    }
  }
}

</script>

<style lang="css" scoped>
</style>
