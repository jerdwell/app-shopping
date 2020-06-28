const Brands = {

  data: {
    input_search_brand: 'search-brand',
    brand_container: 'table-brand-container',
    modal_results: 'card-list-brands-results-content',
    tbody: 'list-brand-results-table-body',
    table_brands_attached: 'parent-table-brands',
    checkbox_brand: 'brands-to-attach',
    brands_selected: [],
    brands: []
  },

  addBrands(){
    let brandsItems = $(`.${this.data.checkbox_brand}`)
    let template = ''
    let indexBrand = $(`.${this.data.brand_container}`).length
    for(let i = 0; i < brandsItems.length; i++){
      if(brandsItems[i].checked){
        let brand_data = this.data.brands.find(item => item.id == brandsItems[i].value)
        template += `<tr class="table-brand-container"
          id="brand-${brand_data.id}"
          data-brand-id="${brand_data.id}">
          <td class="text-center">${brand_data.brand_name}</td>
          <td>
            <input
            type="text"
            name="Products[product_brands][${brand_data.id}][brand_code]"
            id="Products[product_brands][${brand_data.id}][brand_code]"
            class="form-control"
            value="">
          </td>
          <td>
            <input
            type="text"
            name="Products[product_brands][${brand_data.id}][brand_price]"
            id="Products[product_brands][${brand_data.id}][brand_price]"
            class="form-control"
            value="">
          </td>
          <td>
            <input
            type="text"
            name="Products[product_brands][${brand_data.id}][brand_public_price]"
            id="Products[product_brands][${brand_data.id}][brand_public_price]"
            class="form-control"
            value="">
          </td>
          <td>
            <input
            type="text"
            name="Products[product_brands][${brand_data.id}][brand_remark]"
            id="Products[product_brands][${brand_data.id}][brand_remark]"
            class="form-control"
            value="">
          </td>
          <td class="text-center">
            <button
              onclick="Brands.removeBrand('${brand_data.id}')"
              type="button"
              class="btn btn-danger btn-sm">
            <i class="icon icon-trash"></i></button>
          </td>
        </tr>`
        indexBrand ++
      }
    }
    $(`#${this.data.table_brands_attached}`).parent().append(template)
    this.toggleModal()
  },

  appendBrandsToList(){
    let template = '';
    this.data.brands.forEach(e => {
      template += `<tr>
        <td><input type="checkbox" value="${e.id}" class="${this.data.checkbox_brand}"/></td>
        <td>${e.brand_name}</td>
      </tr>`
    })
    template = `${template}`
    $('.' + this.data.tbody).html(template)
  },

  removeBrand(id){
    id = Number(id)
    let remove = confirm('¿En verdad deseas quitar esta marca del producto?')
    if(remove) $(`#brand-${id}`).remove()
  },

  searchBrand(){
    let items = $('.' + this.data.brand_container)
    let ids = items.map(e => { 
      let id = items[e].getAttribute('data-brand-id')
      return Number(id)
    })
    $(this).request('onSearchBrand',{
      success: (res) => {
        this.data.brands = res.filter(e => {
          if(ids.index(e.id) < 0) return e
        })
        this.toggleModal()
        this.appendBrandsToList()
      }
    })
  },

  toggleModal() {
    $('.' + this.data.tbody).html('')
    $('body').css({ 'overflow': $('body').css('overflow') == 'hidden' ? 'visible' : 'hidden' })
    $('.' + this.data.modal_results).toggleClass(this.data.modal_results + '-inactive')
  },

  toggleAllBrandSelected(){
    let brands_selected = $(`.${this.data.checkbox_brand}`)
    brands_selected.attr('checked', !brands_selected.attr('checked'))
  }

}