/*
 * This is a sample JavaScript file used by ApplicationCar
 *
 * You can delete this file if you want
 */

const searchCar = {

  searchCarModel(){
    let input = document.getElementById('search-car')
    let value = input.value
    let results_container = document.getElementById('cars-results')
    if(value.replace(/\s/g,'').length <= 1) return false
    $(this).request('onSearchCar', {
      data: { car: value },
      success: res => {
        let results = ''
        for (let i = 0; i < res.length; i++) {
          let item = `<li>
              <label>
                <input type="checkbox" onclick="searchCar.searchCarSelected('${res[i].id}', '${res[i].car_name}')"/>
                ${res[i].car_name}
              </label>
            </li>`
          results += item
        }
        $('#cars-results').slideDown()
        results_container.innerHTML = results
        console.log(res)
      }
    })
  },


  searchCarSelected(id, name){
    let input_id = document.getElementById('id-car-selected')
    let input_name = document.getElementById('search-car')
    $('#cars-results').slideToggle()
    input_id.value = id
    input_name.value = name
  }

}