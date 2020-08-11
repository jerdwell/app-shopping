const actions = {
  
  add_cart_item: ({ commit }, data) => {
    alert('agregar al carrito')
    commit('ADD_CART_ITEM', data)
  },

  remove_cart_item: ({ commit }, data) => {
    alert('quitar del carrito')
    commit('ADD_CART_ITEM', data)
  }
}

export default actions