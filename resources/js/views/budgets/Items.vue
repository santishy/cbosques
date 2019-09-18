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
            <th>Acciones</th>
          </thead>
          <tbody>
            <tr v-for="(item,ind) in array">
              <td>{{item.id}}</td>
              <td>
                <div v-if="item.editing">
                    <input type="text" name="concept" v-model='form.concept' class="form-control">
                </div>
                <div v-else>
                  {{item.concept}}
                </div>
              </td>
              <td>
                <div v-if="item.editing">
                  <input type="number" name="qty" class="form-control" v-model='form.qty'>
                </div>
                <div v-else>
                  {{item.qty}}
                </div>
              </td>
              <td>

                <template v-if="!item.editing" class="d-flex">
                  <div  @click.prevent="isEditing(parseInt(ind,10))">
                     <i class="fas fa-highlighter" ></i>
                  </div>
                  <div @click="destroy(ind)" >
                    <i class="fas fa-trash"></i>
                  </div>
                </template>
                <template v-else>
                  <div @click.prevent="updateDatabaseRecord(ind)">
                      <i class="fas fa-check"></i>
                  </div>
                </template>
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
import actionsMixin from '../../mixins/actionsMixin';
export default {
  components:{
    'form-budgets':Form
  },
  data(){
    return{
      array:[],
      page:1,
      url:'api/items/'
    }
  },
  mixins:[actionsMixin],
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
          this.array.push(...response.data.data)
          this.addingPropertyToObjects(this.array)
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
      Vue.set(newBudget,'editing',false);
      this.array.push(newBudget);
    }
  }
}
</script>
