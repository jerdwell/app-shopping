<template lang="pug">
.navbar-filters
  .controll-filters
    button.button-filters(v-show="!searchProduct" @click="searchProduct = true")
      span Buscar productos
      span.oi.oi-magnifying-glass.icon-button-filter
    button.button-filters(v-show="searchProduct" @click="searchProduct = false")
      span.text-yellow.mr-2 Cancelar búsqueda
      span.oi.oi-x.icon-button-filter.text-yellow.border-yellow

  .filters.bg-dark(:class="!searchProduct ? 'filters-inactive' : ''")
    SelectTypeFilters
    FilterByCar(v-if="type_filter == 'car'")
    GeneralFilter(v-if="type_filter == 'general'")
      
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import MainProductsBrowser from './main-products-browser'
import SelectTypeFilters from './select-type-filters'
import FilterByCar from './filter-by-car'
import GeneralFilter from './general-filter'
import Codefilter from './code-filter'
export default {
  components: {
    FilterByCar,
    MainProductsBrowser,
    SelectTypeFilters,
    GeneralFilter,
    Codefilter,
  },
  data(){
    return {
      searchProduct: false,
      loading: false,
      type_filter: '',
    }
  },
  computed: {
    ...mapGetters([
      'getListProducts' //lista de productos encontrados
    ])
  },
  methods: {
    ...mapActions([
      'searchProducts' //Buscador de productos
    ]),
    searchData(){
      this.loading = true
      let search_products = this.searchProducts({
        type: 'general',
        data: 'prod',
        limit: 20
      }).then( res => this.loading = false )
      this.searchProduct = false
      document.querySelector('.icon-menu-navbar-erso').click()
      document.body.style.overflow = 'auto'
    }
  },
}
</script>

<style lang="sass" scoped>
.navbar-filters
  .filters-inactive
    padding: 0!important
    height: 0!important
  .filters
    height: auto
    color: #ffffff
    overflow: hidden
    padding: 30px 0
    transition: all ease .5s
    z-index: -3

  .controll-filters
    .button-filters
      align-items: center
      background: transparent
      display: inline-flex
      border: none
      color: white
      justify-content: flex-end
      flex-direction: row-reverse
      width: 100%
      .icon-button-filter
        align-items: center
        border-radius: 50%
        border: solid 2px white
        display: inline-flex
        justify-content: center
        height: 40px
        margin-right: 10px
        width: 40px

  @media screen and (min-width: 768px)
    .controll-filters
      .button-filters
        margin-left: auto
        margin-bottom: 20px
        margin-right: 0
        flex-direction: row
        justify-content: flex-end
        .icon-button-filter
          margin-left: 10px
          margin-right: 0
  
  @media screen and (min-width: 1024px)
    .filters
      left: 0
      padding-top: 140px
      position: fixed
      top: 0
      height: 100vh
      overflow: auto!important
      width: 100%
    .controll-filters
      .button-filters
        span
          &:first-child
            text-align: right
        margin-bottom: 0
  @media screen and (min-width: 1280px)
    .controll-filters
      .button-filters

</style>