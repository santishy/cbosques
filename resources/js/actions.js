const getCycles = (context) => {
  axios({
    url:'api/cycles',
    method:'GET'
  }).then((response)=>{
    context.commit('addCycles',response.data.data);
  })
}
const login = ({commit},user) =>{
  return new Promise((resolve,reject)=>{
    commit('auth_request')
    axios({
      url:'http://budgets.dev:3000/api/auth/login',
      data:user,
      method:'POST'
    }).then(response =>{
      const access_token = response.data.access_token;
      const user  = response.data.user;
      localStorage.setItem('access_token',response.data.access_token);
      window.axios.defaults.headers.common['Authorization'] = 'Bearer '+response.data.access_token;
      commit('auth_success',access_token,user)
      resolve(response)
    }).catch((error)=>{
      commit('auth_error')
      localStorage.removeItem('access_token')
      reject(error)
    })
  })
}
const logout = ({commit}) => {
  return new Promise((resolve, reject) => {
    console.log('logout fue llamada')
    commit('logout')
    localStorage.removeItem('token')
    delete axios.defaults.headers.common['Authorization']
    resolve()
  })
}
export default{
  getCycles,
  login,
  logout,
}
