<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-xs-10">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">
              Notificaciones no leídas
            </h3>
            <form @submit.prevent="allRead">
              <div class="form-group">
                <button class="btn btn-secondary btn-block" name="button"> Marcar todas como leídas</button>
              </div>
            </form>
            <div class="alert alert-primary" role="alert" v-for="unreadNotification in unreadNotifications">
              <router-link :key="unreadNotification.id"
                :to="{
                     name:unreadNotification.data.link,
                     params: {
                               'notification_id':unreadNotification.id,
                               'id':unreadNotification.data.data.id,
                             }
                     }">{{unreadNotification.data.text}}
              </router-link>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xs-10">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">
              Notificaciones leídas
            </h3>
            <div class="alert alert-secondary d-flex justify-content-between" role="alert" v-for="(readNotification,index) in readNotifications">
              <router-link :key="readNotification.id"
                :to="{
                     name:readNotification.data.link,
                     params: {
                               'notification_id':readNotification.id,
                               'id':readNotification.data.data.id,
                             }
                     }">{{readNotification.data.text}}
              </router-link>
              <form @submit.prevent='destroy(readNotification,index)'>
                <div class="form-group mb-0">
                  <button type="submit" class="btn btn-danger font btn-sm"><i class="fas fa-trash"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>

    </div>
  </div>
</div>
</template>

<script>
export default {
  data(){
    return{
      unreadNotifications:[],
      readNotifications:[],
    }
  },
  created(){
    this.allNotifications();
  },
  methods:{
    allNotifications(){
      axios({
        url:'/api/notifications/',
        method:'GET',
      }).then((response)=>{
        if(response.data){
          this.unreadNotifications = response.data.unreadNotifications;
          this.readNotifications = response.data.readNotifications;
        }
      }).catch((error)=>{
        console.log(error);
      })
    },
    destroy(notification,index){
      axios({
        method:'DELETE',
        data:{id:notification.id},
        url:'/api/notifications/'+notification.id
      }).then((response)=>{
        if(response.data.notificationDeleted){
          this.readNotifications.splice(index,1)
        }
      }).catch((error)=>{
        console.log(error)
      })
    },
    allRead(){
      axios({
        url:'/api/notifications/allRead',
        method:'GET'
      }).then((response)=>{
        console.log(response.data)
        if(response.status == 200){
          this.unreadNotifications=[]
          this.readNotifications=response.data;
        }

      }).catch((error)=>{
        console.log(error);
      })
    }
  }

}
</script>

<style lang="css" scoped>
  .font{
    font-size:.7rem;
  }
</style>
