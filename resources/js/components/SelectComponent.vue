<template>
  <div>
    <select v-model="selected" @change="update" :class="classes" :name="name">
      <option v-for="item in items"  :value="item.value" :checked="item.value == record[name]">{{item.text}}</option>
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
      selected:''
    }
  },
  computed:{
    classes(){
      console.log('trigger classes on SelectedComponent')
      return [{'form-control':true},{'is-invalid':this.hasError[name]}];
    }
  },
  methods:{
    update(){
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
        console.log(response.data);
        object.record = response.data;
        object.index = this.index
        this.$emit('updatedRecord',object)
      }).catch((error)=>{
        this.hasError = error.response.data.errors
      })
    },
  }
}
</script>

<style lang="css" scoped>
</style>
