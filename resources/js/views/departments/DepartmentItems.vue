<template>
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-md-3">
        <ul class="list-group">
          <li class="list-group-item disabled" aria-disabled="true">Departamentos</li>
          <li v-for="(department,index) in departments" v-model="department_id" @click="setDepartmentId"
              :data-id="department.id" style="cursor:pointer" class="list-group-item list-group-item-action"
              :data-index="index+2" >
              {{department.name}}
          </li>
        </ul>
      </div>
      <div class="col-md-6">
        <div class="card"">
          <div class="card-body">
            <h5 class="card-title">Presupuestos</h5>
            <form>
              <div style="margin-bottom:0 !important" v-for="item in items" class="form-group form-check">
                <input @change="store" type="checkbox" :value="item.id" class="form-check-input" :id="item.id">
                <label class="form-check-label" :for="item.id">{{item.concept}}</label>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      items:[],
      departments:[],
      department_id:'',
      selected_element:null,
    }

  },
  mounted(){
    this.getData('api/departments')
    this.getData('api/cycles/items')
  },
  methods:{
    getData(route){
      axios({
        url:route,
        method:'GET'
      }).then((response)=>{
        if(response.data.data.length){
          if(route=='api/cycles/items')
            return this.items.push(...response.data.data)
          return this.departments.push(...response.data.data)
        }
      }).catch((error)=>{
        console.log(error)
      })
    },
    setDepartmentId(event){
      if(this.selected_element){
        this.selected_element.classList.remove('active')
      }
      this.department_id=event.target.dataset.id
      event.target.classList.add('active')
      this.selected_element = event.toElement;
      axios({
        url:'api/department/items',
        params:{
          id:this.department_id
        },
        method:'GET'
      }).then((response)=>{
        console.log(response)
        if(response.data.data.length){

        }
      })
    },

    store(event){
      var department_id = this.department_id
      let store = new Promise((resolve,reject)=>{
        if(department_id != "")
          return resolve();
        return reject('Debes seleccionar un departamento')
      })
      store.then(()=>{
        axios({
          method:'POST',
          url:'api/department-item/store',
          data:{department_id:this.department_id,item_id:event.target.value}
        }).then((response)=>{
          console.log(response)
        }).catch((error)=>{
          console.log(error)
        })
      }).catch((message)=>{
        event.target.checked=false;
        return alert('Primero debe escoger un departamento')
      })
    }
  }
}
</script>

<style lang="css" scoped>
</style>
