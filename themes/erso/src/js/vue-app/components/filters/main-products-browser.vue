<template lang="pug">
  .main-products-browser.bg-dark#list-products-finded(v-show="this.getListProducts.data && this.getListProducts.data.length > 0")
    .container
      .d-flex.justify-content-between
        h3.text-light.text-center Resultados
        button.btn.btn-close-product-browser.bg-yellow(@click.prevent="clearProducts")
          i.oi.oi-x
      hr.border-light

      .container

        .row
          productItemBrowser.col-md-6.col-lg-4.mb-3(v-for="(product, i) in getListProducts.data" :key="i" :product="product" v-if="year_filter == 'all' ? true : product.product_year == year_filter")

    nav.paginator-browser.py-5
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
  watch: {
    getListProducts: {
      handler: (oldData, newData) =>{
        // if(newData.length > 0) 
        // window.location.href = '#list-products-finded'
      },
      deep: true
    }
  },
  data(){
    return {
      perPage: '',
      year_filter: 'all'
    }
  },
  computed: {
    ...mapGetters([
      'getListProducts', //lista de prodctos con paginado
    ])
  },
  methods: {
    ...mapActions([
      'clearProducts' //limpiar listado de productos
    ]),
  },
  mounted(){
    if(performance.navigation.type == performance.navigation.TYPE_RELOAD) this.clearProducts()
  }
}
</script>

<style lang="sass" scoped>
.main-products-browser
  transition: all ease .5s
  width: 100%

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
</style>