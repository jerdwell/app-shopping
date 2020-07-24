import vm from 'vue'
const actions = {

  // Buscador de productos
  searchProducts: async({ commit }, data) => {
    try {
      let products = await vm.prototype.$http.get(`/search-product-category-model/${data.model}/${data.category}`)
      commit('setListProducts', products.data)
    } catch (error) {
      console.log(error.response.data)
    }
  },

  //Limpiar state de productos
  clearProducts: ({ commit }) => {
    commit('clearProducts')
  }

}

export default actions