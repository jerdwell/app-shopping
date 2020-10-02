<template lang="pug">
li.main-menu-item
  a.text-light.main-menu-item-link(href="/login" v-if="!get_token")
    span Registro/Login
  a.text-light.main-menu-item-link(href="/mi-cuenta" v-else)
    span Mi Cuenta
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'button-account-register',
  computed: {
    ...mapGetters([
      'get_token'
    ])
  },
}
</script>