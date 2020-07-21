<template lang="pug">
  .card-body
    .row
      .col-lg-4.p-0
        img.w-100(:src="product.product_cover.path")
      .col-lg-8.p-0.pl-md-2
        h5.text-yellow {{ product.product_name }}
        p.mb-0
          b.text-info Aplicación
          br
          small.text-light {{ product.product_description }}
        a.link.text-info.mb-4(:href="`/products/product/${product.product_slug}`")
          small Ver más
        br
        button.btn.btn-info.btn-sm.mt-2(@click="showPop = true")
          i.oi.oi-cart
          span.ml-3.pl-3.border-left.border-light Agregar
    
    PopProductCart(:productData="product" v-if="showPop")

</template>

<script>
import PopProductCart from './pop-product-detail'
export default {
  components: {
    PopProductCart
  },
  data() {
    return {
      showPop: false,
    }
  },
  props: [
    'product'
  ],
  methods: { },
  

}
</script>