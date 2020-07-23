<template lang="pug">
  div
    .row
      CarFilters.col-md-4
      ModelFilters.col-md-4
      CategoryFilters.col-md-4
</template>

<script>
import CarFilters from './component-filters/car-filters'
import ModelFilters from './component-filters/model-filters'
import CategoryFilters from './component-filters/category-filters'
export default {
  name: 'filter-by-car',
  components: {
    CarFilters,
    ModelFilters,
    CategoryFilters,
  },
  data() {
    return {
      car_selected: '',
      category_selected: '',
      model_selected: '',
    }
  },
}
</script>