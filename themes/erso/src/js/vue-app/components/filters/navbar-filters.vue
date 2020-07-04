<template lang="pug">
.navbar-filters
  .controll-filters
    button.btn.btn-block.rounded-pill.button-filters(v-show="!searchProduct" @click="searchProduct = true")
      .d-flex.justify-content-between.align-items-center
        span Buscar productos
        span.oi.oi-magnifying-glass
    button.btn.btn-block.btn-warning.bg-warning.rounded-pill.button-filters(v-show="searchProduct" @click="searchProduct = false")
      .d-flex.justify-content-between.align-items-center
        span.mr-2 Cancelar búsqueda
        span.oi.oi-x

  .filters.bg-dark(:class="!searchProduct ? 'filters-inactive' : ''")
    .row
      label.col-12.text-center Buscar por:
      label.col-4.col-md-2.offset-md-3.p-2.text-center
        input.form-check-input(type="radio" name="typeSearch" value="car" v-model="typeSearch")
        span.b-block Auto
      label.col-4.col-md-2.p-2.text-center
        input.form-check-input(type="radio" name="typeSearch" value="brand" v-model="typeSearch")
        span.b-block Marca
      label.col-4.col-md-2.p-2.text-center
        input.form-check-input(type="radio" name="typeSearch" value="general" v-model="typeSearch")
        span.b-block General


    .row(v-if="typeSearch != null")
      .col-md-4.search-item(v-if="typeSearch == 'car'")
        label Buscar por auto
        select.form-control.rounded-pill.border-0#car-search
          option(value="" v-for="item in 10" :key="item") Auto {{ item  }}
      .col-md-4.search-item(v-if="typeSearch == 'brand'")
        label Buscar por marca
        select.form-control.rounded-pill.border-0#brand-search
          option(value="" v-for="item in 10" :key="item") Marca {{ item  }}
      .col-md-4.search-item(v-if="typeSearch == 'general'")
        label Búsqueda general
        .input-group.bg-white.rounded-pill.mr-0.ml-auto(style="overflow: hidden; max-width:400px;")
          input.form-control.border-0.border-0(type="text" placeholder="Buscar" style="box-shadow: none;")
          .input-group-prepend.p-0
            .input-group-text.bg-transparent.border-0
              span.oi.oi-magnifying-glass

</template>

<script>
export default {
  data(){
    return {
      typeSearch: null,
      searchProduct: false
    }
  }
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
      background: #ffffff
      box-shadow: none
      outline: none
      max-width: 400px

  @media screen and (min-width: 768px)
    .controll-filters
      .button-filters
        margin-left: auto
        margin-bottom: 20px
        margin-right: 0
  
  @media screen and (min-width: 1024px)
    .filters
      left: 0
      padding-top: 140px
      position: fixed
      top: 0
      width: 100%
      width: 100%
    .controll-filters
      .button-filters
        display: block
        margin-bottom: 0
        width: 250px
  @media screen and (min-width: 1280px)
    .controll-filters
      .button-filters
        width: 350px

</style>