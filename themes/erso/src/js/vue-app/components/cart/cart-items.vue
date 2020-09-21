<template lang="pug">
  div
    h4.text-center.text-muted Mis productos
    h6.text-center
      span.text-muted Total de la cotización
      br
      big ${{ get_total_amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
    hr
    div(v-if="get_cart_items.length <= 0" )
      h5.text-info.text-center No tienes elementos agregados a la cotización
    div(v-else)
      .table-responsive
        table.table.table-striped
          thead
            tr.bg-dark
              th #
              th.text-yellow.text-center Producto
              th.text-yellow.text-center Costo
          tbody
            tr(v-for="(product, index) in get_cart_items" :key="product.id")
              td.text-center.text-dark {{ index +1 }}
              td.text-center.text-dark
                span.small {{ product.product_name }}
                br
                small #[b {{ product.provider_code }}]
                .w-100.d-inline-block.align-middle
                  button.cart-button-handler.p-1.btn.btn-sm.bg-transparent.fas.fa-minus.text-danger.border-danger(@click.prevent="remove_cart_item(product.id)")
                  span.align-middle.mx-2 {{ product.quantity }}
                  button.cart-button-handler.p-1.btn.btn-sm.bg-transparent.fas.fa-plus.text-info.border-info(@click.prevent="add_cart_item(product)")
                .text-center
                  a.small.text-danger(href="#" @click.prevent="delete_cart_item(product)") Eliminar #[.fas.fa-times]
              td.text-center.text-dark
                span.small {{ product.public_price != null ? '$' + product.public_price : 'sin dato' }}
      .text-center
        div(v-if="get_token")
          .py-2
            label.small.text-muted Selecciona una fecha de entrega
            .input-group
              .input-group-prepend
                .input-group-text
                  i.fas.fa-calendar-alt
              datePicker.form-control.p-0.m-0.border-0(
                v-model="shipping_date"
                :full-month-name="true"
                calendar-class="position-static w-100"
                input-class="form-control"
              )
          button.btn.btn-info(@click.prevent="sendOrder()" v-if="shipping_date")
            .oi.oi-check.mr-2
            span Solicitar pedido
        button.btn.btn-sm.btn-dark.my-2
          .oi.oi-data-transfer-download.mr-2
          span Descargar cotización
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'cart-items',
  data() {
    return {
      shipping_date: null
    }
  },
  computed: {
    ...mapGetters([
      'get_cart_items', //get list products in cart buy
      'get_token', //check if token user exists
      'get_total_amount', //get total amont
    ])
  },
  methods: {
    ...mapActions([
      'add_cart_item', //add item to cart
      'remove_cart_item', //remove item to cart
      'delete_cart_item', //delete item to cart
      'create_quotation', //create quotation
      'clear_cart_data', //clear cart data
    ]),
    async sendOrder(){
      if(this.get_token != ''){
        try {
          let create = await this.create_quotation({shipping_date: this.shipping_date})
          let send_order = await this.$swal({
            title: 'Envío de orden',
            text: 'Tu órden se ha enviado con éxito, revisa tu cuenta para poder visualizar tu pedido',
            icon: 'success',
            buttons: false,
          })
          this.clear_cart_data()
        } catch (error) {
          let send_order = await this.$swal({
            title: 'Envío de orden',
            text: error,
            icon: 'error',
            buttons: false,
          })
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
.swal-button--confirm
  background: #17a2b8!important
  background-color: #17a2b8!important
.cart-button-handler
  border-radius: 50%
  border: solid 1px
  vertical-align: middle
</style>