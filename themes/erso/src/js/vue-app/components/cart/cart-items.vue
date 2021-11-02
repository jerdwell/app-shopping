<template lang="pug">
  div
    div(v-if="get_cart_items.length <= 0" )
      h5.text-info.text-center No tienes elementos agregados a la cotización
    div(v-else)
      .table-responsive
        table.table.table-striped
          thead
            tr.bg-dark
              th #
              th.text-yellow.text-center Producto
              th.text-yellow.text-center Costo
          tbody
            tr(v-for="(product, index) in get_cart_items" :key="product.id")
              td.text-center.text-dark {{ index +1 }}
              td.text-center.text-dark
                span.small {{ product.product_name }}
                br
                small #[b {{ product.provider_code }}]
                .w-100.d-inline-block.align-middle
                  button.cart-button-handler.p-1.btn.btn-sm.bg-transparent.fas.fa-minus.text-danger.border-danger(@click.prevent="remove_cart_item(product.id)")
                  span.align-middle.mx-2 {{ product.quantity }}
                  button.cart-button-handler.p-1.btn.btn-sm.bg-transparent.fas.fa-plus.text-info.border-info(@click.prevent="add_cart_item(product)")
                .text-center
                  a.small.text-danger(href="#" @click.prevent="delete_cart_item(product)") Eliminar #[.fas.fa-times]
              td.text-center.text-dark
                span.small {{ get_product_price(product) }}
      
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'cart-items',
  computed: {
    ...mapGetters([
      'get_cart_items', //get list products in cart buy
      'get_token', //check if token user exists
      'get_total_amount', //get total amont
      'get_product_price', //get product price
    ])
  },
  methods: {
    ...mapActions([
      'add_cart_item', //add item to cart
      'remove_cart_item', //remove item to cart
      'delete_cart_item', //delete item to cart
    ]),
  },
}
</script>

<style lang="sass">
.swal-button--confirm
  background: #17a2b8!important
  background-color: #17a2b8!important
.cart-button-handler
  border-radius: 50%
  border: solid 1px
  vertical-align: middle
.headig-cart-items
  border: solid 1px red
  left: 0
  position: sticky
  top: 0
</style>