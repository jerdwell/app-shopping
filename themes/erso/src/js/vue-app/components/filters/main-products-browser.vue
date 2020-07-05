<template lang="pug">
  .main-products-browser.bg-dark(:class="this.getlistProducts.length >= 0 ? 'main-products-browser-inactive' : '' ")
    h3.text-light.text-center Resultados
    .container
      .row
        .col-md-6.col-lg-4
          label.text-light Resultados por página
          select.form-control.rounded-pill(v-model="perPage")
            option(value="") Selecciona una opción(ahora 20)
            option(value="50") 50 resultados
            option(value="100") 100 resultados
            option(value="200") 200 resultados
            option(value="500") 500 resultados
      hr.border-light.mb-4

      .row
        .col-6.col-md-4.mb-3.border-bottom.border-light(v-for="product in getlistProducts.data")
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
                button.btn.btn-info.btn-sm.mt-2
                  i.oi.oi-cart
                  span.ml-3.pl-3.border-left.border-light Cotizar
      nav.my-5
        ul.pagination.justify-content-center
          li.page-item(v-if="getlistProducts.prev_page_url != null")
            a.page-link(href="#") 
              .oi.oi-caret-left
          li.page-item(v-for="page in getlistProducts.last_page" :key="page" :class="getlistProducts.current_page == page ? 'active' : '' ")
            a.page-link(href="#") {{ page }}
          li.page-item(v-if="getlistProducts.next_page_url != null")
            a.page-link(href="#")
              .oi.oi-caret-right
            
</template>

<script>
import { mapGetters } from 'vuex'
export default {
  data(){
    return {
      perPage: ''
    }
  },
  computed: {
    ...mapGetters(
      [ 'getlistProducts' ] //lista de prodctos con paginado
    )
  },
  mounted(){ }
}
</script>

<style lang="sass">
.main-products-browser
  left: 0
  height: 100vh
  padding-top: 120px
  position: fixed
  overflow: hidden
  overflow-y: auto!important
  top: 0
  transition: all ease .5s
  width: 100%
  z-index: 999
.main-products-browser-inactive
  top: -200%
</style>