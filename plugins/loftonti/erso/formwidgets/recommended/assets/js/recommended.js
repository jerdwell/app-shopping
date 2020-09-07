$(document).ready(function(){
    $('.search-product-recommended').on('click', function(e){
        e.preventDefault()
        let data = $('.search-product-data').val()
        $(this).request('onSearchProducts', {
            data: { data: data },
            success: res => {
                let class_modal = 'search-product-recommended-modal-results-inactive'
                let content_results = $('.modal-results-items')
                $('.search-product-recommended-modal-results').removeClass(class_modal)
                let items = ''
                res.forEach(code => {
                    code.products.forEach(product => {
                        let template = `<li class="modal-results-item">
                                    <label>
                                        <input type="checkbox" name="${product.id}" id="${product.id}"> ${product.product_name} - ${product.car.model_name}
                                    </label>
                                </li>`
                        items+= template
                    })
                });
                content_results.html(items)
            }
        })
    })
})
