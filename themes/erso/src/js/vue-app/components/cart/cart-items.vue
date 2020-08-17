<template lang="pug">
  div
    h4.text-center.text-muted Mis productos
    hr
    div(v-if="get_cart_items.length <= 0" )
      h5.text-info.text-center No tienes elementos agregados a la cotización
    div(v-else)
      .row(v-for="(product, index) in get_cart_items" :key="product.id")
        .col-4
          img.w-100(:src="`/storage/app/media${product.product_cover}`")
        .col-8
          h6.d-block.text-info {{ product.product_name }}
          span.d-block.small.text-muted Código: {{ product.provider_code }}
          span.d-block.small.text-muted Auto: {{ product.model }}
          span.d-block.small.text-muted Categoría: {{ product.category_name }}
          h6.d-block.text-dark.my-2
            span.align-middle Cantidad: {{ product.quantity }}
            div.d-inline-block.align-middle
              button.p-1.btn.btn-sm.bg-transparent.border-0.oi.oi-minus.text-danger(@click.prevent="remove_cart_item(product.id)")
              button.p-1.btn.btn-sm.bg-transparent.border-0.oi.oi-plus.text-info(@click.prevent="add_cart_item(product)")
          h6.d-block.lead.text-primary.small Precio: {{ product.public_price != null ? '$' + product.public_price : 'no hay dato' }}
        .col-12
          hr
      .text-center
        button.btn.btn-info(@click.prevent="sendOrder()")
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
  computed: {
    ...mapGetters([
      'get_cart_items', //get list products in cart buy
      'get_token', //check if token user exists
    ])
  },
  methods: {
    ...mapActions([
      'add_cart_item', //add item to cart
      'remove_cart_item', //remove item to cart
    ]),
    async sendOrder(){
      if(this.get_token != ''){
        try {
          let send_order = await this.$swal({
            title: 'Envío de orden',
            text: 'Tu órden se ha enviado con éxito.',
            icon: 'success',
            buttons: false,
          })
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
</style>