const mutations = {

  setListProducts: (state, data) => {
    state.listProducts = data
  },

  clearProducts: state => {
    state.listProducts = []
  }

}

export default mutations