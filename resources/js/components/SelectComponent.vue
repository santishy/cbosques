<template>
  <div>
    <div v-if="loading">
      Procesando...
    </div>
    <select v-else v-model="selected" @change="update"  class="form-control" :name="name" @keyup.esc="cancel" autofocus>
      <option v-for="item in items" :value="item.value">
              {{item.text}}
      </option>
    </select>
    <small v-if="hasError[name]" class="text-danger">{{hasError[name][0]}}</small>
  </div>
</template>
<script>
export default {
  props:['items','name','record','url','columns','index'],
  data(){
    return {
      hasError:{},
      selected:'',
      loading:false,
    }
  },
  mounted(){
    this.selected=this.record[this.name];
  },
  computed:{
    classes(){
      console.log('trigger classes on SelectedComponent')
      return [{'form-control':true},{'is-invalid':this.hasError[name]}];
    }
  },
  methods:{
    update(){
      this.loading=true;
      var fm = new FormData();
      fm.append(this.name,this.selected)
      fm.append('_method','PUT')
      for(let column in this.columns)
        fm.append(column,this.columns[column])
      console.log('trigger update on SelectComponent')
      axios({
        url:this.url+this.record.id,
        method:'POST',
        data:fm
      }).then((response)=>{
        let object = new Object();
        object.record = response.data;
        object.index = this.index
        this.$emit('updatedRecord',object)
        this.loanding=false;
      }).catch((error)=>{ // enviar mensaje descriptivo en modal
        this.hasError = error.response.data.errors
        this.loanding = false;
      })
    },
    cancel(){
      console.log('trigger cancel')
      this.$emit('cancel',this.index);
    }
  }
}
</script>

<style lang="css" scoped>
</style>
