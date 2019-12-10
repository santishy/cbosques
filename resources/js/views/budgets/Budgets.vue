<template>
  <div class="container">
    <form-budgets v-on:newBudget="addBudget"
                  url="api/budgets"  title="Presupuestos Generales"
                  subtitle="Crear presupuesto">
    </form-budgets>
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <div class="card border-primary mb-3 bg-light shadow-sm" >
          <div class="card-body text-dark">
            <h5 class="card-title">Lista de cuentas generales</h5>
            <table class="table text-center table-responsive-xl table-responsive-sm">
              <thead class="bg-primary text-white">
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
                        <input type="text"
                                name="concept"
                                v-model='form.concept'
                                :class="['border-0','form-control',hasErrorEditing.concept ? 'is-invalid' : '']"
                        />
                        <small class="text-danger" v-if="hasErrorEditing.concept">{{hasErrorEditing.concept[0]}}</small>
                    </div>
                    <div v-else>
                      {{budget.concept}}
                    </div>
                  </td>
                  <td>
                    <div v-if="budget.editing">
                      <input type="number"
                             name="qty"
                             v-model='form.qty'
                             :class="['border-0','form-control',hasErrorEditing.qty ? 'is-invalid' : '']"
                      />
                      <small class="text-danger" v-if="hasErrorEditing.qty">{{hasErrorEditing.qty[0]}}</small>
                    </div>
                    <div v-else>
                      {{budget.qty}}
                    </div>

                  </td>
                  <td>
                    <router-link :to="{ name: 'items', params: {budget:budget} }"><i class="fas fa-cubes" ></i></router-link>
                  </td>
                  <td class="d-flex justify-content-center">
                    <div class="mr-2" v-show="!budget.editing" @click.prevent="isEditing(parseInt(ind,10))">
                       <i class="fas fa-highlighter" ></i>
                    </div>
                    <div class="mr-2" v-show="budget.editing" @click.prevent="updateDatabaseRecord(ind)">
                        <i class="fas fa-check"></i>
                    </div>
                    <div @click="destroy(ind)" >
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
  data(){
    return {
      array:[],
      page:1,
      url:'api/budgets/'
    }
  },
  mixins:[actionsMixin],
  components:{
    'form-budgets':Form
  },

  methods:{
    /*
    *
    *Obtiene todos los budgets de la base de datos
    *
    */
    infiniteHandler($state){
      axios({
        url:'api/budgets/',
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


    /*
      Agrega el Budget recien creado, es emitido desde otro componente
      *
    */
    addBudget(budget){
      Vue.set(budget,'editing',false);
      this.array.unshift(budget);
    }
  }
}
</script>

<style lang="css" scoped>
</style>
