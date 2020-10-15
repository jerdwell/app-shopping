<template lang="pug">
.cart-shopping-asside.cart-shopping-asside-hidden#cart-shopping-asside
  //- .close-shopping-cart-button.border-secondary(@click.prevent="toggleCart")
    .oi.oi-fullscreen-exit.text-secondary
  .text-center.bg-dark.pb-1.cart-shopping-asside-heading
      h4.text-center.text-light Mis productos
      h6.text-center
        span.text-light Total de la cotización
        br
        big.text-info ${{ get_total_amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
  cartItems(:heading="true")
  .bg-dark.p-3.cart-shopping-asside-footer(v-if="get_cart_items.length > 0")
    shippingDateComponent

</template>

<script>
import { mapGetters } from 'vuex'
import cartItems from './cart-items'
import shippingDateComponent from './shipping-date-component'
export default {
  name: 'cart-shopping-asside',
  components: {
    cartItems,
    shippingDateComponent
  },
  computed: {
    ...mapGetters([
      'get_total_amount', //get tootal amount quotation
      'get_cart_items', //get cart items
    ])
  },
  methods: {
    toggleCart(){
      let item = document.getElementById('cart-shopping-asside')
      if(item) item.classList.toggle('cart-shopping-asside-hidden')
    },
    fixedCar(){
      window.scrollTo(0,0)
      let cart = document.getElementById('cart-shopping-asside')
      let h = cart.offsetHeight
      let position = cart.getBoundingClientRect()
      let class_fixed = 'cart-shopping-asside-fixed'
      window.onscroll = () => {
        if(window.scrollY > (position.top + h)){
          if(!cart.classList.contains(class_fixed)){
            cart.classList.add(class_fixed)
          }
        }else{
          console.log('quitar');
          if(cart.classList.contains(class_fixed)){
            cart.classList.remove(class_fixed)
          }
        }
      }
    }
  },
  mounted() {
    this.fixedCar()
  },
}
</script>

<style lang="sass" scoped>
.cart-shopping-asside
  // display: none
  background: #f1f1ff
  bottom: 20px
  border-radius: 5px
  box-shadow: 0 0 10px rgba(0,0,0, .7)
  max-height: 80vh!important
  max-width: 300px
  overflow-y: auto
  position: fixed
  transition: all ease .5s
  right: 20px
  width: 90%
  z-index: 10
  .cart-shopping-asside-heading, .cart-shopping-asside-footer
    left: 0
    position: sticky
    top: 0
  .cart-shopping-asside-footer
    bottom: 0
    top: auto
  @media screen and (min-width: 1280px)
    display: block
    border-radius: 0
    box-shadow: none
    position: static
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
    // display: none

.cart-shopping-asside-hidden
  @media screen and (max-width:1279px)
    padding: 0
    height: 100px
    width: 0

.cart-shopping-asside-fixed
  box-shadow: -10px 5px 15px rgba(#000,.8)
  border-radius: 30px
  right: 0px
  height: 70%
  position: fixed
  top: 50%
  transform: translateY(-50%)
  z-index: 999

</style>