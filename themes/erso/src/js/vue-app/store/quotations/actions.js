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
  },

  download_quotations_guest: async ({ getters }) => {
    try {
      let headers = { }
      if(getters.get_token) headers['Authorization'] = 'Bearer ' + getters.get_token
      let data = {
        items: getters.get_cart_items,
        branch: getters.get_branch_selected,
        amount: getters.get_total_amount,
      }
      let downloable = await vm.prototype.$http.post('/quotations/download/guest', data, { headers })
      window.open(downloable.data.url)
    } catch (error) {
      throw error
    }
  }
}

export default actions      