import vm from 'vue'
const actions = {

  set_branch_selected: ({ commit }, data) => {
    commit('setBranchSelected', data)
  },

  setListProducts: ({ commit }, data) => {
    commit('setListProducts', data)
  },
  
  setYearsRelated: ({ commit }, data) => {
    commit('setYearsRelated', data)
  },
  
  setCategoriesRelated: ({ commit }, data) => {
    commit('setCategoriesRelated', data)
  },

  //busqueda por modelo / armadora
  serachProductModelShipowner: async ({ dispatch }, data) => {
    try {
      let model_id = data.model_id
      let shipowner_id = data.shipowner_id
      let response = await vm.prototype.$http.get(`search-products/${model_id}/${shipowner_id}`)
      dispatch('setListProducts', response.data.products)
      dispatch('setYearsRelated', response.data.years)
      dispatch('setCategoriesRelated', response.data.categories)
    } catch (error) {
      console.log(error);
    }
  },

  //búsqueda general de productos
  generalSearch: async({ dispatch }, data) => {
    if( data.replace(/\s+/g, '').length <= 0 )return false
    try {
      let products = await vm.prototype.$http.get(`/general-search-products/${data}`)
      dispatch('setListProducts', products.data)
    } catch (error) {
      console.log(error)
    }
  },

  searchByCode: async({ dispatch }, data) => {
    if( data.replace(/\s+/g, '').length <= 0 )return false
    try {
      let products = await vm.prototype.$http.get(`/code-search-products/${data}`)
      dispatch('setListProducts', products.data)
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