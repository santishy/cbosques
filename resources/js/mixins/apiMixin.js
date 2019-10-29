export default{
  data(){
    return{
      form:{},
      editing:false,
      hasError:{}
    }
  },
  methods:{

    isEditing (){
      console.log('trigger isEditing')
      this.editing = true
    },
    editDone(){
      this.editing = false;
    },
    /*
    **
    *Actualiza el objeto en la base de datos en el backend.
    */
    store(){
      return new Promise((resolve,reject)=>{
        axios({url:this.url,
              data:this.form,
              method:'POST'}).then((response)=>{
                resolve(response)
              }).then((error)=>{
                reject(error)
              })
      });
    },
    updateDatabaseRecord(object){
      this.hasError = {}
      return new Promise((resolve,reject)=>{
        axios({
          url:this.url+object.id,
          method:'PUT',
          data:this.form
        }).then((response)=>{
            resolve(response)
        }).catch((error)=>{
          console.log(error)
          if(error.response.data.errors){
            this.hasERror = error.response.data.errors;
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
