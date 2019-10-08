<template>
  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Cotización</h5>
            <p class="card-text"></p>

            <a href="#" class="card-link">Card link</a>
            <a href="#" class="card-link">Another link</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props:['notification'],
  mounted(){
    console.log(this.notification)
  }
}
</script>

<style lang="css" scoped>
</style>
