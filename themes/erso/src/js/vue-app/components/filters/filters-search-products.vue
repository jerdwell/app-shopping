<template lang="pug">
section.filters-search-products.bg-dark#filter-products
  .filters
    SelectTypeFilters
    div(v-if="get_branch_selected != ''")
      FilterByCar(v-if="type_filter == 'car'")
      FilterByShipowner(v-if="type_filter == 'shipowner'")
      GeneralFilter(v-if="type_filter == 'general'")
      FilterByCode(v-if="type_filter == 'code'")
      
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import MainProductsBrowser from './main-products-browser'
import SelectTypeFilters from './select-type-filters'
import FilterByCar from './filter-by-car'
import FilterByShipowner from './filter-by-shipowner'
import FilterByCode from './filter-by-code'
import GeneralFilter from './general-filter'
import Codefilter from './code-filter'
export default {
  name: 'filters-search-products',
  components: {
    FilterByCar,
    FilterByCode,
    MainProductsBrowser,
    SelectTypeFilters,
    GeneralFilter,
    Codefilter,
    FilterByShipowner
  },
  data(){
    return {
      loading: false,
      type_filter: 'car',
    }
  },
  computed: {
    ...mapGetters([
      'get_list_products', //lista de productos encontrados
      'get_show_filters', //obtener parametro para mostrar los filtros
      'get_branch_selected',//get branch selected
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
.filters-search-products
  padding: 80px 5% 20px
  left: 0
  top: 0
  width: 100%
  @media screen and( min-width: 768px)
    padding-top: 150px

</style>