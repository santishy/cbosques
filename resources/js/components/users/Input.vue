<template>
  <div class="form-group">
    <input :class="classes"
           v-model="column"
           :autofocus="true"
           :type="type"
           :name="name"
           @blur="close"
           @keyup.esc="close"
           @keyup.enter='update'>
           <small v-if="error.email" style="padding:0px" class="text-danger text-center">{{error.email[0]}}</small>
  </div>
</template>

<script>
import {mapMutations} from 'vuex';
export default {
  props:['type','name','user','value','index'],
  data(){
    return{
      error:false,
      column:this.value
    }
  },
  methods:{
    ...mapMutations(['updateUser']),
    update(){
      axios({
        method:'PUT',
        url:'/api/users/'+this.user.id+'/',
        data:{'value':this.column,'column':this.name},
      }).then((response)=>{
        let data = new Object();
        if(response.data.data){
          data.index = this.index;
          data.user = response.data.data
          this.updateUser(data);
        }
        this.close();
      }).catch((error)=>{

        this.error = error.response.data.errors
        console.log(this.error)
      })
    },
    close(){
      console.log('close')
      this.$emit('close','editing_'+this.name);
    },
  },

  computed:{
    classes(){
      console.log('trigger classes')
      return [{'form-control':true},{'is-invalid':this.error}]
    }
  }
}
</script>
