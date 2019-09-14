export default{
  data(){
    return{
      
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
      console.log(event)
      this.array[index].editing = !this.array[index].editing
    },
  }
}
