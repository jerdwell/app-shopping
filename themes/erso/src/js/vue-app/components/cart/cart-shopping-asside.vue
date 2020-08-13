<template lang="pug">
.cart-shopping-asside.cart-shopping-asside-hidden#cart-shopping-asside
  .close-shopping-cart-button.border-secondary(@click.prevent="toggleCart")
    .oi.oi-fullscreen-exit.text-secondary
  cartItems

</template>

<script>
import cartItems from './cart-items'
export default {
  name: 'cart-shopping-asside',
  components: {
    cartItems
  },
  methods: {
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