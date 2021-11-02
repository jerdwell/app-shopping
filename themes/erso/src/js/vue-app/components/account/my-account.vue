<template lang="pug">
div(v-if="get_token != ''")
  NavbarAccount
  MenuAccount
  .header-account
  .content-account
    MyDataAccount(v-if="view == 'my-account'")
    Quotations(v-else="view == 'quotations'")

</template>

<script>
import { mapGetters } from 'vuex'
import NavbarAccount from './navbar-account'
import MenuAccount from './menu-account'
import MyDataAccount from './data-account/my-data-account'
import Quotations from '../account/data-quotation/quotations'
export default {
  name: 'my-account',
  components: {
    NavbarAccount,
    MenuAccount,
    MyDataAccount,
    Quotations
  },
  watch: {
    get_token: (newData, oldData) => {
      if(newData == '') window.location.href = '/login'
    }
  },
  data() {
    return {
      menu_active: false,
      view: 'quotations'
    }
  },
  computed: {
    ...mapGetters([
      'get_token', //get token
    ])
  },
  beforeMount(){
    if(this.get_token == '') window.location.href = '/login'
  }
}
</script>

<style lang="sass">
.content-account
  margin-bottom: 80px
  margin-top: -100px
  padding-bottom: 100px
  .card
    box-shadow: 0 10px 15px rgba(0,0,0,.5)
.header-account
  background-image: url('/storage/app/media/steps1.jpg')
  background-size: cover
  background-attachment: fixed
  background-position: center
  margin-top: 50px
  height: 250px
  width: 100%
  @media screen and(min-width: 1024px)
    height: 350px
</style>