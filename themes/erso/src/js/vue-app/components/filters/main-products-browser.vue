<template lang="pug">
  .main-products-browser#list-products-finded.pt-5(v-show="this.get_list_products.data && this.get_list_products.data.length > 0")
    .container
      .d-flex.justify-content-between.align-items-center
        h5.text-dark.text-center.m-0.p-0.align-items-center Resultados #[small.small total: {{ get_list_products.total }}]
        button.btn.btn-close-product-browser.bg-yellow(@click.prevent="clearProducts")
          i.oi.oi-x
      hr.border-dark
      .container
        .row
          productItemBrowser.col-md-6.col-lg-3.mb-3(v-for="(product, i) in get_list_products.data" :key="i" :product="product" v-if="year_filter == 'all' ? true : product.product_year == year_filter")
    cartShoppingAsside

    nav.paginator-browser.py-5
      ul.pagination.justify-content-center
        li.page-item(v-if="get_list_products.prev_page_url != null")
          a.page-link(href="#" @click.prevent="goToPage(get_list_products.prev_page_url)")
            .oi.oi-caret-left
        li.page-item(v-for="page in get_list_products.last_page" :key="page" :class="get_list_products.current_page == page ? 'active' : '' ")
          a.page-link(href="#" @click.prevent="goToPage(get_list_products.path ,page)") {{ page }}
        li.page-item(v-if="get_list_products.next_page_url != null")
          a.page-link(href="#" @click.prevent="goToPage(get_list_products.next_page_url)")
            .oi.oi-caret-right
            
</template>

<script>
import productItemBrowser from './../cart/product-item-browser'
import cartShoppingAsside from '../cart/cart-shopping-asside'
import { mapGetters, mapActions } from 'vuex'
export default {
  components: {
    productItemBrowser,
    cartShoppingAsside
  },
  watch: {
    get_list_products: {
      handler: (oldData, newData) =>{
        if(newData.length > 0) 
        window.location.href = '#list-products-finded'
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
      'get_list_products', //lista de prodctos con paginado
    ])
  },
  methods: {
    ...mapActions([
      'clearProducts', //limpiar listado de productos
      'serachProductModelShipowner' //get products filtered
    ]),
    goToPage(path, page){
      if(page){
        this.serachProductModelShipowner({url: path + '?page=' + page})
      }else{
        this.serachProductModelShipowner({url: path})
      }
    }
  },
  mounted(){
    // if(performance.navigation.type == performance.navigation.TYPE_RELOAD) this.clearProducts()
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