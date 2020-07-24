<template lang="pug">
  .main-products-browser.bg-dark(:class="this.getListProducts.length <= 0 ? 'main-products-browser-inactive' : '' ")
    .container
      .d-flex.justify-content-between
        h3.text-light.text-center Resultados
        button.btn.btn-close-product-browser.bg-yellow(@click.prevent="clearProducts")
          i.oi.oi-x
      hr.border-light

      .container
        .row
          productItemBrowser.col-md-6.col-lg-4.mb-3(v-for="(product, i) in getListProducts" :key="i" :product="product")

      //- nav.paginator-browser.mt-3
        ul.pagination.justify-content-center
          li.page-item(v-if="getListProducts.prev_page_url != null")
            a.page-link(href="#") 
              .oi.oi-caret-left
          li.page-item(v-for="page in getListProducts.last_page" :key="page" :class="getListProducts.current_page == page ? 'active' : '' ")
            a.page-link(href="#") {{ page }}
          li.page-item(v-if="getListProducts.next_page_url != null")
            a.page-link(href="#")
              .oi.oi-caret-right
            
</template>

<script>
import productItemBrowser from './../cart/product-item-browser'
import { mapGetters, mapActions } from 'vuex'
export default {
  components: {
    productItemBrowser
  },
  data(){
    return {
      perPage: ''
    }
  },
  computed: {
    ...mapGetters(
      [
        'getListProducts', //lista de prodctos con paginado
      ]
    )
  },
  methods: {
    ...mapActions([
      'clearProducts' //limpiar listado de productos
    ]),
  }
}
</script>

<style lang="sass" scoped>
.main-products-browser
  left: 0
  max-height: 100vh
  overflow-y: auto
  position: fixed
  padding-top: 80px
  top: 0
  transition: all ease .5s
  width: 100%
  z-index: 999
  .paginator-browser
    margin-bottom: 100px
  @media screen and (min-width:768px)
    padding-top: 120px
  @media screen and (min-width:1024px)
    padding-top: 180px

.btn-close-product-browser
  align-items: center
  border-radius: 50%
  height: 40px
  display: inline-flex
  font-size: 20px
  justify-content: center
  margin: 0
  padding: 0
  transition: all ease .5s
  right: 0
  width: 40px
.main-products-browser-inactive
  top: -200%
</style>