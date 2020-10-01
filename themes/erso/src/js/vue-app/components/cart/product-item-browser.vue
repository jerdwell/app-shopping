<template lang="pug">
.my-3.product-item-browser(
    data-aos="fade-up"
    data-aos-offset="200"
  )
  .card-product-item.card
    .card-header.p-0(stye="z-index:0; position: relative;")
      a.link.text-info.mb-4(:href="`/productos/producto/${product.id}`")
        zoom-on-hover.product-item-image.bg-white(:img-normal="'/storage/app/media/' + product.product_cover")
    .card-body.p-0
      .product-item-data.py-3.bg-dark
        .text-lg-center.pt-lg-3
          a.link.text-info.mb-4(:href="`/productos/producto/${product.id}`" style="text-decoration:none;")
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
            b.text-info.mb-0.pb-0.lead(v-if="!get_token") {{ product.public_price != null ? '$' + product.public_price.replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 'Precio no disponible' }}
            b.text-info.mb-0.pb-0.lead(v-else) {{ product.customer_price != null ? '$' + product.customer_price.replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 'Precio no disponible' }}
        .col-12.bg-light.py-2.pb-3.mt-2
          product-handler(:product="product")
    
</template>

<script>
import { mapGetters } from 'vuex'
import productHandler from './product-handler'
export default {
  props: [
    'product'
  ],
  computed: {
    ...mapGetters([
      'get_token', //get token user
    ])
  },
  components: {
    productHandler
  }
}
</script>

<style lang="sass">
.card-product-item
.product-item-browser
  border-radius: 30px!important
  overflow: hidden!important
  box-shadow: 0 5px 15px rgba(0,0,0,.3)
  .product-item-image
    height: 200px
    width: 100%
  .product-item-data
    margin-top: -20px
    z-index: 10
    border-radius: 30px 30px 5px 5px
    padding-bottom: 0!important
    position: relative
  @media screen and(min-width: 1024px)
    .product-item-image
      height: 250px
</style>