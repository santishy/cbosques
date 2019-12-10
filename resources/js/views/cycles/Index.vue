<template>
  <table class="table table-striped text-center table-responsive-xl table-responsive-sm">
    <thead>
      <th>Id</th>
      <th>Inicio</th>
      <th>Fin</th>
      <th>Activo</th>
      <th>Acciones</th>
      <th>Seleccionar</th>
    </thead>
    <tbody>
      <tr  v-for="(cycle,ind) in array">
        <td>{{cycle.id}}</td>
        <td>
            <div v-if="cycle.editing" class="form-group">
              <input :class="['form-control',hasErrorEditing.initialized_at ? 'is-invalid' : '']" type="date" name="initialized_at" :index="ind" v-model="form.initialized_at">
                <small v-if="hasErrorEditing.initialized_at" style="padding:0px" class="text-danger text-center">{{hasErrorEditing.initialized_at[0]}}</small>
            </div>
            <div v-else>
              {{cycle.initialized_at}}
            </div>

        </td>
        <td>
          <div v-if="cycle.editing" class="form-group">
            <input type="date" :class="['form-control',hasErrorEditing.finalized_at ? 'is-invalid' : '']" name="finalized_at" :index="ind" v-model="form.finalized_at">
              <small v-if="hasErrorEditing.finalized_at" style="padding:0px" class="text-danger text-center">{{hasErrorEditing.finalized_at[0]}}</small>
          </div>
          <div v-else>
            {{cycle.finalized_at}}
          </div>
        </td>
        <td class="text-center ">
          <div class="d-flex justify-content-center">
            <div v-if="cycle.active" class="circle bg-success ">
            </div>
            <div v-else class="circle bg-danger">
            </div>
          </div>

        </td>
        <td class="d-flex justify-content-center">
          <div class="mr-2" v-show="!cycle.editing" @click.prevent="isEditing(parseInt(ind,10))">
             <i class="fas fa-highlighter" ></i>
          </div>
          <div class="mr-2" v-show="cycle.editing" @click.prevent="updateDatabaseRecord(ind)">
              <i class="fas fa-check"></i>
          </div>
          <div @click="destroy(ind)" >
            <i class="fas fa-trash"></i>
          </div>
        </td>
        <td>
          <span :style="{'cursor':'pointer'}" @click="selectCycle(cycle.id)">
            <i class="fas fa-mouse-pointer"></i>
          </span>
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
import actionsMixin from '../../mixins/actionsMixin';
import {mapMutations} from 'vuex';
export default {

  name:'Index',
  mixins:[actionsMixin],
  data(){
    return {
      array:[],
      url:'/api/cycles/',
    }
  },
  computed:{
    ...mapState(['cycles']),
    ...mapGetters(['getCycleByIndex'])
  },
  mounted(){
    this.getCycles().then((response)=>{
      this.array = response.data.data
    }).catch((error)=>{
      console.log(error)
    })
  },
  components:{
    'date':Date
  },

  methods:{
    selectCycle(cycle_id){
      axios({
        method:'PUT',
        data:{id:cycle_id},
        url:'/api/cycles/select-cycle'
      }).then((response)=>{
        console.log(response.data)
        this.deactivateCycles();
        this.activateCycle(response.data.id)
      })
    },
    ...mapActions(['getCycles']),
    ...mapMutations(['setCycle','deactivateCycles','activateCycle']),
  }
}
</script>

<style lang="css" scoped>
</style>
