<template lang="pug">
  #cart-shoppng-fixed-global.cart-shoppng-fixed-global.cart-shoppng-fixed-global-hidden(v-if="!get_show_filters && get_cart_items.length > 0")
    .cart-fixed-global-heading.bg-dark
      h4.text-center.text-light.m-0.py-4
        span.align-middle Mis productos
        button.border-0.bg-transparent.fas.fa-times.text-danger.ml-4.align-middle(@click.prevent="closeCartShopping")
    .cart-items
      cartItems(:heading="false")
    .cart-fixed-global-footer.bg-dark.p-3
      shippingDateComponent
</template>
<script>
import shippingDateComponent from './shipping-date-component'
import cartItems from './cart-items'
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'cart-fixed-global',
  computed: {
    ...mapGetters([
      'get_show_filters', //get if show filters home
      'get_cart_items', //get cart items
    ])
  },
  components:{
    cartItems,
    shippingDateComponent
  },
  methods: {
    ...mapActions([
      ''
    ]),
    closeCartShopping(){
      let cart_aside = document.getElementById('cart-shopping-asside')
      if(cart_aside) cart_aside.classList.toggle('cart-shopping-asside-hidden')
      
      let cart_global = document.getElementById('cart-shoppng-fixed-global')
      if(cart_global) cart_global.classList.toggle('cart-shoppng-fixed-global-hidden')
    }
  },
}
</script>

<style lang="sass">
.cart-shoppng-fixed-global::-webkit-scrollbar 
  display: none
.cart-shoppng-fixed-global
  background: #f1f1ff
  border-radius: 5px
  box-shadow: 0 0 10px rgba(0,0,0,.7)
  bottom: 15px
  max-width: 300px
  max-height: 70vh
  overflow: hidden
  overflow-y: auto
  position: fixed
  // padding: 20px
  right: 15px
  transition: all ease .5s
  width: 90%
  z-index: 100
  -ms-overflow-style: none  /* IE and Edge */
  scrollbar-width: none  /* Firefox */
  @media screen and(min-width: 768px)
    bottom: 0
    border-radius: 0
    right: 0
    max-height: none
    z-index: 2000
.cart-shoppng-fixed-global-hidden
  height: 0
  padding: 0
  width: 0
.cart-fixed-global-heading, .cart-fixed-global-footer
  left: 0
  position: sticky
  top: 0
  width: 100%
.cart-fixed-global-footer
  bottom: 0
  top: auto

</style>