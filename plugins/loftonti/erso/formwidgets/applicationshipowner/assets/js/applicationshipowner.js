const searchShipowner = {

  searchShipowner(){
    let input = document.getElementById('search-shipowner')
    let value = input.value
    let results_container = document.getElementById('shippowners-results')
    if(value.replace(/\s/g,'').length <= 1) return false
    $(this).request('onSearchShipowner', {
      data: { shipowner: value },
      success: res => {
        let results = ''
        for (let i = 0; i < res.length; i++) {
          let item = `<li>
              <label>
                <input type="checkbox" onclick="searchShipowner.searchShipownerSelected('${res[i].id}', '${res[i].shipowner_name}')"/>
                ${res[i].shipowner_name}
              </label>
            </li>`
          results += item
        }
        $('#shippowners-results').slideDown()
        results_container.innerHTML = results
        console.log(res)
      }
    })
  },


  searchShipownerSelected(id, name){
    let input_id = document.getElementById('id-shipowner-selected')
    let input_name = document.getElementById('search-shipowner')
    $('#shippowners-results').slideToggle()
    input_id.value = id
    input_name.value = name
  }

}