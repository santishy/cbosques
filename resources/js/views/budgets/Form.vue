<template>
  <div class="row justify-content-center">
      <div class="col-md-12 col-sm-12 col-lg-12 col-xs-10">
          <div class="card border-dark mb-3">
            <div v-if="isItem" class="card-header d-flex justify-content-between">
              <h4>{{title}}</h4>
              <h3>{{budget_qty}}</h3>
            </div>
            <div v-else class="card-header">{{title}}</div>
            <div class="card-body text-dark">
              <h5 class="card-title">{{subtitle}}</h5>
              <form @submit.prevent="store">
                <div class="form-group row">
                  <label for="qty" class="col-sm-2 col-form-label">Cantidad</label>
                  <div class="col-sm-10">
                    <input v-model="form.qty" type="number" class="form-control" id="qty" >
                  </div>
                </div>
                <div class="form-group row">
                  <label for="concept" class="col-sm-2 col-form-label">Concepto</label>
                  <div class="col-sm-10">
                    <input v-model="form.concept" class="form-control" id="concept">
                  </div>
                </div>
                <button  type="submit" class="btn btn-primary mb-2 btn-block">Guardar</button>
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
      page:1,
      isItem:false,
      budget_qty:0
    }

  },
  props:{
    title:String,
    subtitle:String,
    url:String
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
      this.budget_qty=this.$route.params.budget.qty;
      return this.isItem = true
    }
    return this.isItem= false
  },
  methods:{
    /*
    Crea un presupuesto general
      *
    */
    store(){
      axios({
        url:this.url,
        method:'POST',
        data:this.formData()
      }).then((response)=>{
        this.$emit('newBudget',response.data.data)
        if(this.isItem)
          this.budget_qty -= response.data.data.qty
      }).catch((error)=>{
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
