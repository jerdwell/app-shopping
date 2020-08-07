const getteres = {
  
  getListProducts: state => { return state.listProducts },

  get_branch_selected: state => { return state.branch_selected },
  
  get_categories_related: state => { return state.categoriesRelated },
  
  get_years_related: state => { return state.yearsRelated },

}

export default getteres