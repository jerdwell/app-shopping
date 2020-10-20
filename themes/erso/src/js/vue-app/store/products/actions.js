import vm from 'vue'
const actions = {

  //setear la susucrsal seleccionada
  setBranchSelected: ({ commit, getters }, data) => {
    try {
      if(getters.get_cart_items.length > 0) vm.prototype.$swal('Cambio de sucursal', 'Al actualizar la sucursal tus productos han sido eliminados del carrito.', 'warning')
      commit('SET_BRANCH_SELECTED', data)
      commit('CLEAR_CART_DATA')
      commit('CLEAR_PRODUCTS')
    } catch (error) {
    }
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

  //busqueda por modelo
  serachProductModel: async ({ dispatch, getters }, data) => {
    try {
      let model_id = data.model_id
      let shipowner_id = data.shipowner_id
      let url = ''
      if(data.url){
        url = data.url
      }else if(!data.year && !data.category){
        url = `search-products/${getters.get_branch_selected}/${model_id}/${shipowner_id}`
      }else if(data.year && !data.category){
        url = `search-products/${getters.get_branch_selected}/${model_id}/${shipowner_id}/year/${data.year}`
      }else if(!data.year && data.category){
        url = `search-products/${getters.get_branch_selected}/${model_id}/${shipowner_id}/category/${data.category}`
      }else{
        url = `search-products/${getters.get_branch_selected}/${model_id}/${shipowner_id}/year/${data.year}/category/${data.category}`
      }
      let response = await vm.prototype.$http.get(url)
      dispatch('setListProducts', response.data.products)
      dispatch('setYearsRelated', response.data.years)
      dispatch('setCategoriesRelated', response.data.categories)
    } catch (error) {
      console.log(error);
    }
  },

  //búsqueda general de productos
  generalSearch: async({ dispatch, getters }, data) => {
    if( data.replace(/\s+/g, '').length <= 0 )return false
    try {
      let products = await vm.prototype.$http.get(`/general-search-products/${getters.get_branch_selected}/${encodeURI(data)}`)
      dispatch('setListProducts', products.data)
    } catch (error) {
      console.log(error)
    }
  },

  //búsqueda de productos por código
  searchByCode: async({ dispatch, getters }, data) => {
    if( data.replace(/\s+/g, '').length <= 0 )return false
    try {
      let products = await vm.prototype.$http.get(`/code-search-products/${getters.get_branch_selected}/${encodeURI(data)}`)
      dispatch('setListProducts', products.data)
    } catch (error) {
      console.log(error)
    }
  },

  setListShipowners: async() => {
    let list = await vm.prototype.$http.get(`/list-shipowners`)
    return list
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