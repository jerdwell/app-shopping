import vm from 'vue'
const actions = {
  setDataAccount: ({ commit }, data)  => {
    commit('SET_DATA_ACCOUNT', data)
  },
  
  showRegister({ commit }){
    commit('SHOW_REGISTER')
  },
  
  async getDataAccount({ rootState }){
    try {
      let headers = {
        Authorization: 'Bearer ' + rootState.Account.data_account.token
      }
      let data_account = await vm.prototype.$http.get('/account/data-account', { headers })
      return data_account
    } catch (error) {
      throw error
    }
  },

  async updateDataAccount({ rootState }, data){
    try {
      let headers = {
        Authorization: 'Bearer ' + rootState.Account.data_account.token
      }
      let url;
      switch (data.type) {
        case 'personal':
          url = '/account/update/personal-data'
          break;
        case 'address':
          url = '/account/update/address-data'
          break;
      
        default:
          break;
      }
      let updated = await vm.prototype.$http.post(url, data.data, { headers })
      return updated.data[0]
    } catch (error) {
      return error.response.data
    }
  },

  signOut({ commit }){
    commit('SIGN_OUT')
    return true
  }

}

export default actions