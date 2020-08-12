<template lang="pug">
  button.btn.btn-dark.btn-cart-state(v-show="count_cart_items > 0")
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
  }
}
</script>

<style lang="sass">
.btn-cart-state
  align-items: center
  border-radius: 50%
  border: solid 2px white
  box-shadow: 0 0 10px rgba(#000,.7)
  display: flex
  justify-content: center
  font-size: 30px
  height: 50px
  right: 55px
  position: fixed
  transition: all ease .5s
  top: 5px
  width: 50px
  z-index: 10
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
  @media screen and (min-width: 768px)
    top: calc( 110px - 75px )
    right: 80px
  @media screen and (min-width: 768px)
    position: relative
    right: auto
    top: auto


.navbar-main-erso-fixed //este estilo base está en el archivo navbar
  @media screen and (min-width: 768px)
    .btn-cart-state
      top: 10px
  @media screen and(min-width: 1024px)
    .btn-cart-state
      height: 40px
      top: auto
      width: 40px

</style>