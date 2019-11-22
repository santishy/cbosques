<template>
  <div class="row justify-content-end">
    <span :style="{'cursor':'pointer'}" class="badge  badge-secondary" @click="close">
    Cerrar <i class="fas fa-times"></i>
    </span>
  </div>
</template>

<script>
export default {
  methods:{
    close(){
      this.$emit('close')
    }
  }
}
</script>

<style lang="css" scoped>
</style>
