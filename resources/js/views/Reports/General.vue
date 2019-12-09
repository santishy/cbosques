<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-11">
        <div class="card">
          <div class="card-body">
            <h3>
              Reporte General
              <a class="float-right text-decoration-none text-danger" :href="'/api/reports/general-pdf?token='+access_token">
                <span><i class="fas fa-file-pdf"></i></span>
              </a>
            </h3>
            <table class="table text-center ">
              <thead>
                <th>ID</th>
                <th>Concepto</th>
                <th>Monto Inicial</th>
                <th>Monto Actual</th>
                <th>Monto Cotizaciones</th>
                <th>Nom. Cotizaciones A.</th>
                <th>Ir Cotizaciones</th>
              </thead>
              <tbody>
                <template v-for="budget in budgets">
                  <tr class="bg-primary font-weight-bolder font-italic text-white">
                    <td>{{budget.id}}</td>
                    <td>{{budget.specification.concept}}</td>
                    <td>
                      {{budget.total+budget.specification.qty+totalItems[budget.specification.concept]}}
                    </td>
                    <td>{{budget.specification.qty}}</td>
                    <td>{{budget.total}}</td>
                    <td>
                      {{budget.quotations_count}}
                    </td>
                    <td>
                      <router-link class="text-white" :to="{
                          name:'quote-budget-report',
                          params:{
                            option:'budget-quotes',
                            id:budget.id,
                            concept:budget.specification.concept
                          }
                        }">
                        <i class="fas fa-link"></i>
                      </router-link>
                    </td>
                  </tr>
                  <tr v-for="item in budget.items">
                    <td>{{item.id}}</td>
                    <td>{{item.specification.concept}}</td>
                    <td>
                      {{item.total+item.specification.qty}}
                    </td>
                    <td>{{item.specification.qty}}</td>
                    <td>{{item.total}}</td>
                    <td>
                      {{item.quotations_count}}
                    </td>
                    <td>
                      <router-link :to="{
                          name:'quote-budget-report',
                          params:{
                            option:'item-quotes',
                            id:item.id,
                            concept:item.specification.concept
                          }}">
                        <i class="fas fa-link"></i>
                      </router-link>
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapState} from 'vuex';
export default {
  data(){
    return {
      budgets:[],
      initialBudgetAmount:0,
      totalItems:{},
    }
  },
  created(){
    axios({
      url:'/api/reports/general/',
      method:'GET',
    }).then((response)=>{
      console.log(response)
      if(response.data.length){
        this.budgets=response.data
        this.setTotalItems();
      }
    }).catch((error)=>{
      console.log(error)
    })
  },
  methods:{
    setTotalItems(){
      this.budgets.map((budget)=>{
        this.totalItems[budget.specification.concept]=0;
        budget.items.map((item)=>{
          this.totalItems[budget.specification.concept]+=item.specification.qty;
        })
      });
    }
  },
  computed:{
    ...mapState(['access_token']),
  }
}
</script>

<style lang="css" scoped>
</style>
