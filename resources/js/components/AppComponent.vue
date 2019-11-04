<template>
  <div class="">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" :href="'/'">
                Budgets
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                    <router-link class="nav-link" :to="'/cycles'">Ciclos</router-link>
                  </li>
                  <li class="nav-item">
                    <router-link class="nav-link" to="/budgets">Crear Presupuesto</router-link>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Departamentos
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <router-link class="nav-link" to="/departments"> Crear</router-link>
                        <router-link class="nav-link" to="/departmentitems">Asignar presupuesto</router-link>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Cotizaciones
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <router-link class="nav-link" to="/quotation-department-items"> Crear</router-link>
                      <router-link class="nav-link":to="{ name: 'quotation-index', params: {} }">Listar</router-link>
                    </div>
                  </li>
                  <li>
                    <router-link class="nav-link" :to="{ name: 'register', params: {} }">Registrar Usuarios</router-link>
                  </li>
                  <notifications-component/>
                  <li v-if="!isLoggedIn" class="nav-item">
                    <router-link class="nav-link" to="/login">Login</router-link>
                  </li>
                  <li v-else class="nav-item pull-right">
                    <a href="#" class="nav-link" @click.prevent="redirect">Cerrar Sesión</a>
                  </li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        <router-view :key="$route.fullPath"></router-view>
    </main>
  </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'
    import NotificationsComponent from './NotificationsComponent'
    export default {
      components:{
        'notifications-component':NotificationsComponent
      },
      computed:{
        ...mapGetters(['isLoggedIn']),
      },
      methods:{
        ...mapActions(['logout']),
        redirect(){
          this.logout().then(response => {
            this.$router.push('/login');
          })
        }
      },
    }
</script>
