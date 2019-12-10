<template>
  <div  :style="{'min-height':'100vh'}">
    <nav v-if="isLoggedIn" class="navbar navbar-expand-lg navbar-dark navbar-full bg-primary shadow-md mb-3">
        <div class="container">
            <router-link class="navbar-brand" to="/">
                Control Presupuestal
            </router-link>
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
                        <router-link class="dropdown-item" to="/departments"> Crear</router-link>
                        <router-link class="dropdown-item" to="/departmentitems">Asignar presupuesto</router-link>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Cotizaciones
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <router-link class="dropdown-item" to="/quotation-department-items"> Crear</router-link>
                      <router-link class="dropdown-item":to="{ name: 'quotation-index', params: {} }">Listar</router-link>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Reportes
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <router-link class="dropdown-item" to="/reports-general">General</router-link>
                      <router-link class="dropdown-item"  :to="{ name: 'quote-report' }">Cotizaciones</router-link>
                    </div>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Usuarios
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <router-link class="dropdown-item" :to="{ name: 'register', params: {} }">Registrar Usuarios</router-link>
                        <router-link class="dropdown-item" to="/users">Listar</router-link>
                    </div>
                  </li>
                  <notifications-component/>
                  <li v-if="!isLoggedIn" class="nav-item">
                    <router-link class="nav-link" to="/login">Login</router-link>
                  </li>
                  <li v-else class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      usuario
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <a href="#" class="dropdown-item" @click.prevent="redirect">Cerrar Sesión</a>
                    </div>

                  </li>
                </ul>
            </div>
        </div>
    </nav>
    <main :class="{'py-4':isLoggedIn}" >
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
        ...mapGetters(['isLoggedIn','user']),
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
