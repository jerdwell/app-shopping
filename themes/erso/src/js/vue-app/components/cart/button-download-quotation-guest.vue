<template lang="pug">
  button.btn.btn-sm.btn-dark.my-2(@click.prevent="downLoadQuotation" v-if="get_cart_items.ength > 0")
    .spinner-border.spinner-border-sm.mr-2(v-if="loading")
    .fas.fa-download.mr-2(v-else)
    span Descargar cotización
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'shipping-date-component',
  data() {
    return {
      loading: false,
    }
  },
  computed: {
    ...mapGetters([
      'get_token', //get token user
      'get_cart_items', //get car items
    ]),
  },
  methods: {
    ...mapActions([
      'clear_cart_data', //clear cart data
      'download_quotations_guest', //download quotation without account
    ]),
    async downLoadQuotation(){
      this.loading = true
      try {
        let quotation = await this.download_quotations_guest()
        this.$swal('Creación de cotización', 'Esta cotización no será guardada en nuestro sistema, para poder realizar un pedido inicia sesión y genera un pedido.', 'warning')
        this.loading = false
      } catch (error) {
        this.loading = false
        this.$swal(
          'Descarga',
          error,
          'error'
        )
      }
    }
  },
}
</script>
