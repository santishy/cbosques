<template>
  <table class="table table-striped text-center">
    <thead>
      <th>Id</th>
      <th>Inicio</th>
      <th>Fin</th>
      <th>Activo</th>
      <th></th>
    </thead>
    <tbody>
      <tr  v-for="(cycle,ind) in cycles">
        <td>{{cycle.id}}</td>
        <td>
            <div v-if="cycle.editing" class="form-group">
              <date name="created_at" :index="ind" :value="cycle.created_at"></date>
            </div>
            <div v-else>
              {{cycle.created_at}}
            </div>

        </td>
        <td>
          <div v-if="cycle.editing" class="form-group">
            <date name="finalized_at" :index="ind" :value="cycle.finalized_at"></date>
          </div>
          <div v-else>
            {{cycle.finalized_at}}
          </div>
        </td>
        <td class="d-flex justify-content-center">
          <div v-if="cycle.active" class="circle bg-success ">
          </div>
          <div v-else class="circle bg-danger">
          </div>
        </td>
        <td>
          <i v-if="!cycle.editing" style="cursor:pointer" class="fas fa-highlighter" :data-index.number="parseInt(ind,10)" @click="edit"></i>
          <i v-else class="fas fa-check" style="cursor:pointer" :data-index.number="parseInt(ind,10)" @click="cycleUpdateInTheDatabase"></i>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
import {mapActions} from 'vuex';
import {mapState} from 'vuex';
import {mapGetters} from 'vuex';
import Date from './edit/Date';
export default {

  name:'Index',
  components:{
    'date':Date
  },
  computed:{
    ...mapState(['cycles']),
    ...mapGetters(['getCycleByIndex'])
  },
  methods:{
    //cambia el estado editing, del array Cycles.
    edit(event){
      let index = event.toElement.dataset.index;
      this.cycles[index].editing=!this.cycles[index].editing;
    },
    cycleUpdateInTheDatabase(event){
      this.edit(event)
      let cycle = this.$store.getters.getCycleByIndex(event.target.dataset.index)
      axios({
        url:'api/cycles/'+cycle.id,
        method:'PUT',
        data:cycle,
      }).then((response)=>{
        console.log(response)
      }).catch((error)=>{
        console.log(error)
      })
    },
  }
}
</script>

<style lang="css" scoped>
</style>
