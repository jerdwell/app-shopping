<template lang="pug">
div(v-if="get_token != ''")
  NavbarAccount
  MenuAccount
  .content-account
    MyDataAccount(v-if="view == 'my-account'")

</template>

<script>
import { mapGetters } from 'vuex'
import NavbarAccount from './navbar-account'
import MenuAccount from './menu-account'
import MyDataAccount from './data-account/my-data-account'
export default {
  name: 'my-account',
  components: {
    NavbarAccount,
    MenuAccount,
    MyDataAccount
  },
  watch: {
    get_token: (newData, oldData) => {
      if(newData == '') window.location.href = '/login'
    }
  },
  data() {
    return {
      menu_active: false,
      view: 'my-account'
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
  padding-top: 100px
  padding-bottom: 100px
</style>