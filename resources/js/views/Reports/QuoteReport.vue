<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-10 col-xs-12 col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Cotizaciones Autorizadas</h5>
            <h6 v-if="concept" class="card-subtitle mb-2 text-muted"><b>Cuenta: </b>{{concept}}</h6>
            <quote-table :quotations="quotations"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import QuoteTable from '../../components/quotations/QuoteTable';
export default {
  props:['option','id','concept'],
  components:{
    'quote-table':QuoteTable,
  },
  data(){
    return{
        quotations:[]
    }
  },
  created(){
    console.log(this.option + ' ' + this.id)
    if(this.option == 'item-quotes')
    {
      return this.getQuotes('/api/items/quotations/'+this.id+'/');
    }
    return this.getQuotes('/api/budgets/quotations/'+this.id+'/');
  },
  methods:{
    getQuotes(route){
      axios({
        url:route,
        method:'GET',
      }).then((response)=>{
        console.log(response)
        if(response.data.data.length){
          this.quotations=response.data.data;
        }
      }).catch((error)=>{
        console.log(error)
      })
    }
  }

}
</script>

<style lang="css" scoped>
</style>
