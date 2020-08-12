<template lang="pug">
div
  .cart-shopping-asside.cart-shopping-asside-hidden#cart-shopping-asside
    h4.text-center.text-muted Mis productos
    hr
    .close-shopping-cart-button.border-secondary(@click.prevent="toggleCart")
      .oi.oi-fullscreen-exit.text-secondary
    div(v-if="get_cart_items.length <= 0" )
      h5.text-info.text-center No tienes elementos agregados a la cotización
    div(v-else)
      .row(v-for="(product, index) in get_cart_items" :key="product.id")
        .col-4
          img.w-100(:src="`/storage/app/media${product.product_cover}`")
        .col-8
          h6.d-block.text-info {{ product.product_name }}
          span.d-block.small.text-muted Código: {{ product.provider_code }}
          span.d-block.small.text-muted Auto: {{ product.model }}
          span.d-block.small.text-muted Categoría: {{ product.category_name }}
          h6.d-block.text-dark.my-2
            span.align-middle Cantidad: {{ product.quantity }}
            div.d-inline-block.align-middle
              button.p-1.btn.btn-sm.bg-transparent.border-0.oi.oi-minus.text-danger(@click.prevent="remove_cart_item(product.id)")
              button.p-1.btn.btn-sm.bg-transparent.border-0.oi.oi-plus.text-info(@click.prevent="add_cart_item(product)")
          h6.d-block.lead.text-primary.small Precio: {{ product.public_price != null ? '$' + product.public_price : 'no hay dato' }}
        .col-12
          hr
      .text-center
        button.btn.btn-info
          .oi.oi-check.mr-2
          span Solicitar pedido
        button.btn.btn-sm.btn-dark.my-2
          .oi.oi-data-transfer-download.mr-2
          span Descargar cotización

</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'cart-shopping-asside',
  computed: {
    ...mapGetters([
      'get_cart_items', //get list products in cart buy
    ])
  },
  methods: {
    ...mapActions([
      'add_cart_item', //add item to cart
      'remove_cart_item', //remove item to cart
    ]),
    toggleCart(){
      let item = document.getElementById('cart-shopping-asside')
      if(item) item.classList.toggle('cart-shopping-asside-hidden')
    }
  },
}
</script>

<style lang="sass" scoped>
.cart-shopping-asside
  background: #f1f1ff
  bottom: 20px
  border-radius: 5px
  box-shadow: 0 0 10px rgba(0,0,0, .7)
  max-height: 80vh
  max-width: 300px
  overflow-y: auto
  position: fixed
  padding: 10px
  transition: all ease .5s
  right: 20px
  width: 90%
  z-index: 10
  @media screen and (min-width: 1024px)
    max-height: 70vh
  @media screen and (min-width: 1280px)
    border-radius: 0
    box-shadow: none
    position: static
    max-height: 90vh
    width: 100%

.close-shopping-cart-button
  align-content: center
  align-items: center
  display: flex
  border-radius: 50%
  border: solid 2px
  cursor: pointer
  font-size: 15px
  height: 30px
  justify-content: center
  margin: 0
  position: absolute
  right: 5px
  padding: 0
  top: 5px
  width: 30px
  .oi
    // line-height: 0
    position: static
    // top: 0
  @media screen and (min-width: 1280px)
    display: none

.cart-shopping-asside-hidden
  @media screen and (max-width:1279px)
    padding: 0
    height: 100px
    width: 0
</style>