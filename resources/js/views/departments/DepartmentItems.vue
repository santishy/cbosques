<template>
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-md-3">
        <department-list v-on:getItemsByDepartment="ItemsByDepartment" v-on:setDepartmentId="DepartmentId"></department-list>
      </div>
      <div class="col-md-6">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Presupuestos</h5>
            <form>
              <div style="margin-bottom:0 !important" v-for="item in items" class="form-group form-check">
                <input @change="store" type="checkbox" :value="item.id" class="form-check-input" :id="item.id" :checked="item.checked">
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

import DepartmentList from './DepartmentList'

export default {
  data(){
    return{
      items:[],
      departments:[],
      department_id:'',
      selected_element:null,
    }
  },
  components:{
    'department-list':DepartmentList
  },
  mounted(){
    //this.getData('api/departments')
    this.getData('api/cycles/items')
  },
  methods:{
    /*
    * con esta funcion marco las casillas correspondientes al departamento elegido
    *
    */
    checked:function(arr){
      arr.filter((element)=>{
       return  this.items.filter((item,index)=>{
          if(element.id == item.id){
            return this.items[index].checked = true;
          }
      })
    })},
    /*
    *
    * Obtiene los departamentos existentes y se vuelve a llamar para obtener todos
      los presupuestos, estas dos llamadas aun que es con la misma function son
      independientes.
    */
    getData(route){
      axios({
        url:route,
        method:'GET'
      }).then((response)=>{
        if(response.data.data.length){
          if(route=='api/cycles/items'){
             this.items.push(...response.data.data)
             return this.addFalseCheckedOption();
          }
          return this.departments.push(...response.data.data)
        }
      }).catch((error)=>{
        console.log(error)
      })
    },

    /*
    *
    *Son los items obtenidos por departamento, pero estos son emitidos desde el componente departmentlist
    *
    */
    ItemsByDepartment(data){

      this.addFalseCheckedOption();
      if(data.length)
        this.checked(data)
    },
    /*
    *
    *Agrega la opcion checked en falso, en todo el array items que esta en el componente.
    */
    addFalseCheckedOption(){
      return this.items.filter(function(obj){
        return Vue.set(obj,'checked',false);
      });
    },
    /*
    *
    *Almacena en la base de datos, el PRESUPUESTO marcado
    *
    */
    store(event){
      var department_id = this.department_id;
      var data = new Object();
      data.deparment_id = department_id;
      var store = new Promise((resolve,reject)=>{
        console.log('dentro del store:'+department_id)
        if(department_id != "")
          if(event.target.checked){
            data.url = 'api/department-item/store';
            data.method = 'POST'
            return resolve(data);
          }
          else{
            data.url = 'api/department-item/'+this.department_id
            data.method = 'DELETE'
            return resolve(data)
          }
        return reject('Debes seleccionar un departamento')
      })
      store.then((data)=>{
        axios({
          method:data.method,
          url:data.url,
          data:{department_id:this.department_id,item_id:event.target.value}
        }).then((response)=>{
          console.log(response)
        }).catch((error)=>{
          console.log(this.department_id)
          console.log(error)
        })
      }).catch((message)=>{
        event.target.checked=false;
        return alert('Primero debe escoger un departamento')
      })
    },
    DepartmentId(id){
      this.department_id = id;
    }
  }
}
</script>
