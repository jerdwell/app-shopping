function detachOrderProduct(product_id, order_id){
  let action = confirm('¿En verdad deseas eliminar este producto?')
  if(action){
    $(this).request('onDetachProduct', {
      data: {
        product_id: product_id,
        order_id: order_id
      },
      success: (res) => {
        if(res){
          location.reload()
        }else{
          console.log('error')
        }
      }
    })
  }
  return false
}

function updateTotalSubtotalOrder(data){
  let quantity = $('#quantity-' + data).val()
  let price = $('#price-' + data).val()
  let subtotal = $('#subtotal-' + data)
  let subtotal_items = $('.subtotal-items')
  let total = 0
  subtotal.val(quantity * price)
  for (let i = 0; i < subtotal_items.length; i++) {
    let item = subtotal_items[i]
    total = Number(total) + Number(item.value)
  }
  $('#order-total').val(total)
}