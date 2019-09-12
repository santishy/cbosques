<template>
  <div class="container">
    <form-budgets v-on:newBudget="addBudget" :title="this.$route.params.budget.concept" subtitle="Crear Rubro" url="/api/items"></form-budgets>
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <table class="table">
          <thead>
            <th>ID</th>
            <th>Concepto</th>
            <th>Cantidad</th>
            <th>Cycle ID</th>
          </thead>
          <tbody>
            <tr v-for="item in items">
              <td>{{item.id}}</td>
              <td>{{item.concept}}</td>
              <td>{{item.qty}}</td>
              <td>
                {{item.cycle_id}}
              </td>
            </tr>
            <infinite-loading @infinite="infiniteHandler"></infinite-loading>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import Form from './Form';
export default {
  components:{
    'form-budgets':Form
  },
  data(){
    return{
      items:[],
      page:1
    }
  },
  methods:{
    infiniteHandler($state){
      axios({
        url:'api/items',
        method:'GET',
        params:{
          page:this.page,
          budget_id:this.$route.params.budget.id
        }
      }).then((response)=>{
        if(response.data.data.length)
        {
          this.page++;
          this.items.push(...response.data.data)
          $state.loaded();
        }
        else{
          $state.complete()
        }
      }).catch((error)=>{
        console.log(error)
      })
    },
    addBudget(newBudget){
      this.items.push(newBudget);
    }
  }
}
</script>
