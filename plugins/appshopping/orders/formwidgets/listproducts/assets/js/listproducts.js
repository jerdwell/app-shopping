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
    document.querySelector('.product-modal-results').classList.add('product-modal-results-inactive')
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
      document.querySelector('.product-modal-results').classList.remove('product-modal-results-inactive')
      let template = ''
      res.forEach(e => {
        if(products_added.indexOf(e.id) >= 0) return
        e.product_brands.forEach(brand => {
          template +='<tr>'
          template += `<td>${e.product_name}</td>` 
          template += `<td class="text-center">${brand.pivot.brand_code}</td>` 
          template += `<td class="text-center">${brand.pivot.brand_public_price}</td>` 
          template += `<td><button type="button" onclick="appendProduct('${e.product_name}', '${brand.pivot.brand_public_price}', '${brand.pivot.brand_code}', '${e.id}')" class="btn btn-success btn-sm">Agregar</button></td>` 
          template +='</tr>'
        })
      });
      if(template == '') template += `<tr><td>No existen resultados</td></tr>`
      $('#products-results').html(template)
    }
  })
  return false
}

function appendProduct(product_name, product_price, brand_code, product_id) {
  let content = $('.products-container')
  let childrens = content.children('tr').length
  let key = `Orders[products][${childrens}]`

  let template = `
    <tr id="${brand_code}">
      <td>
        ${product_name}
        <input type="hidden" name="Orders[order_details][${childrens}][product_name]" value="${product_name}"/>
      </td>
      
      <td>
        ${brand_code}
        <input type="hidden" name="Orders[order_details][${childrens}][brand_code]" value="${brand_code}"/>
      </td>
      
      <td>
        <input
        readonly
        type="text"
        id="price-${childrens}"
        class="form-control text-center"
        name="Orders[order_details][${childrens}][brand_public_price]"
        value="${product_price}"
        required>
      </td>

      <td>
        <input
        onchange="updateTotalSubtotalOrder('${(childrens)}')"
        type="number"
        step="1"
        name="Orders[order_details][${childrens}][product_quantity]"
        min="1"
        id="quantity-${childrens}"
        value="1"
        class="form-control text-center"
        autocomplete="off"
        pattern="-?\d+(\.\d+)?"
        maxlength="255"
        required="true">
      </td>

      <td>
        <input
        readonly
        type="number"
        name=""
        id="subtotal-${childrens}"
        value="${ product_price * 1 }"
        class="form-control text-center subtotal-items"
        required="true">
      </td>
      
      <td>
        <button type="button" class="btn btn-info btn-sm" onclick="getProductData('${product_id}')">
          <i class="icon icon-eye"></i>
        </button>
        <button onclick="detachOrderProductUnsaved('${brand_code}')" type="button" class="btn btn-danger btn-sm">
          <i class="icon icon-times"></i>
        </button>
      </td>

    </tr>

  `
  content.append(template)
  let button_cancel = document.getElementById('cancel-add-product-quotation').style.display = 'none'
  let button_add_product = document.getElementById('add-product-quotation').style.display = 'inline-block'
  let item = document.getElementById('product-browser-content').style.display = 'none'
  setTimeout(() => {
    updateTotalSubtotalOrder(childrens)
  }, 500);
  return false
}

function detachOrderProductUnsaved(id){
  let conf = confirm('¿En relaidad deseas quitar este producto de la lista?')
  if(conf){
    $('#' + id).remove()
    let content = $('.products-container')
    let childrens = content.children('.row').length
    updateTotalSubtotalOrder(childrens)
  }
}