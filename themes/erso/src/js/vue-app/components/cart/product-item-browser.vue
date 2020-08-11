<template lang="pug">
  .card-body
    .row.py-3.bg-light.rounded-sm
      .col-4.col-md-4.col-lg-8.offset-lg-2.p-2
        a.link.text-info.mb-4(:href="`/products/product/${product.product_slug}`")
          img.w-100(:src="'http://www.erso.com.mx/storage/app/media/' + product.product_cover")
      .col-8.col-md-8.p-0.col-lg-12.pl-2.text-lg-center.pt-lg-3
        a.link.text-info.mb-4(:href="`/products/product/${product.product_slug}`" style="text-decoration:none;")
          span.h6.text-info {{ product.product_name }}
        p.mb-0.small
          span.text-muted Aplicación: {{ product.product_description }}
          br
          span.text-muted Año: {{ product.product_year }}
          br
          span.text-muted Auto: {{ product.shipowner.shipowner_name }} - {{ product.car.model_name }}
          br
          span.text-muted Código: {{ product.provider_code }}
          br
          b.text-info.mb-0.pb-0.lead {{ product.public_price != null ? '$' + product.public_price : 'Precio no disponible' }}
      .col-12
        .text-center.mt-2
          small.d-block.text-muted.mb-2.small Cotizar
          .row
            .col-8
              .input-group.input-group-sm
                input.form-control.form-control-sm(type="text" disabled)
                .input-group-prepend
                  .input-group-text pz
            .col-4.text-left.px-0
              button.btn.btn-danger.btn-sm.bg-transparent.text-danger.mr-1.rounded-circle(@click.prevent="remove_cart_item(product)")
                i.oi.oi-minus
              button.btn.btn-info.btn-sm.bg-transparent.text-info.rounded-circle(@click.prevent="add_cart_item(product)")
                i.oi.oi-plus
    
</template>

<script>
import { mapActions } from 'vuex'
export default {
  props: [
    'product'
  ],
  methods: {
    
    ...mapActions([
      'add_cart_item', //add item to cart shopping or quotation
      'remove_cart_item', //remove item to cart shopping or quotation
    ])

  },
  

}
</script>