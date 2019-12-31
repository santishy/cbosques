const getCycles = (context) => {
  return new Promise((resolve,reject)=>{
    axios({
      url:'/api/cycles',
      method:'GET'
    }).then((response)=>{
      context.commit('addCycles',response.data.data);
      resolve(response);
    }).catch((error) => {
      reject(error)
    })
  })
}
const getUnreadNotifications = (context)=>{
  return new Promise((resolve,reject)=>{
    axios({
      method:'GET',
      url:'/api/notifications/unreadNotifications',
    }).then((response) => {
      if(response.data.unreadNotifications.length)
        context.commit('setUnreadNotifications',response.data.unreadNotifications);
      resolve(response);
    }).catch((error) => {
      resolve(error);
    })
  })
}
const getRoles = ({commit})=>{
  return new Promise((resolve,reject)=>{
    axios({
      method:'GET',
      url:'/api/roles'
    }).then((response)=>{
      resolve(response.data)
    }).catch((error)=>{
      reject(error)
    })
  })
}
const login = ({commit},user) =>{
  return new Promise((resolve,reject)=>{
    commit('auth_request')
    axios({
      url:'/api/auth/login',
      data:user,
      method:'POST'
    }).then(response =>{
      const access_token = response.data.access_token;
      const authUser  = response.data.user;
      const roles = response.data.roles;
      sessionStorage.setItem('access_token',response.data.access_token);
      
      window.axios.defaults.headers.common['Authorization'] = 'Bearer '+response.data.access_token;
      commit('auth_success',access_token)
      commit('auth_user',authUser);
      commit('auth_roles',roles);
      resolve(response)
    }).catch((error)=>{
      commit('auth_error')
      sessionStorage.removeItem('access_token')
      reject(error)
    })
  })
}
const logout = ({commit}) => {
  return new Promise((resolve, reject) => {
    commit('auth_logout')
    sessionStorage.removeItem('access_token')
    delete axios.defaults.headers.common['Authorization']
    resolve();
  })
}
const refreshToken = ({commit}) => {
  return new Promise(
    (resolve,reject)=>{
      commit('auth_request')
      axios({
        url:'/api/auth/refresh',
        method:'POST'
      }).then((response)=>{
        resolve(response)
      }).catch((error)=>{
        reject(error)
      })
    }
  )
}
const register = ({commit},user) => {
  return new Promise((resolve,reject) =>{
    commit('auth_request')
    axios({
            method:'POST',
            data:user,
            url:'/api/auth/register'
          }).then((response)=>{
            /*
            * Debido a que solo registro usuarios como admin,no necesito borrar el token si algo sale mal
            */
            // const access_token = response.data.access_token;
            // const user  = response.data.user;
            // localStorage.setItem('access_token',response.data.access_token);
            // window.axios.defaults.headers.common['Authorization'] = 'Bearer '+response.data.access_token;
            // commit('auth_success',access_token,user)
            resolve(response)
          }).catch((error)=>{
            /*
            * Debido a que solo registro usuarios como admin,no necesito borrar el token si algo sale mal
            */
            // commit('auth_error',error);
            // localStorage.removeItem('access_token');
            reject(error);
          })
  })
}
/*
*Este metodo obtiene los usuarios, lo hice principalmente para la vista UserIndex
*
*/
const getUsers = ({commit}) =>{
  return new Promise((resolve,reject) => {
    axios({
      url:'/api/users/',
      method:'GET',
    }).then((response)=>{
      if(response.data.data.length)
        commit('setUsers',response.data.data);
        resolve(response.data.data)
    }).catch((error)=>{
      reject(error);
    })
  })
}
const getDepartments = ({commit})=>{
  return new Promise((resolve,response)=>{
    axios({
      url:'/api/departments',
      method:'GET'
    }).then((response)=>{
      commit('setDepartments',response.data.data)
      resolve(response.data.data)
    }).catch((error)=>{
      reject(error);
    })
  })
}
export default{
  getCycles,
  getUsers,
  login,
  logout,
  register,
  getRoles,
  getUnreadNotifications,
  getDepartments,
}
