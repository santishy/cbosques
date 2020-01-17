<template>
  <div class="container">
    <form-budgets v-on:newBudget="addBudget" @storedItem="adjustItemQty" :budget_qty="budget_qty" :title="this.$route.params.budget.concept" subtitle="Crear Rubro" url="/api/items"></form-budgets>
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="card border-primary mb-3 shadow-sm" >
          <div class="card-body text-dark">
            <h5 class="card-title">Lista de rubros (sub cuentas de generales)</h5>
            <table class="table table-striped text-center table-responsive-xl table-responsive-sm">
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
                        <input type="text"
                               name="concept"
                               v-model='form.concept'
                               :class="['form-control', hasErrorEditing.concept ? 'is-invalid' : '']">
                        <small class="text-danger" v-if="hasErrorEditing.concept">{{hasErrorEditing.concept[0]}}</small>
                    </div>
                    <div v-else>
                      {{item.concept}}
                    </div>
                  </td>
                  <td>
                    <div v-if="item.editing">
                      <input type="number"
                             name="qty"
                             v-model='form.qty'
                             :class="['form-control', hasErrorEditing.qty ? 'is-invalid' : '']">
                      <small class="text-danger" v-if="hasErrorEditing.qty">{{hasErrorEditing.qty[0]}}</small>
                    </div>
                    <div v-else>
                      {{item.qty}}
                    </div>
                  </td>
                  <td class="d-flex justify-content-center">
                    <div v-show="!item.editing" class="mr-2"  @click.prevent="isEditing(parseInt(ind,10))">
                       <i class="fas fa-highlighter" ></i>
                    </div>
                    <div v-show="item.editing"  @click.prevent="callUpdateDatabaseRecord(ind)">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="mr-2" @click="destroy(ind)" >
                      <i class="fas fa-trash"></i>
                    </div>

                  </td>
                </tr>
                <infinite-loading @infinite="infiniteHandler"></infinite-loading>
              </tbody>
            </table>
          </div>
        </div>
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
      url:'/api/items/',
      depertments:[],
      budget_qty:this.$route.params.budget.qty,
    }
  },
  mixins:[actionsMixin],
  methods:{
    infiniteHandler($state){
      axios({
        url:'/api/items',
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
      this.array.unshift(newBudget);
    },
    adjustItemQty(item){
      this.budget_qty -=item.qty
    },
    callUpdateDatabaseRecord(ind){
      this.updateDatabaseRecord(ind).then((response)=>{
        if(response.data)
        {
          // poner un emit no mutar asi
          this.budget_qty=response.data.budget.specification.qty;
        }
      })
    }
  }
}
</script>
