<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-10 col-xs-12 col-md-10">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">
              Cotizaciones Autorizadas
              <a class="float-right text-decoration-none text-danger" :href="'/api/items/pdf-quotations/'+id+'?token='+access_token">
                <span><i class="fas fa-file-pdf"></i></span>
              </a>
            </h3>
            <hr>
            <h5 v-if="concept" class="card-subtitle mb-2 text-muted"><b>Cuenta: </b>{{concept}}</h5>
            <quote-table :quotations="quotations"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import QuoteTable from '../../components/quotations/QuoteTable';
import {mapState} from 'vuex';
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
  },
  computed:{
    ...mapState(['access_token']),
  }
}
</script>

<style lang="css" scoped>
</style>
