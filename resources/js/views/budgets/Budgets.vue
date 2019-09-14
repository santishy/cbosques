<template>
  <div class="container">
    <form-budgets v-on:newBudget="addBudget" url="api/budgets"  title="Presupuestos Generales" subtitle="Crear presupuesto"></form-budgets>
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <table class="table">
          <thead>
            <th>ID</th>
            <th>Concepto</th>
            <th>Cantidad</th>
            <th>Sub</th>
            <th>Acciones</th>
          </thead>
          <tbody>
            <tr v-for="(budget,ind) in array">
              <td>{{budget.id}}</td>
              <td>
                <div v-if="budget.editing">
                    <input type="text" name="concept" v-model='budgetForm.concept' class="form-control">
                </div>
                <div v-else>
                  {{budget.concept}}
                </div>
              </td>
              <td>
                <div v-if="budget.editing">
                  <input type="number" name="qty" class="form-control" v-model='budgetForm.qty'>
                </div>
                <div v-else>
                  {{budget.qty}}
                </div>

              </td>
              <td>
                <router-link :to="{ name: 'items', params: {budget:budget} }"><i class="fas fa-cubes" ></i></router-link>
              </td>
              <th>
                <a v-show="!budget.editing" @click.prevent="callIsEditing(parseInt(ind,10))">
                   <i class="fas fa-highlighter" ></i>
                </a>
                <a v-show="budget.editing"  @click.prevent="budgetUpdateInTheDatabase(ind)">
                    <i class="fas fa-check"></i>
                </a>
              </th>
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
  data(){
    return {
      array:[],
      page:1,
      budgetForm:{
        concept:'',
        qty:''
      }
    }
  },
  mixins:[actionsMixin],
  components:{
    'form-budgets':Form
  },

  methods:{
    /*
    *
    *Llamada al metodo isEditing del mixin, también obtenemos sus datos del elemento del array que esta en javascript
    */
    callIsEditing(ind){
      for(var key in this.array[ind])
        this.budgetForm[key] = this.array[ind][key]
      this.isEditing(ind);
    },
    /*
    *
    *Obtiene todos los budgets de la base de datos
    *
    */
    infiniteHandler($state){
      axios({
        url:'api/budgets',
        method:'GET',
        params:{
          page:this.page
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
    /**
    *Actualiza en la base de datos
    *
    *
    */
    budgetUpdateInTheDatabase(index){
      
    },

    /*
      Agrega el Budget recien creado, es emitido desde otro componente
      *
    */
    addBudget(budget){
      this.array.push(budget);
    }
  }
}
</script>

<style lang="css" scoped>
</style>
