<template lang="pug">
  .card-body(
    data-aos="fade-up"
    data-aos-offset="200"
  )
    .row.py-3.bg-light.rounded-sm.product-item-browser
      .col-4.col-md-4.col-lg-8.offset-lg-2.p-2
        a.link.text-info.mb-4(:href="`products/product/${product.product_slug}`")
          img.w-100(:src="'/storage/app/media/' + product.product_cover")
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
        product-handler(:product="product")
    
</template>

<script>
import productHandler from './product-handler'
export default {
  props: [
    'product'
  ],
  components: {
    productHandler
  }
}
</script>

<style lang="sass">
.product-item-browser
  box-shadow: 0 5px 15px rgba(0,0,0,.3)
</style>