<template>
<div class="container">
  <div class="">
    <div :style="{'display':'inline-block'}" v-for="(quotation,index) in quotations" :key="index" class="col-lg-4 col-md-4 col-sm-6 col-xs-10  mb-2" >
      <quotation-component @setQuotation="update" :index="index" :notification="quotation"/>
    </div>
    <infinite-loading @infinite="infiniteHandler"></infinite-loading>
  </div>
</div>
</template>
<script>
import QuotationComponent from '../components/quotations/QuotationComponent'
export default {
  data(){
    return{
      quotations:[],
      page:1,
    }
  },
  components:{
    'quotation-component':QuotationComponent,
  },
  methods:{
    infiniteHandler($state){
      axios({
        url:'/api/users/quotations/',
        method:'GET',
        params:{
          page:this.page
        }
      }).then((response)=>{
        if(response.data.data.length)
        {
          this.page++;
          this.quotations.push(...response.data.data)
          $state.loaded();
        }
        else{
          $state.complete()
        }
      }).catch((error)=>{
        console.log(error)
      })
    },
    update(event){
      Vue.set(this.quotations,event.index,event.quotation)
    }
  }
}
</script>

<style lang="css" scoped>
</style>
