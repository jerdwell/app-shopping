import state from "../cart/state"

const mutations = {
  SET_DATA_ACCOUNT: (state, data) => {
    state.data_account.name = data.name
    state.data_account.token = data.token
    state.data_account.expire = data.expire
  },
  SHOW_REGISTER: state => {
    state.show_register = !state.show_register
  },
  SIGN_OUT: state => {
    state.data_account.name = ''
    state.data_account.token = ''
    state.data_account.expire = ''
  }
}

export default mutations