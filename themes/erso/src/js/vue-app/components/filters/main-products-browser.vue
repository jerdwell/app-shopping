<template lang="pug">
  .main-products-browser.bg-dark(:class="this.getListProducts.length <= 0 ? 'main-products-browser-inactive' : '' ")

    .container
      h3.text-light.text-center
        .d-flex.justify-content-between
          span Resultados
          button.btn.btn-warning.btn-close-product-browser(@click="clearProducts")
            i.oi.oi-x
      hr.border-light

    .container
      .row.mb-4
        .col-md-6.col-lg-4
          label.text-light Resultados por página
          select.form-control.rounded-pill(v-model="perPage")
            option(value="") Selecciona una opción
            option(value="50") 50 resultados
            option(value="100") 100 resultados
            option(value="200") 200 resultados
            option(value="500") 500 resultados
      
      //product item
      .row
        productItemBrowser.col-6.col-md-4.mb-3.border-bottom.border-light(v-for="(product, i) in getListProducts.data" :key="i" :product="product")
      
      nav.paginator-browser.mt-3
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
        'getListProducts' //lista de prodctos con paginado
      ]
    )
  },
  methods: {
    ...mapActions([
      'clearProducts' //limpiar listado de productos
    ]),
    scrollButton(){
      let button = document.querySelector('.btn-close-product-browser')
      let browser = document.querySelector('.main-products-browser')
      let srcoll
      browser.onscroll = () => {
        scroll = browser.scrollTop
        if(scroll > 200){
          if (!button.classList.contains('btn-close-product-browser-fixed')) button.classList.add('btn-close-product-browser-fixed')
        }else if(scroll == 0){
          button.classList.remove('btn-close-product-browser-fixed')
        }
      }
    }
  }
}
</script>

<style lang="sass" scoped>
.main-products-browser
  left: 0
  height: 100vh
  overflow: hidden
  overflow-y: auto!important
  padding-top: 150px
  position: fixed
  top: 0
  transition: all ease .5s
  width: 100%
  z-index: 999
  .paginator-browser
    margin-bottom: 100px

.main-products-browser-inactive
  top: -200%
  @media screen and (min-width: 1024px)
    display: none


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

.btn-close-product-browser-fixed
  bottom: 30px
  box-shadow: 0 0 10px rgba(#000, .7)
  height: 60px
  position: fixed
  right: 30px
  width: 60px
  z-index: 1000

</style>