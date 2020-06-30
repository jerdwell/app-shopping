const StockManage = {

  data: {

    table_finder_content: '#tbody-modal-stock-finder',
    modal_finder: 'modal-stock-manage',
    class_checkbox_modal: 'modal-stock-checkbox',
    table_stock_manage: 'table-stock-manage',
    stock_items_attached: 'stock-items-attached',
    json_stock_items_attached: 'json-stock-items-attached',
    brands: [],
    branches: []

  },

  addStockItems(){
    let vals = JSON.parse($(`#${this.data.json_stock_items_attached}`).val())
    let items = $(`.${this.data.class_checkbox_modal}`)
    let template = ''
    let index_items = $(`.${this.data.stock_items_attached}`).length
    for (let i = 0; i < items.length; i++) {
      if(items[i].checked){

        vals.push({
          brand_code: items[i].getAttribute('data-brand-code'),
          stock_product: "0",
          branch_id: items[i].value,
          branch_name: items[i].getAttribute('data-branch-name')
        })

        template += `<tr>
          <td>
            <input
              readonly
              type="text"
              name="Products[product_stock][${index_items}][brand_code]"
              id=""
              class="form-control"
              value="${items[i].getAttribute('data-brand-code')}">
          </td>
          <td>
            <input
              type="number"
              name="Products[product_stock][${index_items}][stock_product]"
              id="Products[product_stock][${index_items}][stock_product]"
              class="form-control"
              value="0">
          </td>
          <td>
            <input
              type="hidden"
              name="Products[product_stock][${index_items}][branch_id]"
              id=""
              class="form-control"
              value="${items[i].value}">
            <input
              readonly
              type="text"
              name="Products[product_stock][${index_items}][branch_name]"
              id=""
              class="form-control"
              value="${items[i].getAttribute('data-branch-name')}">
          </td>
          <td class="text-center">
          <button type="button" onclick="StockManage.deleteItem(${index_items})" class="btn btn-danger"><i class="icon icon-trash"></i></button>
          </td>
        </tr>`
        index_items++
      }
    }
    $('#' + this.data.table_stock_manage).append(template)
    $(`#${this.data.json_stock_items_attached}`).val(JSON.stringify(vals))
    this.toggleModalSearch()
  },

  deleteItem(index){
    let delete_item = confirm('¿En verdad deseas eliminar este dato?')
    if(delete_item) $(`.${this.data.stock_items_attached}`).eq(index).remove()
    let vals = JSON.parse($(`#${this.data.json_stock_items_attached}`).val())
    vals.splice(index,1)
    $(`#${this.data.json_stock_items_attached}`).val(JSON.stringify(vals))
  },

  prepareTemplateSearch(){
    let template = ''
    let vals = JSON.parse($(`#${this.data.json_stock_items_attached}`).val())
    this.data.brands.forEach(e => {
      this.data.branches.forEach(i => {
        if(vals.find(item => item.brand_code == e.brand_code && item.branch_id == i.id) == undefined){
          template += `<tr>
            <td><input type="checkbox" class="modal-stock-checkbox" value="${i.id}" data-branch-name="${i.branch_name}" data-brand-code="${e.brand_code}"/></td>
            <td>${e.brand_code}</td>
            <td>${i.branch_name}</td>
          </tr>`
        }
      })
    })
    this.toggleModalSearch()
    $(this.data.table_finder_content).html(template)
  },

  toggleModalSearch(){
    $('body').css({ overflow: document.querySelector('.' + this.data.modal_finder).classList.contains(this.data.modal_finder + '-inactive') ? 'hidden' : 'auto' })
    $('.' + this.data.modal_finder).toggleClass(this.data.modal_finder + '-inactive')
  },

  toggleAllCheckbox(){
    let checkbox_master = $('#checkbox-modal-stock-toggler')
    $('.' + this.data.class_checkbox_modal).attr('checked', checkbox_master.is(':checked'))
  },

  searchDataToAttach(product_id){
    $(this).request('onSearchDataToAttach', {
      data: {
        product_id
      },

      success: (res) => {
        this.data.brands = res.brands
        this.data.branches = res.branches
        this.prepareTemplateSearch()
      }

    })
  }

}