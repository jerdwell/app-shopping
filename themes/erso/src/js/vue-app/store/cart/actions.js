import vm from 'vue'
const actions = {
  
  add_cart_item: ({ commit, getters }, data) => {
    data['branch_selected'] = getters.get_branch_selected
    commit('ADD_CART_ITEM', data)
  },

  remove_cart_item: ({ commit }, data) => {
    commit('REMOVE_CART_ITEM', data)
  },

  delete_cart_item: ({ commit }, data) => {
    commit('DELETE_CART_ITEM', data)
  },

  async create_quotation({ rootState, getters }, data){
    try {
      let headers = {
        Authorization: 'Bearer ' + rootState.Account.data_account.token
      }
      let data_quotation = {
        shipping_date: data.shipping_date,
        items: getters.get_cart_items,
        amount: getters.get_total_amount,
        branch: getters.get_branch_selected
      }
      let quotation = await vm.prototype.$http.post('/quotations', data_quotation, { headers })
      return
    } catch (error) {
      console.log(error)
      throw error
    }
  },

  clear_cart_data({ commit }){
    commit('CLEAR_CART_DATA')
  }

}

export default actions