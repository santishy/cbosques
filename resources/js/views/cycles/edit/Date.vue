<template>
  <div class="">
    <input type="date" :value="this.value" :name="name" @change="update" class="form-control">
  </div>
</template>


<script>
import {mapMutations} from 'vuex'
export default {
  props:['name','value','index'],
  name:'Date',
  created(){
    console.log(this.name+': '+this.value)
  },
  methods:{
    update(event){
      let data = new Object();
      data.name=this.name;
      data.value=event.target.value;
      data.index = this.index;
      this.cycleUpdate(data);
    },
    ...mapMutations(['cycleUpdate'])
  }
}
</script>

<style lang="css" scoped>
</style>
