<template>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell"></i> <span class="badge">{{unreadNotifications.length}}</span>
    </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <router-link v-for="unreadNotification in unreadNotifications"
                     :key="unreadNotification.id"
                     class="dropdown-item"
                     :to="{name:unreadNotification.data.link,params:{
                         'notification':unreadNotification.data.data
                         }}">
          {{unreadNotification.data.text}}
        </router-link>
        <div class="dropdown-divider"></div>
        <router-link class="dropdown-item" to="all-notifications" >Todas las notificaciones</router-link>
      </div>
  </li>
</template>

<script>
export default {
  data(){
    return {
      unreadNotifications:[]
    }
  },
  mounted() {
    axios({
      method:'GET',
      url:'/api/notifications',
    }).then((response) => {

      if(response.data.unreadNotifications.length)
        return this.unreadNotifications = response.data.unreadNotifications;
      return console.log(response)
    }).catch((error) => {
      console.log(error)
    })
  },
}
</script>

<style lang="css" scoped>
</style>
