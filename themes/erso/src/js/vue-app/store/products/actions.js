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
      let url = ''
      if(data.url){
        url = data.url
      }else if(!data.year && !data.category){
        url = `search-products/${model_id}/${shipowner_id}`
      }else if(data.year && !data.category){
        url = `search-products/${model_id}/${shipowner_id}/year/${data.year}`
      }else if(!data.year && data.category){
        url = `search-products/${model_id}/${shipowner_id}/category/${data.category}`
      }else{
        url = `search-products/${model_id}/${shipowner_id}/year/${data.year}/category/${data.category}`
      }
      console.log(url)  
      let response = await vm.prototype.$http.get(url)
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
      dispatch('setListProducts', products.data.products)
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
  toggleFliters: async ({ commit }) => {
    try {
      let toggle = await commit('TOGGLE_FILTERS')
      if(!toggle) commit('CLEAR_PRODUCTS')
    } catch (error) {
      console.log(error)
    }
  }

}

export default actions