import vm from 'vue'
const actions = {

  // Buscador de productos
  searchProducts: async({ commit }, data) => {
    try {
      let products = await vm.prototype.$http.get(`/products/${data.type}/${data.data}/${data.limit}`)
      console.log(products)
      commit('setListProducts', products.data)
    } catch (error) {
      console.log(error.response.data)
    }
  }

}

export default actions