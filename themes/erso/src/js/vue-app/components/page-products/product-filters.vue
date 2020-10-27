<template lang="pug">
  .py-4.bg-dark
    .products-loader(v-if="loading")
      .spinner-border.spinner-border-lg.text-light
    .container
      .row
        .col-12.py-0
          h5.text-light.my-0.p-0 Filtrar productos:
            a.text-light(href="/productos") #[i.fas.fa-home]
        //- category filter
        .col-6.col-md-3.col-lg-2.py-3.text-light
          products-category-filter(
            :categories="categories"
            :category="category"
            :model="model"
            :shipowner="shipowner"
            :year="year"
            :branch="branch")
        //- shipowner filter
        .col-6.col-md-3.py-3
          product-shipowner-filter(
            :shipowner_selected="shipowner_selected"
            :branch="branch"
            :category="category")
        //- car filter
        .col-6.col-md-3.col-lg-2.py-3
          products-cars-filter(
            :model_selected="model_selected"
            :shipowner="shipowner"
            :branch="branch"
            :category="category")
        //- years filter
        .col-6.col-md-3.col-lg-2.py-3
          products-years-filter(
            :category="category"
            :year="year"
            :shipowner="shipowner"
            :model="model"
            :branch="branch")
        //- brand filter
        .col-6.col-md-3.col-lg-2.py-3
          products-brand-filter(
            :category="category"
            :year="year"
            :shipowner="shipowner"
            :model="model"
            :brands="brands"
            :brand="brand"
            :branch="branch")

</template>

<script>
import productsCategoryFilter from './products-category-filter'
import productShipownerFilter from './product-shipowner-filter'
import productsCarsFilter from './products-cars-filter'
import productsYearsFilter from './products-years-filter'
import productsBrandFilter from './products-brand-filter'
export default {
  name: 'product-filters',
  data() {
    return {
      loading: true
    }
  },
  components: {
    productsCategoryFilter,
    productShipownerFilter,
    productsCarsFilter,
    productsYearsFilter,
    productsBrandFilter
  },
  props: [
    'category',
    'categories',
    'year',
    'model_selected',
    'shipowner_selected',
    'model',
    'shipowner',
    'branch',
    'list',
    'brands',
    'brand'
  ],
  mounted() {
    document.onreadystatechange = () => {
      if(document.readyState == 'complete') this.loading = false
    }
  },
}
</script>

<style lang="sass">
  .products-loader
    align-items: center
    background: rgba(#000, .9)
    display: flex
    justify-content: center
    left: 0
    height: 100%
    position: fixed
    top: 0
    width: 100%
    z-index: 1000
</style>