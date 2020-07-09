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
    .row
      .col-md-6
        .row
          label.col-12.text-center Buscar por:
          label.col-4.col-md-4.p-2.text-center
            input.form-check-input(type="radio" name="typeSearch" value="car" v-model="typeSearch")
            span.b-block Auto
          label.col-4.col-md-4.p-2.text-center
            input.form-check-input(type="radio" name="typeSearch" value="brand" v-model="typeSearch")
            span.b-block Marca
          label.col-4.col-md-4.p-2.text-center
            input.form-check-input(type="radio" name="typeSearch" value="general" v-model="typeSearch")
            span.b-block General

      .col-md-6(v-if="typeSearch != ''")
        .row
          .col-md-10.offset-md-2
            .search-item(v-if="typeSearch == 'car'")
              label.text-muted.text-md-right.w-100 Buscar por auto
              select.form-control.rounded-pill.border-0#car-search(v-model="dataSearch")
                option(value="" v-for="item in 10" :key="item") Auto {{ item  }}
            .search-item(v-if="typeSearch == 'brand'")
              label.text-muted.text-md-right.w-100 Buscar por marca
              select.form-control.rounded-pill.border-0#brand-search(v-model="dataSearch")
                option(value="" v-for="item in 10" :key="item") Marca {{ item  }}
            .search-item(v-if="typeSearch == 'general'")
              label.text-muted.text-md-right.w-100 Búsqueda general
              .input-group.bg-white.rounded-pill.mr-0.ml-auto(style="overflow: hidden; max-width:400px;")
                input.form-control.border-0.border-0(type="text" placeholder="Buscar" style="box-shadow: none;" v-model="dataSearch")
                .input-group-prepend.p-0
                  .input-group-text.bg-transparent.border-0
                    span.oi.oi-magnifying-glass
        
        .text-left.text-md-right.mt-3
          button.btn.btn-info.btn-sm.rounded-pill(@click="searchData()" :disabled="dataSearch == ''")
            span(v-if="loading")
              i.spinner-border.mr-2
              span Buscando
            span(v-else) Buscar
            
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import MainProductsBrowser from './main-products-browser'
export default {
  components: {
    MainProductsBrowser
  },
  data(){
    return {
      typeSearch: '',
      searchProduct: false,
      dataSearch: '',
      loading: false
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
        type: this.typeSearch,
        data: this.dataSearch,
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
    padding: 30px
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
      max-height: 100vh
      height: auto
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