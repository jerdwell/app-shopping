<template lang="pug">
  #cart-shoppng-fixed-global.cart-shoppng-fixed-global.cart-shoppng-fixed-global-hidden(v-if="!get_show_filters && get_cart_items.length > 0")
    .cart-items
      cartItems
</template>
<script>
import cartItems from './cart-items'
import { mapGetters } from 'vuex'
export default {
  name: 'cart-fixed-global',
  computed: {
    ...mapGetters([
      'get_show_filters', //get if show filters home
      'get_cart_items', //get cart items
    ])
  },
  components:{
    cartItems
  }
}
</script>

<style lang="sass">
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
  padding: 20px
  right: 15px
  transition: all ease .5s
  width: 90%
  z-index: 100
.cart-shoppng-fixed-global-hidden
  height: 0
  padding: 0
  width: 0
</style>