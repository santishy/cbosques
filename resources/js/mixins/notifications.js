
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
