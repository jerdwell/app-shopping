<template lang="pug">
 .container
    .row
      ShipownerFilters.col-md-4
      YearsFilters.col-md-4
      CategoryFilters.col-md-4

</template>

<script>
import { mapActions } from 'vuex'
import ShipownerFilters from './component-filters/shipowner-filters'
import YearsFilters from './component-filters/years-filters'
import CategoryFilters from './component-filters/category-filters'
export default {
  name: 'filter-by-car',
  components: {
    YearsFilters,
    CategoryFilters,
    ShipownerFilters
  },
  data() {
    return {
      car_model_selected: {},
      category_selected: '',
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