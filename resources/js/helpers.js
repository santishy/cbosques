import Vue from 'vue';
/*
*
* Agrega una propiedad a un array
*
*/
const addingPropertyToObjects = (data) =>{
  return data.filter(function(obj){
          return Vue.set(obj,'editing',false);
        });
}
/*
*
*Cambia el icono de editado a listo (ok)
*/
const isEditing = (event,budgets) => {
    let index = event.toElement.dataset.index;
    console.log('index:'+index)
    budgets[index].editing=!budgets[index].editing;
}
export{
  addingPropertyToObjects,
  isEditing,
}
