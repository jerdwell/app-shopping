<template lang="pug">
div
  .cart-shopping-asside
    h4.text-center.text-muted Mis productos
    hr
    .row(v-for="(product, index) in get_cart_items" :key="product.id")
      .col-4
        img.w-100(:src="`/storage/app/media${product.product_cover}`")
      .col-8
        h6.d-block.text-info {{ product.product_name }}
        span.d-block.small.text-muted Código: {{ product.provider_code }}
        span.d-block.small.text-muted Auto: {{ product.model }}
        span.d-block.small.text-muted Categoría: {{ product.category_name }}
        h6.d-block.lead.text-primary.small Precio: {{ product.public_price != null ? '$' + product.public_price : 'no hay dato' }}
      .col-12
        hr

</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'cart-shopping-asside',
  computed: {
    ...mapGetters([
      'get_cart_items', //get list products in cart buy
    ])
  },
}
</script>

<style lang="sass">
  .cart-shopping-asside
    background: #f1f1ff
    bottom: 20px
    border-radius: 5px
    box-shadow: 0 0 10px rgba(0,0,0, .7)
    max-height: 70vh
    max-width: 300px
    overflow-y: auto
    position: fixed
    padding: 10px
    right: 20px
    width: 90%
    z-index: 10
</style>