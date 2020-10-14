const mutations = {
  
  ADD_CART_ITEM: (state, data) => {

    let item_in_cart = state.cart_items.find(i => i.id == data.id)
    if(!item_in_cart){
      let item = {
        id: data.id,
        product_name: data.product_name,
        // product_year: data.product_year,
        category_name: data.category.category_name,
        provider_code: data.provider_code,
        erso_code: data.erso_code,
        product_cover: data.product_cover,
        public_price: data.public_price,
        customer_price: data.customer_price,
        brand_name: data.brand.brand_name,
        // model: `${data.shipowner.shipowner_name} ${data.car.model_name}`,
      }
      if(data.branches[0].pivot.stock <= 0) return
      item.quantity = 1
      state.cart_items.push(item)
    }else{
      if(item_in_cart.quantity < data.branches[0].pivot.stock)
      item_in_cart.quantity ++
    }

  },

  REMOVE_CART_ITEM: (state, id) => {
    let index = state.cart_items.map(i => { return i.id }).indexOf(id)
    let item = state.cart_items[index]
    if(item.quantity == 1) return state.cart_items.splice(index, 1)
    item.quantity --
  },

  DELETE_CART_ITEM: (state, item) => {
    let index = state.cart_items.map(e => { return e.id}).indexOf(item.id)
    state.cart_items.splice(index, 1)
  },

  CLEAR_CART_DATA: state => {
    state.cart_items = []
  }

}

export default mutations