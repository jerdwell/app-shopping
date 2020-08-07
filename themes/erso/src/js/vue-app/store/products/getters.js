import state from "./state"

const getteres = {
  
  get_list_products: state => { return state.list_products },

  get_branch_selected: state => { return state.branch_selected },
  
  get_categories_related: state => { return state.categories_related },
  
  get_years_related: state => { return state.years_related },

  get_show_filters: state => { return state.show_filters }

}

export default getteres