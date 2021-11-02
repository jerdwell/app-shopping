<template lang="pug">
.text-center
  div(v-if="get_branch_selected")
    buttonDownloadQuotationGuest
  div(v-if="get_token && get_branch_selected")
    .py-2
      h5.text-muted Selecciona una fecha de entrega
      .input-group
        .input-group-prepend
          .input-group-text
            i.fas.fa-calendar-alt
        datePicker.form-control.p-0.m-0.border-0(
          v-model="shipping_date",
          :full-month-name="true",
          :use-utc="true"
          calendar-class="sipping-date-calendar w-100",
          :disabled-dates="disabledDates",
          input-class="form-control")
    button.btn.btn-info(
      @click.prevent="sendOrder()"
      v-if="shipping_date && get_cart_items.length > 0"
      :disabled="loading")
      .spinner-border.spinner-border-sm.mr-2.align-middle(v-if="loading")
      .oi.oi-check.mr-2.align-middle(v-else)
      span.align-middle Solicitar pedido
  div(v-else)
    div(v-if="!get_token")
      h5.text-center.text-muted Para solicitar un pedido debes iniciar sesión.
      .text-center
        a.btn.btn-info.px-3(href="/login") Iniciar sesión
    div(v-if="!get_branch_selected")
      h5.text-center.text-muted Para descargar tu cotización selecciona una sucursal.

</template>

<script>
import buttonDownloadQuotationGuest from './button-download-quotation-guest'
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'shipping-date-component',
  components: {
    buttonDownloadQuotationGuest,
  },
  data() {
    return {
      shipping_date: null,
      loading: false
    }
  },
  computed: {
    ...mapGetters([
      'get_token', //get token user
      'get_branch_selected', //get branch selected
      'get_cart_items', //get car items
    ]),
    disabledDates() {
      this.$moment.locale();
      let day = this.$moment().format('dddd')
      let max_time = day != 'Sunday' ? this.$moment('17:30', 'h:mma') : this.$moment('15:30', 'h:mma')
      let date_compared = this.$moment().isBefore(max_time) ? this.$moment().format('YYYY-MM-DD') : this.$moment().add('1', 'day').format('YYYY-MM-DD')
      let min_shipping_date = new Date(date_compared)
      return {
        to: min_shipping_date,
        from: new Date(this.$moment().add('1', 'week')),
        days: [7, 0],
      }
    }
  },
  methods: {
    ...mapActions([
      'create_quotation', //create quotation
      'clear_cart_data', //clear cart data
    ]),
    async sendOrder(){
      if(this.get_token != ''){
        this.loading = true
        try {
          let create = await this.create_quotation({shipping_date: this.shipping_date})
          let send_order = await this.$swal({
            title: 'Solicitud de pedido',
            text: 'Tu pedido se ha solicitado con éxito, revisa tu cuenta para poder descargar la información tu pedido.',
            icon: 'success',
            buttons: false,
          })
          this.loading = false
          this.shipping_date = null
          this.clear_cart_data()
        } catch (error) {
          let send_order = await this.$swal({
            title: 'Solicitud de pedido',
            text: error,
            icon: 'error',
            buttons: false,
          })
          this.loading = false
        }
      }else{
        let errors = this.$swal({
          title: 'Envío de orden',
          text: 'Para solicitar un pedido necesitar iniciar sesión.',
          icon: 'warning',
          buttons: ['cancelar', 'Ingresar'],
          dangerMode: false
        }).then(res => {
          if(res) window.location.href = '/ingresar'
        })
      }
    }
  }
}
</script>

<style lang="sass">
  .sipping-date-calendar
    bottom: 100%
    top: auto
</style>