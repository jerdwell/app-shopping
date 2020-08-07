import vm from 'vue'
const actions = {

  //setear la susucrsal seleccionada
  setBranchSelected: ({ commit }, data) => {
    commit('SET_BRANCH_SELECTED', data)
  },

  // setear el listado de producto
  setListProducts: ({ commit }, data) => {
    commit('SET_LIST_PRODUCTS', data)
  },
  
  // setear lel listado de años
  setYearsRelated: ({ commit }, data) => {
    commit('SET_YEARS_RELATED', data)
  },
  
  //setear las categorías relacionadas
  setCategoriesRelated: ({ commit }, data) => {
    commit('SET_CATEGORIES_RELATED', data)
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

  //búsqueda de productos por código
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
    commit('CLEAR_PRODUCTS')
  },

  //Mostrar los filtros
  toggleFliters: ({ commit }) => {
    commit(('TOGGLE_FILTERS'))
  }

}

export default actions