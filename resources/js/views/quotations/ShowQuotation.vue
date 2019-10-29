<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <quotation-component :notification="notification"/>
      </div>
      <div class="col-md-6">
        <status-message :quotation="notification" :notification_id="id"></status-message>
      </div>
    </div>
  </div>
</template>
<script>
import StatusMessage from '../../components/quotations/StatusMessage.vue';
import QuotationComponent from '../../components/quotations/QuotationComponent.vue'
export default {
  props:['notification','id'],
  created(){

    //console.log(this.notification)
    this.markAsRead(this.notification)
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
        url:'api/notifications/'+this.id,
        method:'PUT',
        data:{id:this.id}
      }).then((response)=>{
        console.log(response);
      }).catch((error)=>{
        console.log(error)
      })
    },
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
