<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Crear Cotización</h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>
            <form id="formData" @submit.prevent="store">
              <div class="form-group">
                <label for="item_id">Presupuestos</label>
                <select @change="setDepartmentItemId"
                        :class="['form-control', 'border-0', hasError.item_id ? 'is-invalid' : '']"
                         name="item_id" id="departmentsItems">
                  <option value="" :selected="true">Elige el presupuesto para tu cotización</option>

                  <option v-for="item in items" :data-department-id="item.department_id"
                          :value="item.id">{{item.concept+' '+item.qty}}</option>
                </select>
                <small class="text-danger" v-if="hasError.item_id">{{hasError.item_id[0]}}</small>
              </div>
              <div class="form-group">
                <label for="description">Descripción</label>
                <textarea v-model="form.description"
                          :class="['form-control', 'border-0',hasError.description ? 'is-invalid' : '']"
                          rows="4" cols="80"
                          name="description"></textarea>
                <small v-if="hasError.description" class="text-danger" >{{hasError.description[0]}}</small>
              </div>
              <div class="form-group">
                <label for="qty">Costo</label>
                <input type="number" name="qty"
                        :class="['form-control','border-0',hasError.qty ? 'is-invalid' : '']" v-model="form.qty">
                <small v-if="hasError.qty" class="text-danger">{{hasError.qty[0]}}</small>
              </div>
              <fieldset class="form-group">
                <div class="row">
                  <legend :class="['col-form-label', 'col-sm-2', 'pt-0', ]">IVA</legend>

                  <div class="col-sm-10">
                    <div class="form-check">
                      <input :class="['form-check-input',hasError.iva ? 'is-invalid' : '']"
                             type="radio" name="iva" id="iva_true" :value="1" >
                      <label :class="['form-check-label']" for="iva_true">
                        Si incluye
                      </label>
                    </div>
                    <div class="form-check">
                      <input :class="['form-check-input',hasError.iva ? 'is-invalid' : '']"
                             type="radio"
                             name="iva" id="iva_false" :value="0">
                      <label class="form-check-label" for="iva_false">
                        No incluye
                      </label>
                    </div>
                    <small class="text-danger" v-if="hasError.iva">{{hasError.iva[0]}}</small>
                  </div>
                </div>
              </fieldset>
              <div class="form-group">
                <label for="">Archivo</label>
                <input type="file" @change="onFileSelected" name="archive" :class="['form-control', hasError.archive ? 'is-invalid' : '']">
                <small v-if="hasError.archive" class="text-danger">{{hasError.archive[0]}}</small>
              </div>
              <div v-if="upload" class="progress mt-2 mb-2">
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :aria-valuenow="load" aria-valuemin="0" aria-valuemax="100" :style="{'width':load+'%'}"></div>
              </div>
              <button class="btn btn-success btn-block" name="button">Guardar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DepartmentList from '../departments/DepartmentList'
export default {
    mounted(){
      axios({
        method:'GET',
        url:'/api/users/items/',
      }).then((response)=>{
        console.log(response.data.data.length)
        this.ItemsByDepartment(response.data.data)
      }).catch((error)=>{
        console.log(error)
      })
    },
    components:{
      'department-list':DepartmentList
    },

    data(){
      return{
        department_id:'',
        items:[],
        form:{},
        fileSelected:null,
        upload:false,
        load:0,
        hasError:{}
      }
    },
    methods:{
      /*
      *
      *es un evento que regresa el componente departmentList que que retorna el id del departamento
      *
      */
      DepartmentId(id){
        this.form.department_id = id;
      },
      /*
      *
      *Son los items obtenidos por departamento, pero estos son emitidos desde el componente departmentlist
      *
      */
      ItemsByDepartment(data){
        var select=document.getElementById('departmentsItems');
        select.options[0].selected=true;
        select.options[0].text='Elige el presupuesto para tu cotización';
        if(data.length){
          this.items=[];
          data.forEach(department =>{
            let element={}
            department.items.forEach(item =>{
              element=item;
            })
            element['department_id'] = department.department_id;
            this.items.push(element)
          })
          return;
        }
        return this.items=[]

      },
      /*
      *Al cambiar el select de items de departamento, se dispara este evento el cual
      *agrega el item_id a el data(){return { form:{} }}
      */
      setDepartmentItemId(event){
        this.form.item_id = event.target.value;
        this.form.department_id = event.target.options[event.target.options.selectedIndex].dataset.departmentId
      },
      /*
      *En este metodo, obtenemos el archivo cargado y lo pasamos a la variable fileSelected
      *
      */
      onFileSelected(event){
        this.form.fileSelected = event.target.files[0];
        console.log(this.form.fileSelected)
      },
      /*
      *
      *
      */
      store(){
        this.loadingItems=true
        this.hasError={}
        const fd = new FormData(document.getElementById('formData'));
        fd.append('department_id',this.form.department_id);
        // fd.append('item_id',this.form.item_id);
        // fd.append('description',this.form.description);
        // fd.append('qty',this.form.qty);
        // fd.append('iva',this.form.iva);
        fd.append('archive',this.form.fileSelected);
        this.upload=true;
        axios({
          method:'POST',
          url:'/api/quotations',
          data:fd,
          onUploadProgress:uploadEvent=>{
            this.load = (Math.round(uploadEvent.loaded / uploadEvent.total) * 100);
          }
        }).then((response)=>{
          this.upload = false;
          Swal.fire({
            type: 'success',
            title: 'Cotización creado correctamente',
          })
        }).catch((error)=>{
          if(error.response.data.errors){
            this.hasError = error.response.data.errors;
          }
          this.upload = false;
        })
      },
      showLoadingMessage(){
        var select=document.getElementById('departmentsItems');
        select.options[0].text='Espere un momento, cargando...';
      },
    }

}
</script>

<style lang="css" scoped>
</style>
