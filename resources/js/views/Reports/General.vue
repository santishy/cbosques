<template>
  <div class="container">
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <h3>Reporte General</h3>
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
                    {{budget.total+budget.specification.qty+totalItems}}
                  </td>
                  <td>{{budget.specification.qty}}</td>
                  <td>{{budget.total}}</td>
                  <td>
                    {{budget.quotations_count}}
                  </td>
                  <td>
                    <router-link class="text-white" :to="{
                        name:'quote-report',
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
                        name:'quote-report',
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
</template>

<script>
export default {
  data(){
    return {
      budgets:[],
      initialBudgetAmount:0,
      totalItems:0,
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
        budget.items.map((item)=>{
          this.totalItems+=item.specification.qty;
        })
      });
    }
  }
}
</script>

<style lang="css" scoped>
</style>
