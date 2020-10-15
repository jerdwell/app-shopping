<template lang="pug">
  .text-center.mt-2(v-if="get_branch_selected")
    small.d-block.text-muted.mb-2.small Cotizar
    .row
      .col-8
        .input-group.input-group-sm
          input.form-control.form-control-sm.text-right(type="text" disabled :value="find_item_in_cart(product.id)")
          .input-group-prepend
            .input-group-text pz
      .col-4.text-left.px-0
        button.btn.btn-danger.btn-sm.bg-transparent.text-danger.mr-1.rounded-circle(
          @click.prevent="remove_cart_item(product.id)"
          :disabled="find_item_in_cart(product.id) == 0")
          i.oi.oi-minus
        button.btn.btn-info.btn-sm.bg-transparent.text-info.rounded-circle(@click.prevent="addProduct(product)")
          i.oi.oi-plus
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'product-handler',
  props: [
    'product'
  ],
  computed: {
    ...mapGetters([
      'find_item_in_cart', //check if product exists in cart shopping
      'get_branch_selected', //Check if has a branch selected
    ])
  },
  methods: {
    
    ...mapActions([
      'add_cart_item', //add item to cart shopping or quotation
      'remove_cart_item', //remove item to cart shopping or quotation
    ]),

    async addProduct(product){
      await this.add_cart_item(product)
      let carButton = document.getElementById('car-state-button')
      let cart = document.getElementById('cart-shoppng-fixed-global')
      if(carButton){
        if(cart && cart.classList.contains('cart-shoppng-fixed-global-hidden')) carButton.click()
      }
    }

  },
}
</script>