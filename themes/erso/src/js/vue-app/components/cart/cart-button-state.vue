<template lang="pug">
  button.btn.btn-dark.btn-cart-state(v-show="count_cart_items > 0" @click.prevent="showCarFilters")
    .oi.oi-cart
    span.cart-items-count.bg-success {{count_cart_items <= 10 ? count_cart_items : '+10'}}
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  computed: {
    ...mapGetters([
      'count_cart_items' //items del carrido de compras
    ])
  },
  methods: {
    showCarFilters(){
      let cart_aside = document.getElementById('cart-shopping-asside')
      if(cart_aside) return 
      let cart_global = document.getElementById('cart-shoppng-fixed-global')
      if(cart_global) cart_global.classList.toggle('cart-shoppng-fixed-global-hidden')
    }
  },
}
</script>

<style lang="sass">
.btn-cart-state
  align-items: center
  border-radius: 50%
  border: solid 2px white
  bottom: 15px
  box-shadow: 0 0 10px rgba(#000,.7)
  display: flex
  justify-content: center
  font-size: 30px
  height: 50px
  right: 15px
  position: fixed
  transition: all ease .5s
  width: 50px
  z-index: 100
  &:hover
    border: solid 2px #17a2b8
  .cart-items-count
    align-items: center
    border-radius: 50%
    display: flex
    font-size: 10px
    height: 20px
    justify-content: center
    position: absolute
    right: -5px
    top: -5px
    width: 20px
  @media screen and(min-width:1024px)
    bottom: auto
    position: relative
    transform: none
    right: auto
</style>