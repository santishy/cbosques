<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <quotation-component :notification="quotation"/>
      </div>
      <div class="col-md-6">
        <status-message :quotation="quotation" :notification_id="notification_id"></status-message>
      </div>
    </div>
  </div>
</template>
<script>
import StatusMessage from '../../components/quotations/StatusMessage.vue';
import QuotationComponent from '../../components/quotations/QuotationComponent.vue'
export default {
  props:['notification_id','id'],
  data(){
    return{
      quotation:{}
    }
  },
  created(){
    this.getQuotation(this.id)
    this.markAsRead(this.notification_id)
  },
  components:{
    'status-message':StatusMessage,
    'quotation-component':QuotationComponent
  },

  methods:{
    /*
    * Marca como leida la notificacion al darle click al dropdown
    *
    */
    markAsRead(notification){
      axios({
        url:'/api/notifications/'+this.notification_id,
        method:'PUT',
        data:{id:this.id}
      }).then((response)=>{
        console.log(response);
      }).catch((error)=>{
        console.log(error)
      })
    },
    getQuotation(id){
      axios({
        url:'/api/quotations/'+id,
        method:'get',
      }).then((response)=>{
        this.quotation = response.data.data
      }).catch((error)=>{
        console.log(error)
      })
    }
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
