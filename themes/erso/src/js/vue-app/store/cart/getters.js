const getters = {
  
  get_cart_items: state => { return state.cart_items },

  find_item_in_cart: state => id => {
    let item_in_cart = state.cart_items.find(i => i.id == id)
    if(item_in_cart) return item_in_cart.quantity
    return 0
  },

  count_cart_items: state => {
    let items = 0
    state.cart_items.map(e => {
      items = items + e.quantity
    });
    return items
  },

  get_total_amount: (state, getters) => {
    let total = 0
    state.cart_items.map(e => {
      total += e.quantity * (!getters.get_token ? e.public_price : e.provider_price)
    });
    return total.toFixed(2)
  }

}

export default getters