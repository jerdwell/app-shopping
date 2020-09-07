const actions = {
  
  add_cart_item: ({ commit }, data) => {
    commit('ADD_CART_ITEM', data)
  },

  remove_cart_item: ({ commit }, data) => {
    commit('REMOVE_CART_ITEM', data)
  },

  delete_cart_item: ({ commit }, data) => {
    commit('DELETE_CART_ITEM', data)
  }

}

export default actions