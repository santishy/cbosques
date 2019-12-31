 const getCycleByIndex = (state) => (index) =>{
  return state.cycles[index];
}

const isLoggedIn = state => !!state.access_token;
const  authStatus = state => state.status;
const user = state => {
  return state.user
};
const getRoles = (state) => {
  return state.roles
};
export default{
  getCycleByIndex,
  user,
  getRoles,
  isLoggedIn,
  authStatus,
}
