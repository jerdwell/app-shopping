<template lang="pug">
div
  CartButtonState.account-cart
  menu.menu-account(:class="!$parent.menu_active ? 'menu-account-disabled' : null")
    ul
      li
        a.text-dark(href="#" @click.prevent="$parent.view = 'my-account'") #[.fas.fa-user.mr-2] Mi cuenta
      li
        a.text-dark(href="#" @click.prevent="$parent.view = 'quotations'") #[.fas.fa-file-alt.mr-2] Mis cotizaciones
      li
        a.text-dark(href="/cotizador-erso") #[.fas.fa-box-open.mr-2] Cotizar
      li
        a.text-dark(href="#" @click.prevent="sign_out") #[.fas.fa-sign-out-alt.mr-2] Cerrar sesión
      li.d-none.d-lg-inline-block
        span.text-light | #[small {{ get_name }}]
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import CartButtonState from '../cart/cart-button-state'
export default {
  name: 'menu-account',
  components: {
    CartButtonState
  },
  computed: {
    ...mapGetters([
      'get_name', //get username
    ])
  },
  methods: {
    ...mapActions([
      'signOut', //signout
    ]),
    async sign_out(){
      try {
        let signout = await this.$swal('Cierre de sesión', 'Tu sesión se ha eliminado exitosamente.', 'success')
        this.signOut()
        window.location.assign('/')
      } catch (error) {
        console.log(error)
      }
    }
  },
}
</script>

<style lang="sass">
.menu-account
  background: rgba(220, 220, 220, 1)
  border-radius: 0 0 30px 30px
  boxshadow: 0 5px 5px rgba(0, 0, 0, .5)
  left: 50%  
  margin: 0
  padding: 50px 10%
  position: fixed
  top: 66px
  transform: translateX(-50%)
  transition: all ease .2s
  width: 100%
  z-index: 999
  ul
    margin: 0
    padding: 0
    li
      border-bottom: solid 1px rgba(#000, .5)
      list-style: none
      padding: 10px 0px
      &:last-child
        border-bottom: none
  @media screen and(min-width: 768px)
    background: transparent
    left: auto
    padding: 0
    right: 5%
    transform: translateX(0)
    top: 20px!important
    width: auto
    z-index: 1000
    ul
      test-align: right
      li
        border-bottom: none
        display: inline-block
        padding: 0 10px
        width: auto
        a
          color: white!important
          &:hover,&:focus
            color: white!important
            text-decoration: none
  @media screen and(min-width: 1024px)
    margin-right: 5%
  @media screen and(min-width: 1440px)
    right: 15%

.menu-account-disabled
  top: -100%
  @media screen and(min-width: 768px)
    top: auto

.account-cart
  bottom: 30px
  right: 30px
  position: fixed!important
  z-index: 999
  @media screen and(min-width:1024px)
    top: 10px
    right: 5%
    z-index: 1001
  @media screen and(min-width:1440px)
    right: 15%
</style>