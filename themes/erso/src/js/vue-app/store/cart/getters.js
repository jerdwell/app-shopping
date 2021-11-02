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

  get_product_price: (state, getters) => product => {
    let price = false
    if(!getters.get_token){
      price = '$' + product.public_price.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }else if(getters.get_token && getters.get_type_user == 'user'){
      price = '$' + product.public_price.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
    }else if(getters.get_token && getters.get_type_user == 'customer'){
      price = product.customer_price != null ? '$' + product.customer_price.replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 'No hay precio disponible'
    }
    return price
  },

  get_total_amount: (state, getters) => {
    let total = 0
    state.cart_items.map(e => {
      if(!getters.get_token){
        total += e.quantity *  e.public_price
      }else if( getters.get_token && getters.get_type_user != 'customer' ){
        total += e.quantity * e.public_price
      }else if( getters.get_token && getters.get_type_user == 'customer' ){
        total += e.quantity * e.customer_price
      }
    });
    return total.toFixed(2)
  }

}

export default getters