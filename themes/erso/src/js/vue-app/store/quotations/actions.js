import vm from 'vue'
const actions = {
  get_list_quotations: async ({ getters }, url) => {
    try {
      let headers = {
        Authorization: 'Bearer ' + getters.get_token
      }
      let list = await vm.prototype.$http.get('/quotations/list', { headers })
      return list.data
    } catch (error) {
      throw error
    }
  }
}

export default actions      