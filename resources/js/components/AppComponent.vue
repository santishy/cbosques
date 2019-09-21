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
                    <router-link class="nav-link" :to="'cycles'"> Ciclos</router-link>
                  </li>
                  <li class="nav-item">
                    <router-link class="nav-link" to="departments"> Departamentos </router-link>
                  </li>
                  <li class="nav-item">
                    <router-link class="nav-link" to="budgets">Crear Presupuesto</router-link>
                  </li>
                  <li>
                    <router-link class="nav-link" to="departmentitems">Asignar Presupuestos</router-link>
                  </li>
                  <li class="nav-item">
                    <router-link class="nav-link" to="login"> Login</router-link>
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
    export default {
        mounted() {
            console.log('Component mounted.')
        }

    }
</script>
