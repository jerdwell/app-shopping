<template lang="pug">
.row
  .col-md-4
    label.text-light Buscar Producto
    input.form-control(type="search")
    button.btn.btn-info(@click.prevent="searchProducts") Buscar
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'general-filter',
  methods: {
    ...mapActions([
      'searchProducts',
    ])
  }
}
</script>