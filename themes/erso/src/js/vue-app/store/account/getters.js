const getters = {
  get_token: state => {return state.data_account.token },
  get_name: state => {return state.data_account.name },
  get_expire: state => {return state.data_account.expire },
  get_show_register: state => { return state.show_register }
}

export default getters