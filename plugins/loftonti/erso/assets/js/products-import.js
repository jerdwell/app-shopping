const UpdateStock = {

  triggerBtn() {
    $('#file-stock').trigger('click')
  },

  uploadFile() {
    let form = document.getElementById('form-stock-file')
    let input = document.getElementById('file-stock')
    if (!input.files[0]) return
    let form_data = new FormData()
    form_data.append('stock_file', input.files[0])
    form_data.append('test_data', 'input.files[0]')
    let content_text = $('#text-indicator-stock')
    let stock_loader = $('#loading-stock-update')
    let alta_stock = $('#alta-stock')
    alta_stock = alta_stock.is(':checked')
    if(alta_stock) form_data.append('create_stock', true)
    $.ajax({
      url: '/backend/loftonti/products/upload-file-update-stock',
      method: 'post',
      processData: false,
      contentType: false,
      data: form_data,
      beforeSend: () => {
        $('#btn-trigger-upload-file-stock').attr('disabled', true)
        stock_loader.css({ display: 'inline-block' })
        content_text.css({ display: 'block' })
      },
      success: res => {
        $('#btn-trigger-upload-file-stock').attr('disabled', false)
        stock_loader.css({ display: 'none' })
        let text_data = res.updateds
        content_text.html(`<h3>Productos actualizados: ${text_data}</h3>`)
        if(res.errors && res.errors.length > 0) content_text.append(`<h4>Productos no cargados: ${res.errors.length}, Se enviará un correo con los detalles de la carga.</h4>`)
      },
      error: err => {
        console.log(err)
        $('#btn-trigger-upload-file-stock').attr('disabled', false)
        stock_loader.css({ display: 'none' })
        content_text.html(`<h3 class="text-danger">Productos actualizados: ${err.responseText}</h3>`)
      }
    })
  }

}

const MassiveDelete = {

  triggerBtn() {
    $('#file-delete').trigger('click')
  },

  uploadFile() {
    let input = document.getElementById('file-delete')
    if (!input.files[0]) return
    let form_data = new FormData()
    form_data.append('delete_file', input.files[0])
    let content_text = $('#text-indicator-delete')
    let stock_loader = $('#loading-stock-delete')
    $.ajax({
      url: '/backend/loftonti/products/upload-file-massive-delete',
      method: 'post',
      processData: false,
      contentType: false,
      data: form_data,
      beforeSend: () => {
        $('#btn-trigger-upload-file-deletes').attr('disabled', true)
        stock_loader.css({ display: 'inline-block' })
        content_text.css({ display: 'block' })
      },
      success: res => {
        $('#btn-trigger-upload-file-deletes').attr('disabled', false)
        stock_loader.css({ display: 'none' })
        let text_data = res.updateds
        content_text.html(`<h3>Productos actualizados: ${text_data}</h3>`)
      },
      error: err => {
        $('#btn-trigger-upload-file-deletes').attr('disabled', false)
        stock_loader.css({ display: 'none' })
        content_text.html(`<h3 class="text-danger">Productos actualizados: ${err.responseText}</h3>`)
      }
    })
  }

}