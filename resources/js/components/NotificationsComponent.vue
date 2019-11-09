<template>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bell"></i> <span class="badge">{{unreadNotifications.length}}</span>
    </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <router-link v-for="(unreadNotification,index) in unreadNotifications"
                     :key="unreadNotification.id"
                     class="dropdown-item"
                     :to="{
                          name:unreadNotification.data.link,
                          params: {
                                    //el parametro num solo es para que cambie la url
                                    'notification_id':unreadNotification.id,
                                    'id':unreadNotification.data.data.id,}}">
          {{unreadNotification.data.text}}
        </router-link>
        <div class="dropdown-divider"></div>
        <router-link class="dropdown-item" to="/notifications/index" >Todas las notificaciones</router-link>
      </div>
  </li>
</template>

<script>
import {mapActions} from 'vuex';
import {mapState} from 'vuex';
export default {
  mounted() {
    this.getUnreadNotifications();
  },
  computed:{
    ...mapState(['unreadNotifications'])
  },
  methods:{

    ...mapActions(['getUnreadNotifications'])
  }
}
</script>

<style lang="css" scoped>
</style>
