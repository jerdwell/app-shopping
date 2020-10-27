<template lang="pug">
  .main-products-browser#list-products-finded.pt-5
    .container-fluid
      .row
        .col-xl-9
          .container(v-if="get_list_products.data")
            div(v-if="get_list_products.data.length > 0")
              .container
                .row
                  .col-md-6.col-lg-4.mb-3(v-for="(product, i) in get_list_products.data" :key="i" v-if="year_filter == 'all' ? true : product.product_year == year_filter")
                    productItemBrowser(:product="product")
            .card(v-else)
              .card-body
                h4.text-muted.text-center Lo sentimos, no existen resultados relacionados

          .container.py-5(v-else)
            .card
              .card-body
                h4.text-muted.text-center Por favor usa los filtros para encontrar tus productos
        
        .col-xl-3
          cartShoppingAsside

    nav.paginator-browser.py-5(v-if="get_list_products.last_page && get_list_products.last_page <= 10")
      ul.pagination.justify-content-center
        li.page-item(v-if="get_list_products.prev_page_url != null")
          a.page-link(href="#" @click.prevent="goToPage(get_list_products.prev_page_url)")
            .fas.fa-caret-left
        li.page-item(v-for="page in get_list_products.last_page" :key="page" :class="get_list_products.current_page == page ? 'active' : '' ")
          a.page-link(href="#" @click.prevent="goToPage(get_list_products.path ,page)") {{ page }}
        li.page-item(v-if="get_list_products.next_page_url != null")
          a.page-link(href="#" @click.prevent="goToPage(get_list_products.next_page_url)")
            .fas.fa-caret-right
    
    .container.my-5(v-if="get_list_products.last_page && get_list_products.last_page >= 10")
      .row
        .col-md-6.col-lg-4.col-xl-3
          label Página:
          select.form-control(@change="goToPage(get_list_products.path, page_selected)" v-model="page_selected")
            option(value="") Selecciona una página
            option(v-for="page in get_list_products.last_page" :key="page" :value="page") {{ page }}
            
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
      year_filter: 'all',
      page_selected: 1
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
      'serachProductModel' //get products filtered
    ]),
    async goToPage(path, page){
      if(page){
        // let filters = document.getElementById('filter-products')
        let list_products = await this.serachProductModel({url: path + '?page=' + page})
      }else{
        let list_products = await this.serachProductModel({url: path})
      }
      window.scrollTo({top: 0, left: 0, behavior: 'smooth'})
    }
  },
  mounted(){
    if(performance.navigation.type == performance.navigation.TYPE_RELOAD) this.clearProducts()
  }
}
</script>

<style lang="sass" scoped>
.main-products-browser
  background: white
  background-image: url('/storage/app/media/footer_02.png')
  background-size: 100% auto
  background-position: left bottom
  background-attachment: fixed
  background-repeat: no-repeat
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