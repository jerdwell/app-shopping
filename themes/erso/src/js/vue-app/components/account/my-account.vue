<template lang="pug">
  .container-fluid.bg-light.py-5(v-if="get_token != ''")
    .row
      .col-md-3
        h5 Menú
      .col-md-9
        h5 Contenido
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  name: 'my-account',
  watch: {
    get_token: (newData, oldData) => {
      if(newData == '') window.location.href = '/login'
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