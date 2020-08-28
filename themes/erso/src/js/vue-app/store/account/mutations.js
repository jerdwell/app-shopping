import state from "../cart/state"

const mutations = {
  SET_DATA_ACCOUNT: (state, data) => {
    state.data_account.name = data.name
    state.data_account.token = data.token
  },
  SHOW_REGISTER: state => {
    state.show_register = !state.show_register
  }
}

export default mutations