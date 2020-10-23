<template lang="pug">
  .container-fluid
    .row
      CarFilters.col-md-6.col-lg-4
      YearsFilters.col-md-6.col-lg-2
      CategoryFilters.col-md-6.col-lg-3
      BrandFilters.col-md-6.col-lg-3
</template>

<script>
import { mapActions } from 'vuex'
import CarFilters from './component-filters/car-filters'
import YearsFilters from './component-filters/years-filters'
import CategoryFilters from './component-filters/category-filters'
import BrandFilters from './component-filters/brand-filters'
export default {
  name: 'filter-by-car',
  components: {
    CarFilters,
    YearsFilters,
    CategoryFilters,
    BrandFilters
  },
  data() {
    return {
      car_model_selected: {},
      year_selected: '',
      brand_selected: '',
      category_selected: '',
    }
  },
  methods: {
    ...mapActions([
      'clearProducts'
    ])
  },
  mounted(){
    this.clearProducts()
  }
}
</script>