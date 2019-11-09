const addCycles= (state,cycles)=>{
  state.cycles =  cycles;
  state.cycles.filter(function(cycle){
          return Vue.set(cycle,'editing',false);
        });
}
const setCycle = (state,cycle) =>{
   Vue.set(cycle,'editing',false);
   state.cycles.push(cycle);
}
// Cambia a cero a la propiedad active del arreglo CYCLES que esta solo en vuex, no en el backend.
const deactivateCycles=(state)=>{
  var cycle = state.cycles.find(cycle=>cycle.active===1)
  var index = state.cycles.indexOf(cycle);
  console.log('index: '+index)
  state.cycles[index].active=0;
}
//actualiza un elemento del array cycles, solo del array de VUEX y no de el backend.
const cycleUpdate= function(state, data){
  state.cycles[data.index][data.name] = data.value;
}
const setUnreadNotifications = (state,unreadNotifications) => {
  state.unreadNotifications = unreadNotifications;
}
const auth_request = (state) => {
  state.status = 'loading'
}

const auth_success = (state,token) => {
  state.access_token =  token;
  state.status = 'success'
}
const auth_user=(state,authUser)=>{
  state.user = authUser;
}
const auth_error = (state) =>{
  state.status = 'error';
}
const auth_roles = (state,roles) => {
  localStorage.setItem('roles',JSON.stringify(roles));
  state.roles = roles;
}
const auth_logout = (state) => {
  state.status = '';
  state.access_token = '';
}

export default{
  addCycles,
  setUnreadNotifications,
  setCycle,
  deactivateCycles,
  cycleUpdate,
  auth_user,
  auth_roles,
  auth_request,
  auth_success,
  auth_error,
  auth_logout,
}
