<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 col-xs-12">
        <div class="card">
          <div class="card-body">
              <h5 class="card-title">Cambiar Status</h5>
            <form :id="'status-message-form'" @submit.prevent="update">
              <input type="hidden" name="item_id" :value="quotation.item_id">
              <div class="form-group">
                <div class="custom-control custom-radio">
                  <input type="radio" :checked="quotation.status == status[0]" name="status" id="PENDIENTE" class="custom-control-input" :value="status[0]">
                  <label class="custom-control-label" for="PENDIENTE">PENDIENTE</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" :checked="quotation.status == status[1]" name="status" id="ACEPTADA" class="custom-control-input" :value="status[1]">
                  <label class="custom-control-label" for="ACEPTADA">ACEPTADA</label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" :checked="quotation.status == status[2]" name="status" id="RECHAZADA" class="custom-control-input" :value="status[2]">
                  <label class="custom-control-label" for="RECHAZADA">RECHAZADA</label>
                </div>
              </div>
              <div class="form-group">
                <label for="message">Mensaje</label>
                <textarea name="message" rows="4" class="form-control"></textarea>
              </div>
              <div class="form-group">
                <button class="btn btn-primary" name="button">Actualizar</button>
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
  props:{
    quotation:{
      type: Object
    },
    notification_id:{
      type:String
    }
  },
  data(){
    return {
      status:['PENDIENTE','ACEPTADA','RECHAZADA']
    }
  },
  mounted(){
    console.log(this.notification_id + ' == id')
  },
  methods:{
    update(){
      var fd = new FormData(document.getElementById('status-message-form'));
      fd.append('id',this.quotation.id);
      fd.append('qty',this.quotation.qty);
      fd.append('notification_id',this.notification_id)
      fd.append('_method','PUT')
      console.log(document.getElementById('status-message-form'))
      axios({
        url:'/api/quotations/'+this.quotation.id,
        method:'POST',
        data:fd,
      }).then((response)=>{
        console.log(response)
      }).catch((error)=>{
        console.log(error)
      });
    }
  }
}
</script>

<style lang="css" scoped>
</style>
