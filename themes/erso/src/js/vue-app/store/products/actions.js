import vm from 'vue'
const actions = {

  // Buscador de productos por auto
  searchProducts: async({ commit }, data) => {
    try {
      let products = await vm.prototype.$http.get(`/search-product-category-model/${data.model}/${data.category}`)
      commit('setListProducts', products.data)
    } catch (error) {
      console.log(error.response.data)
    }
  },

  //búsqueda general de productos
  generalSearch: async({ commit }, data) => {
    if( data.replace(/\s+/g, '').length <= 0 )return false
    try {
      let products = await vm.prototype.$http.get(`/general-search-products/${data}`)
      console.log(products);
      commit('setListProducts', products.data)
    } catch (error) {
      console.log(error)
    }
  },

  //Limpiar state de productos
  clearProducts: ({ commit }) => {
    commit('clearProducts')
  }

}

export default actions