<template lang="pug">
 .container-fluid
    .row
      ShipownerFilters.col-lg-4
      YearsFilters.col-md-6.col-lg-2
      CategoryFilters.col-md-6.col-lg-3
      BrandFilters.col-md-6.col-lg-2

</template>

<script>
import { mapActions } from 'vuex'
import ShipownerFilters from './component-filters/shipowner-filters'
import YearsFilters from './component-filters/years-filters'
import CategoryFilters from './component-filters/category-filters'
import BrandFilters from './component-filters/brand-filters'
export default {
  name: 'filter-by-car',
  components: {
    YearsFilters,
    CategoryFilters,
    ShipownerFilters,
    BrandFilters
  },
  data() {
    return {
      car_model_selected: {
        shipowner_id: '',
        model_id: ''
      },
      category_selected: '',
      brand_selected: '',
      year_selected: '',
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