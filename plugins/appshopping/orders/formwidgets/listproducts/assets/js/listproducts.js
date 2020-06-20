function toggleNewProduct() {
  let item = document.getElementById('product-browser-content')
  item.style.display = 'block'
}

function searchProducts(data) {
  let items = document.querySelectorAll('.id-product-order')
  let products_added = []
  items.forEach(e => {
    products_added.push(Number(e.value))
  });
  data = document.getElementById(data).value
  if(data.replace(/\s+/g, '').length <= 0) return false
  $(this).request('onTest', {
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
    <div class="row">
      <div class="col-sm-6">
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
          class="form-control text-center"
          name="product_price"
          value="${product_price}"
          required>
      </div>

      <div class="col-xs-4 col-sm-2 col-md-2 text-center">
        <label>Cantidad</label>
        <input
          type="number"
          step="1"
          name="${key}[quantity]"
          min="1"
          id=""
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
          id="total"
          value="${ product_price * 1 }"
          class="form-control text-center"
          required="true">
      </div>
    </div>

  `
  content.append(template)
  let item = document.getElementById('product-browser-content').style.display = 'none'
  document.querySelector('.products-results-container').style.display = 'none'
  return false
}