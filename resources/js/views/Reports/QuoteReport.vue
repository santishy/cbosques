<template>
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="card border-primary mb-3 shadow-sm">
          <div class="card-body">
            <form @submit.prevent="getReport">
              <div class="form-group">
                <label for="initial-date">Fecha Inicial</label>
                <input type="date" class="form-control" id="initial_date" name="initial_date" v-model="form.initialDate">
              </div>
              <div class="form-group">
                <label for="initial-date">Fecha Final</label>
                <input type="date" class="form-control" name="final_date" id="final_date" v-model="form.finalDate">
              </div>
              <div class="form-group">
                <button name="button" class="btn-info btn-block btn">Realizar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="card mt-2 border-primary mb-3 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Por Mes:</h5>
            <form>
              <div class="form-group">
                <div class="custom-control custom-radio" v-for="(month,index) in months">
                  <input @change="getReportByMonth" type="radio"  name="month"
                         :id="month+''+index"
                         class="custom-control-input" :value="(index+1)">
                  <label class="custom-control-label" :for="month+''+index">{{month}}</label>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="card border-primary mb-3 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">
              {{title}}
              <a class="float-right text-decoration-none text-danger"
                 :href="url_report">
                <span><i class="fas fa-file-pdf"></i></span>
              </a>
            </h5>
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
  components:{
  'quote-table':QuoteTable
  },
  data(){
    return{
      quotations:[],
      form:{},
      url_report:'',
      title:'MES ACTUAL',
      months:['ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE']
    }
  },
  created(){
    this.getQuotesMonthCurrent();
  },
  computed:{
    ...mapState(['access_token']),
  },
  methods:{
    getQuotesMonthCurrent(){
      this.url_report='/api/reports/pdf-quotes-of-the-month/?token='+this.access_token
      axios({
        url:'/api/reports/quotations/',
        method:'GET',
      }).then((response)=>{
        if(response.data.data){
          this.quotations=response.data.data;
        }
      }).catch((error)=>{
        console.log(error)
      });
    },
    getReport(){
      this.url_report='/api/reports/quotations/pdf-by-dates/?initialDate='+this.form.initialDate+'&finalDate='+this.form.finalDate+'&token='+this.access_token
      axios({
        url:'/api/reports/quotations/by-dates/',
        params:this.form,
        method:'GET',
      }).then((response)=>{
        if(response.data.data){
          this.quotations = response.data.data;
          this.title="DE "+this.form.initialDate+' A '+this.form.finalDate;
        }
      }).catch((error)=>{
        console.log(error)
      })
    },
    getReportByMonth(event){
      this.url_report = '/api/reports/pdf-quotes-of-the-month?month='+event.target.value+'&token='+this.access_token
      axios({
        url:'/api/reports/quotations/',
        method:'GET',
        params:{
          'month':event.target.value
        }
      }).then((response)=>{
        if(response.data.data){
          this.quotations = response.data.data;
          this.title = 'MES DE '+this.months[event.target.value-1]
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
