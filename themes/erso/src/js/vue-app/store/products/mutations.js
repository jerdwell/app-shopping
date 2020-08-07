import state from "./state"

const mutations = {

  setListProducts: (state, data) => {
    state.listProducts = data
  },

  clearProducts: state => {
    state.listProducts = []
    state.yearsRelated = []
    state.categoriesRelated = []
  },

  setBranchSelected: (state, data) => {
    state.branch_selected = data
  },

  setYearsRelated: (state, data) => {
    state.yearsRelated = data
  },
  
  setCategoriesRelated: (state, data) => {
    state.categoriesRelated = data
  }

}

export default mutations