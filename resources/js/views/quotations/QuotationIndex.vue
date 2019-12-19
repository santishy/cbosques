<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 col-lg-12 col-xs-11">
        <div class="card border-primary mb-3 shadow-sm">
          <table class="table table-striped table-responsive-sm table-responsive-xl">
            <thead>
              <th>ID</th>
              <th>Status</th>
              <th >Descripción</th>
              <th>Costo</th>
              <!--
               Aqui comento el iva por que asi se me pidio
              -->
              <!-- <th>IVA</th> -->
              <th>Total</th>
              <th>Usuario</th>
            </thead>
            <tbody>
              <tr v-for="(quotation,ind) in array">
                <td>{{quotation.id}}</td>
                <td style="cursor:pointer" class="font-weight-bold text-primary" v-if="!quotation.editing" @dblclick="isEditing(ind)">
                  {{quotation.status}}
                </td>
                <td v-else>
                  <select-component  url="/api/quotations/"
                                    :columns="{'item_id':quotation.item_id,'qty':quotation.qty,'iva':quotation.iva}"
                                    :record="quotation"
                                    :items="select"
                                    @updatedRecord="updatedArray"
                                    @cancel="doneEdit"
                                    :index="ind"
                                    name="status"/>
                </td>
                <td>{{quotation.description}}</td>
                <td>{{quotation.qty}}</td>
                <!--
                 Aqui comento el iva por que asi se me pidio
                -->
                <!-- <td>{{quotation.iva}}</td> -->
                <td>{{quotation.total}}</td>
                <td>{{quotation.user_name}}</td>
              </tr>
              <infinite-loading @infinite="infiniteHandler"></infinite-loading>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SelectComponent from '../../components/SelectComponent.vue';
import actionsMixin from '../../mixins/actionsMixin';
export default {
  data(){
    return{
      page:1,
      array:[],
    //  editing:false,
      select:[{value:'PENDIENTE',text:'PENDIENTE',},
              {value:'ACEPTADO',text:'ACEPTADO'},
              {value:'RECHAZADO',text:'RECHAZADO'}],

    }
  },
  mixins:[actionsMixin],
  components:{
    'select-component':SelectComponent
  },
  methods:{
    infiniteHandler($state){
      axios({
        url:'api/quotations',
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

  }
}

</script>

<style lang="css" scoped>
</style>
