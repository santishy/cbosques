 const getCycleByIndex = (state) => (index) =>{
  return state.cycles[index];
}

const isLoggedIn = state => !!state.access_token;
const  authStatus = state => state.status;
const getUser = state => state.user;
const getRoles = (state) => {
  return state.roles
};
export default{
  getCycleByIndex,
  getUser,
  getRoles,
  isLoggedIn,
  authStatus,
}
