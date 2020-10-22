const UpdateStock = {

  triggerBtn(){
    $('#file-stock').trigger('click')
  },

  uploadFile(){
    let form = document.getElementById('form-stock-file')
    let input = document.getElementById('file-stock')
    console.log(input.files[0])
    if(!input.files[0]) return
    let form_data = new FormData()
    form_data.append('stock_file', input.files[0])
    form_data.append('test_data', 'input.files[0]')
    let content_text = $('#text-indicator-stock')
    let stock_loader = $('#loading-stock-update')
    $.ajax({
      url: '/backend/loftonti/products/upload-file-update-stock',
      method: 'post',
      processData: false,
      contentType: false,
      data: form_data,
      beforeSend: () => {
        $('#btn-trigger-upload-file-stock').attr('disabled', true)
        stock_loader.css({display: 'inline-block'})
        content_text.css({display: 'block'})
      },
      success: res =>{
        $('#btn-trigger-upload-file-stock').attr('disabled', false)
        console.log(res)
        stock_loader.css({display: 'none'})
        let text_data = res.updateds
        content_text.html(`<h3>Productos actualizados: ${text_data}</h3>`)
      },
      error: err => {
        $('#btn-trigger-upload-file-stock').attr('disabled', false)
        stock_loader.css({display: 'none'})
        content_text.html(`<h3 class="text-danger">Productos actualizados: ${err.responseText}</h3>`)
      } 
    })
  }

}