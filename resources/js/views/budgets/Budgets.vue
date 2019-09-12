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
            <tr v-for="(budget,ind) in budgets">
              <td>{{budget.id}}</td>
              <td>{{budget.concept}}</td>
              <td>{{budget.qty}}</td>

              <td>
                <router-link :to="{ name: 'items', params: {budget:budget} }"><i class="fas fa-cubes" ></i></router-link>
              </td>
              <th>
                <a href="#" v-if="!budget.editing" :data-index.number="parseInt(ind,10)" @click.prevent="callIsEditing">
                   <i class="fas fa-highlighter" ></i>
                </a>
                <a v-else href="#"  :data-index.number="parseInt(ind,10)" @click="budgetUpdateInTheDatabase">
                <i  class="fas fa-check"></i>
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
import {addingPropertyToObjects,isEditing} from '../../helpers';
export default {
  data(){
    return {
      budgets:[],
      page:1,
    }
  },

  components:{
    'form-budgets':Form
  },

  methods:{
    callIsEditing(event){
      console.log(event.toElement.dataset)
      isEditing(event,this.budgets);
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
          this.budgets.push(...response.data.data)
          addingPropertyToObjects(this.budgets)
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
    budgetUpdateInTheDatabase(){

    },
    /*
      Agrega el Budget recien creado, es emitido desde otro componente
      *
    */
    addBudget(budget){
      this.budgets.push(budget);
    }
  }
}
</script>

<style lang="css" scoped>
</style>
