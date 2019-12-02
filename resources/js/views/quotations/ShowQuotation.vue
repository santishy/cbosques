<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-8" v-if="quotation">
        <quotation-component @setQuotation="update" :notification="quotation"/>
      </div>
    </div>
  </div>
</template>
<script>
import QuotationComponent from '../../components/quotations/QuotationComponent.vue'
export default {
  props:['notification_id','id'],
  components:{
    'quotation-component':QuotationComponent
  },
  data(){
    return{
      quotation:false
    }
  },
  created(){
    this.getQuotation(this.id)
    this.markAsRead(this.notification_id)

  },
  methods:{
    /*
    * Marca como leida la notificacion al darle click al dropdown
    *
    */
    markAsRead(notification){
      axios({
        url:'/api/notifications/'+this.notification_id+'/',
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
        url:'/api/quotations/'+id+'/',
        method:'get',
      }).then((response)=>{
        this.quotation = response.data.data
      }).catch((error)=>{
        console.log(error)
      })
    },
    update(event){
      this.quotation = event.quotation;
      this.$set(this.quotation,event.quotation)
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
