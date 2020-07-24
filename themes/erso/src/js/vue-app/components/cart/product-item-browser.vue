<template lang="pug">
  .card-body
    .row
      .col-4.col-md-4.p-0
        a.link.text-info.mb-4(:href="`/products/product/${product.product_slug}`")
          img.w-100(:src="'http://www.erso.com.mx/storage/app/media/' + product.product_cover")
      .col-8.col-md-8.p-0.pl-2
        a.link.text-info.mb-4(:href="`/products/product/${product.product_slug}`" style="text-decoration:none;")
          span.h6.text-yellow {{ product.product_name }}
        p.mb-0.small
          b.text-info Aplicación
          br
          small.text-light {{ product.product_description }}
          br
          small.text-light {{ product.product_year }}
        button.btn.btn-info.btn-sm.mt-4(@click="showPop = true")
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