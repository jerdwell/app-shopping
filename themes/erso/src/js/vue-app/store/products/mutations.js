import state from "./state"

const mutations = {

  SET_LIST_PRODUCTS: (state, data) => {
    state.list_products = data
  },

  CLEAR_PRODUCTS: state => {
    state.list_products = []
    state.years_related = []
    state.categories_related = []
  },

  SET_BRANCH_SELECTED: (state, data) => {
    state.branch_selected = data
  },

  SET_YEARS_RELATED: (state, data) => {
    state.years_related = data
  },
  
  SET_CATEGORIES_RELATED: (state, data) => {
    state.categories_related = data
  },

  TOGGLE_FILTERS: state => {
    state.show_filters = !state.show_filters
  }

}

export default mutations