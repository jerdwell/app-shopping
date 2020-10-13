<template lang="pug">
  div
    label.text-center.text-light Año
    select.form-control.form-control-sm.rounded-pill(
      v-model="$parent.year_selected"
      :disabled="$parent.car_selected == ''"
      @change="addYearsToFilter")
      option(value="") Selecciona una opción
      option(v-for="(year, index) in years" :key="index" :value="year") {{ year }}

</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'years-filters',
  data() {
    return {
      models: []
    }
  },
  computed: {
    ...mapGetters([
      'get_years_related'
    ]),
    years(){
      let years = []
      this.get_years_related.map(e => {
        years = [...e.year.split('-'), ...years]
      })
      let range = []
      let min = Math.min(...years)
      let max = Math.max(...years)
      while (min <= max) range.push(min++) 
      return range
    }
  },
  methods: {
    ...mapActions([
      'serachProductModel', //search products
    ]),
    addYearsToFilter(){
      this.$parent.car_model_selected['year'] = this.$parent.year_selected
      this.serachProductModel(this.$parent.car_model_selected)
    }
  }
}
</script>