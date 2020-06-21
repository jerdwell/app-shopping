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

function  getProductData(id){
  $(this).request('onGetProduct', {
    data: {
      product_id: id
    },
    success: (res) => {
      let modal = document.querySelector('.modal-pop-product')
      modal.style.right = '5px'
      $('.modal-pop-product-title').html(res.product_name)
      if(res.product_cover != null){
        $('.modal-pop-product-cover').attr('src',res.product_cover.path)
      }
      $('.modal-pop-product-price').html('Costo: <b>$' + res.product_price + '</b>')
      $('.modal-pop-product-description').html(res.product_description)
      let metadata = ''
      res.product_metadata.forEach(e => {
        metadata += `<li>${e.key}: <b>${e.value}</b></li>`
      })
      $('.modal-pop-product-metadata').html(metadata)
    }
  })
}

function closeModalProducts(){
  let modal = document.querySelector('.modal-pop-product')
  modal.style.right = '-50%'
}