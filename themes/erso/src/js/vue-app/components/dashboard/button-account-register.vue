<template lang="pug">
li.main-menu-item
  a.text-light.main-menu-item-link(href="/login" v-if="!get_token")
    span Registro/Login
  a.text-light.main-menu-item-link(href="/mi-cuenta" v-else)
    span #[.fas.fa-user] {{get_name.split(' ')[0]}}
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'button-account-register',
  computed: {
    ...mapGetters([
      'get_name',
      'get_token'
    ])
  },
}
</script>