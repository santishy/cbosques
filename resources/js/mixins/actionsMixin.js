export default{
  data(){
    return{
      form:{},
      editing:false,
    }

  },
  methods:{
    /*
    *
    * Agrega una propiedad a un array
    *
    */
    addingPropertyToObjects(data){
      return data.filter(function(obj){
              return Vue.set(obj,'editing',false);
            });
    },
    /*
    *
    *Cambia el icono de editado a listo (ok)
    */
    isEditing (index){
      var editing = this.editing
      var promise = new Promise(function(resolve,reject){
        if(!editing)
        {
          console.log(editing)
          return resolve();
        }
          else
        return reject('Ya hay un registro en edición')
      })
      promise.then((response)=>{
        for(var key in this.array[index]){
          if(key != 'editing' && key != 'cycle_id')
            Vue.set(this.form,key,this.array[index][key])
        }
        this.array[index].editing = !this.array[index].editing
        this.editing = this.array[index].editing
      },(error)=>{
        alert(error)
      })


    },
    /*
    **
    *Actualiza el objeto en la base de datos en el backend.
    */
    updateDatabaseRecord(index){
      axios({
        url:this.url+this.form.id,
        method:'PUT',
        data:this.form
      }).then((response)=>{
          if(response)
          {
            for(var key in this.form){
              this.array[index][key]=this.form[key]
              console.log(this.array[index])
              this.array[index].editing = !this.array[index].editing;
              this.editing = this.array[index].editing
            }
          }
      }).catch((error)=>{
        console.log(error)
      })
    }
  }
}
