import state from "../cart/state"

const mutations = {
  SET_DATA_ACCOUNT: (state, data) => {
    state.data_account.name = data.name
    state.data_account.token = data.token
  }
}

export default mutations