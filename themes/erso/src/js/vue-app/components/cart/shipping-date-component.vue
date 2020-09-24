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
          calendar-class="sipping-date-calendar w-100",
          :disabled-dates="disabledDates",
          input-class="form-control")
    button.btn.btn-info(
      @click.prevent="sendOrder()"
      v-if="shipping_date"
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
    ]),
    disabledDates() {
      this.$moment.locale();
      return {
        to: new Date(this.$moment()),
        from: new Date(this.$moment().add('2', 'week')),
        days: [6, 0],
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
            title: 'Envío de orden',
            text: 'Tu órden se ha enviado con éxito, revisa tu cuenta para poder visualizar tu pedido',
            icon: 'success',
            buttons: false,
          })
          this.clear_cart_data()
          this.loading = false
        } catch (error) {
          let send_order = await this.$swal({
            title: 'Envío de orden',
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
  },
}
</script>

<style lang="sass">
  .sipping-date-calendar
    bottom: 100%
    top: auto
</style>