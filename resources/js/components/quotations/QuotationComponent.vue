<template>
  <div :class="classes">
    <h5 class="card-header text-monospace font-weight-bolder">Cotización</h5>
    <div class="card-body">
      <div class="row justify-content-end mb-2">
        <div class="col-md-2 col-xs-2 mr-4 text-right">
          <span class="cursor" v-show="editing" @click="update">
            <i class="fas fa-check"></i>
          </span>
          <span class="cursor " v-show="!editing" @click="isEditing">
            <i class="fas fa-highlighter"></i>
          </span>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          {{notification.created_at}}
        </div>
      </div>
      <div class="row d-flex justify-content-center">
        <div class="col-sm-4 col-xs-10">
          <p class="card-text mb-2">Status</p>
        </div>
        <div v-if="editing" class="col-sm-8 col-xs-10">
          <select class="form-control border-0" name="status" v-model="form.status">
            <option v-for="status in statuses" :value="status">{{status}}</option>
          </select>
        </div>
        <div v-else class="col-sm-8 col-xs-10">
          <p @click="isEditing" class="card-text mb-2">{{notification.status}}</p>
        </div>
      </div>
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
        <div v-if="editing" class="col-sm-8 col-xs-10">
          <input type="number" v-model="form.qty" name="qty" class="form-control">
        </div>
        <div  v-else class="col-sm-8 col-xs-10">
          <p class="card-text mb-2">{{notification.qty}}</p>
        </div>
      </div>
      <div class="">

      </div>
      <div class="row d-flex justify-content-center">
        <div class="col-sm-4 col-xs-10">
          <p class="card-text mb-2">IVA</p>
        </div>
        <div v-if="editing" class="col-sm-8 col-xs-8">
          <div class="form-group">
            <div v-for="iva in optionsIVA"class="custom-control custom-radio">
              <input v-model="form.iva" type="radio" name="iva" :value="iva" :id="'iva-'+iva" class="custom-control-input">
              <label class="custom-control-label" :for="'iva-'+iva">
                {{iva === 0 ? 'No incluye' : 'Incluye'}}
              </label>
            </div>
          </div>
        </div>
        <div v-else class="col-sm-8 col-xs-10">
          <p v-if="notification.enum_iva" class="card-text mb-2">Incluido</p>
          <p v-else class="card-text mb-2">No Incluido</p>
        </div>
      </div>
      <div class="row d-flex justify-content-center">
        <div class="col-sm-4 col-xs-10">
          <p class="card-text mb-2">Usuario</p>
        </div>
        <div class="col-sm-8 col-xs-10">
          <p class="card-text mb-2">{{notification.user_name}}</p>
        </div>
      </div>
    </div>
    <div class="card-footer text-muted text-center">
      <template v-for="file in notification.files" class="d-flex">
        <a  class="text-decoration-none text-white"
           :href="'api/quotations/download/'+file.split('/')[1]+'?token='+access_token">
          <span class="download ml-2">
            <i class="fas fa-file-download"></i>
          </span>
        </a>
      </template>
    </div>
  </div>
</template>

<script>
import {mapState} from 'vuex'
export default {
  props:['notification','index'],
  data(){
    return {
      editing:false,
      statuses:[
        'PENDIENTE',
        'ACEPTADO',
        'RECHAZADO'
      ],
      optionsIVA:[0,1],
      form:{
        // iva:this.notification.enum_iva,
        // status:this.notification.status,
        // item_id:this.notification.item_id,
        // qty:this.notification.qty,
      }
    }
  },
  mounted(){
    this.form.iva=this.notification.enum_iva;
    this.form.status=this.notification.status;
    this.form.item_id=this.notification.item_id;
    this.form.qty=this.notification.qty;
  },
  computed:{
    ...mapState(['access_token']),
    classes(){
      console.log('trigger classes')
      return [{'card':true,
              'text-white bg-dark':this.notification.status === 'PENDIENTE',
              'text-white bg-primary' :this.notification.status === 'ACEPTADO',
              'text-white bg-danger' :this.notification.status === 'RECHAZADO'
            }];
    }
  },
  methods:{
    update(){
      axios({
        method:'PUT',
        data:this.form,
        url:'/api/quotations/'+this.notification.id+'/'
      }).then((response) => {
        console.log(response.data)
        if(response.data){
          let data = new Object();
          data.index = this.index;
          data.quotation = response.data.quotation;
          this.$emit('setQuotation',data);
          this.isEditing()
        }
      }).catch((error)=>{
        console.log(error)
      })
    },
    isEditing(){
      this.editing = !this.editing;
    }
  }
}
</script>

<style lang="scss">
</style>
