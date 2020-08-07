<template lang="pug">
  .card-body
    .row.bg-light.rounded-sm
      .col-4.col-md-4.p-2
        a.link.text-info.mb-4(:href="`/products/product/${product.product_slug}`")
          img.w-100(:src="'http://www.erso.com.mx/storage/app/media/' + product.product_cover")
      .col-8.col-md-8.p-0.pl-2
        a.link.text-info.mb-4(:href="`/products/product/${product.product_slug}`" style="text-decoration:none;")
          span.h6.text-info {{ product.product_name }}
        p.mb-0.small
          span.text-muted Aplicación: {{ product.product_description }}
          br
          span.text-muted Año: {{ product.product_year }}
          br
          span.text-muted Auto: {{ product.shipowner.shipowner_name }} - {{ product.car.model_name }}
          br
          span.text-muted Código: {{ product.provider_code }}
          br
          b.text-info.mb-0.pb-0.lead {{ product.public_price != null ? '$' + product.public_price : 'Precio no disponible' }}
    
    PopProductCart(:productData="product" v-if="showPop")

</template>

<script>
import PopProductCart from './pop-product-detail'
export default {
  components: {
    PopProductCart
  },
  data() {},
  props: [
    'product'
  ],
  methods: { },
  

}
</script>