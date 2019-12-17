<template>
  <div class="row justify-content-center">
      <div class="col-md-12 col-sm-12 col-lg-12 col-xs-10">
          <div class="card border-primary shadow-sm mb-3">
            <div class="card-body text-dark">
              <div v-if="isItem" class="d-flex justify-content-between">
                <h4>{{title}}</h4>
                <h4>{{budget_qty}}</h4>
              </div>
              <div v-else class="font-weight-bolder">{{title}}</div>
              <hr>
              <form @submit.prevent="store">
                <div class="form-group row">
                  <label for="qty" class="col-sm-2 col-form-label">Cantidad</label>
                  <div class="col-sm-10">
                    <input v-model="form.qty" type="number" :class="hasErrorQty" id="qty" >
                    <small v-if="hasError.qty" class="text-danger">{{hasError.qty[0]}}</small>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="concept" class="col-sm-2 col-form-label">Concepto</label>
                  <div class="col-sm-10">
                    <input v-model="form.concept" :class="hasErrorConcept"  id="concept">
                    <small v-if="hasError.concept" class="text-danger">{{hasError.concept[0]}}</small>
                  </div>
                </div>
                <div class="form-group row justify-content-between">
                  <button  type="submit" class="btn btn-primary mb-2 ml-3">Guardar</button>
                  <router-link to="/budgets" class="text-decoration-none mr-3" v-if="isItem">
                    <span :style="{'font-weight':'bold','font-size':'2em'}"><i class="far fa-arrow-alt-circle-left"></i></span>
                  </router-link>
                </div>

              </form>
            </div>
          </div>
      </div>
</div>
</template>

<script>

export default {
  data(){
    return{
      budgets:[],
      form:{
        concept:'',
        qty:''
      },
      hasError:{},
      page:1,
      isItem:false,

    }

  },
  props:{
    title:String,
    subtitle:String,
    url:String,
    budget_qty:Number,
  },
  name:'Form',
  /*
   *
   *Validamos que sea un item o budget
   *
   */
  created(){
    if(this.$route.params.budget)
    {
      // Asigno a la variable budget_qty el saldo disponible del budget escojido en caso de ser un item a crear
      //this.budget_qty=
      return this.isItem = true
    }
    return this.isItem= false
  },
  computed:{
    hasErrorQty()
    {
      return ['form-control', this.hasError.qty ? 'is-invalid' : ''];
    },
    hasErrorConcept(){
      return ['form-control', this.hasError.concept ? 'is-invalid' : ''];
    }
  },
  methods:{
    /*
    Crea un presupuesto general
      *
    */
    setClassError(){
      console.log('ya entro aki')
      return ['form-control', this.hasError.qty ? 'is-invalid' : ''];
    },
    store(){
      this.hasError={}
      axios({
        url:this.url,
        method:'POST',
        data:this.formData()
      }).then((response)=>{
        this.form={};
        this.$emit('newBudget',response.data.data)
        if(this.isItem){
          this.$emit('storedItem',response.data.data)
        }
      }).catch((error)=>{
        if(error.response.data.errors)
          this.hasError = error.response.data.errors;
        console.log(error)
      })
    },

    formData(){
      if (typeof this.$route.params.budget !== 'undefined')
        return {'concept':this.form.concept,'qty':this.form.qty,'budget_id':this.$route.params.budget.id}
      return {'concept':this.form.concept,'qty':this.form.qty}
    }
  }
}
</script>
