function toggleNewProduct(data) {
  let browser = document.getElementById('product-browser-content')
  let cancel_button = document.getElementById('cancel-add-product-quotation')
  let add_product_button = document.getElementById('add-product-quotation')
  if(data){
    browser.style.display = 'block'
    cancel_button.style.display = 'inline-block'
    add_product_button.style.display = 'none'
  }else{
    $('#products-results').html('')
    document.querySelector('.products-results-container').style.display = 'none '
    browser.style.display = 'none'
    cancel_button.style.display = 'none'
    add_product_button.style.display = 'inline-block'
  }
}

function searchProducts(data) {
  let items = document.querySelectorAll('.id-product-order')
  let products_added = []
  items.forEach(e => {
    products_added.push(Number(e.value))
  });
  data = document.getElementById(data).value
  if(data.replace(/\s+/g, '').length <= 0) return false
  $(this).request('onFindProducts', {
    data: {
      value: data
    },
    success: (res) => {
      document.querySelector('.products-results-container').style.display = 'block'
      let template = ''
      res.forEach(e => {
        if(products_added.indexOf(e.id) >= 0) return
        template +='<tr>'
        template += `<td>${e.product_name}</td>` 
        template += `<td class="text-center">${e.product_sku}</td>` 
        template += `<td class="text-center">${e.product_price}</td>` 
        template += `<td><button type="button" onclick="appendProduct('${e.product_name}', '${e.product_price}', '${e.product_sku}', '${e.id}')" class="btn btn-success btn-sm">Agregar</button></td>` 
        template +='</tr>'
      });
      if(template == '') template += `<tr><td>No existen resultados</td></tr>`
      $('#products-results').html(template)
    }
  })
  return false
}

function appendProduct(product_name, product_price, product_sku, product_id) {
  let content = $('.products-container')
  let childrens = content.children('.row').length
  let key = `Orders[products][${childrens}]`

  let template = `
    <div class="row" id="${product_sku}">
      <div class="col-xs-8 col-sm-4">
        <label><small>${product_sku}</small></label>
        <input
          readonly
          type="text"
          class="form-control"
          name="product_name"
          value="${product_name}"
          required>
        <input
          type="hidden"
          class="form-control id-product-order"
          name="${key}[product_id]"
          value="${product_id}"
          required>
      </div>

      <div class="col-xs-4 col-sm-2 col-md-2 text-center">
        <label>Costo</label>
        <input
          readonly
          type="text"
          id="price-${childrens}"
          class="form-control text-center"
          name="product_price"
          value="${product_price}"
          required>
      </div>

      <div class="col-xs-3 col-sm-2 col-md-2 text-center">
        <label>Cantidad</label>
        <input
          onchange="updateTotalSubtotalOrder('${(childrens)}')"
          type="number"
          step="1"
          name="${key}[quantity]"
          min="1"
          id="quantity-${childrens}"
          value="1"
          placeholder=""
          class="form-control text-center"
          autocomplete="off"
          pattern="-?\d+(\.\d+)?"
          maxlength="255"
          required="true">
      </div>

      <div class="col-xs-4 col-sm-2 col-md-2 text-center">
        <label>Subtotal</label>
        <input
          readonly
          type="number"
          name="total"
          id="subtotal-${childrens}"
          value="${ product_price * 1 }"
          class="form-control text-center subtotal-items"
          required="true">
      </div>

      <div class="col-xs-5 col-sm-2 text-center">
        <div>
          <label>Acciones</label>
        </div>
        <button type="button" class="btn btn-info btn-sm" onclick="getProductData('${product_id}')">
          <i class="icon icon-eye"></i>
        </button>
        <button onclick="detachOrderProductUnsaved('${product_sku}')" type="button" class="btn btn-danger btn-sm">
          <i class="icon icon-times"></i>
        </button>
      </div>

    </div>

  `
  content.append(template)
  let button_cancel = document.getElementById('cancel-add-product-quotation').style.display = 'none'
  let button_add_product = document.getElementById('add-product-quotation').style.display = 'inline-block'
  let item = document.getElementById('product-browser-content').style.display = 'none'
  document.querySelector('.products-results-container').style.display = 'none'
  setTimeout(() => {
    updateTotalSubtotalOrder(childrens)
  }, 500);
  return false
}

function detachOrderProductUnsaved(id){
  $('#' + id).remove()
  let content = $('.products-container')
  let childrens = content.children('.row').length
  updateTotalSubtotalOrder(childrens)
}