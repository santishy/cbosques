export default{
  data(){
    return{
      form:{},
      editing:false,
      hasErrorEditing:{}
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
      this.hasErrorEditing = {}
      return new Promise((resolve,reject)=>{
        axios({
          url:this.url+this.form.id,
          method:'PUT',
          data:this.form
        }).then((response)=>{
            if(response) // Response tiene un valor, falso o verdadero
            {
              for(var key in this.form){             // Aqui se actualiza el array que esta en el cliente (frontend)
                                                     //Por que ya se actualizo en backend, se hace lo mismo con la propiedad form.concept por ejemplo o segun se el caso, form es llenado segun se requiera
                this.array[index][key]=this.form[key]
              }
              this.array[index].editing = !this.array[index].editing;
              this.editing = this.array[index].editing
            }
            resolve(response)
        }).catch((error)=>{
          console.log(error)
          if(error.response.data.errors){
            this.hasErrorEditing = error.response.data.errors;
          }
          reject(error);
        })
      })

    },
    /**
    *
    *Elimina el objeto en el backend y frontend
    *
    **/
    destroy(index){
      axios({
        method:'DELETE',
        url:this.url+this.array[index].id,
      }).then((response)=>{
        console.log(response)
        if(response.status == 200){
          this.array.splice(index,1);
        }
      }).catch((error)=>{
        console.log(error)
      })
    }
  }
}
