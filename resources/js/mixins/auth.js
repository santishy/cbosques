import {mapGetters} from 'vuex';
import {mapActions} from 'vuex';
export default{
  methods:{
    ...mapActions(['logout']),
  },
  computed:{
    ...mapGetters(['isLoggedIn']),
  }
}
