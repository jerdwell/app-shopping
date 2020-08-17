const actions = {
  setDataAccount: ({ commit }, data)  => {
    commit('SET_DATA_ACCOUNT', data)
  },
  showRegister({ commit }){
    commit('SHOW_REGISTER')
  }
}

export default actions