const getCycles = (context) => {
  axios({
    url:'api/cycles',
    method:'GET'
  }).then((response)=>{
    context.commit('addCycles',response.data.data);
  })
}

export default{
  getCycles
}
