<template>
  <div class="">
    <table class="table text-center table-inverse table-striped">
      <a href="quotations/"></a>
      <thead class="bg-primary text-white">
        <tr>
          <th>ID</th>
          <th>Usuario</th>
          <th>Descripcion</th>
          <th>IVA</th>
          <th>Monto</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="quotation in quotations">
          <td>
            {{quotation.id}}
          </td>
          <td>{{quotation.user_name}}</td>
          <td>{{quotation.description}}</td>
          <td>${{quotation.iva_format}}</td>
          <td>${{quotation.qty_format}}</td>
          <td>${{quotation.total_format}}</td>
        </tr>
      </tbody>
    </table>
  </div>

</template>

<script>

export default {
  props:['quotations'],
  data(){
    return {
      token:'Bearer '+sessionStorage.getItem('access_token'),
    }
  },
  created(){

  },
}
</script>

<style lang="css" scoped>
</style>
