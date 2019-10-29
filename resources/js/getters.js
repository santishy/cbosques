 const getCycleByIndex = (state) => (index) =>{
  return state.cycles[index];
}
const isLoggedIn = state => !!state.access_token;
const  authStatus = state => state.status;
export default{
  getCycleByIndex,
  isLoggedIn,
  authStatus,
}
