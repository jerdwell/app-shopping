<template lang="pug">
  div
    label.text-center.text-light Año
    .input-group.mb-3.rounded-pill(style="overflow:hidden;")
      .input-group-prepend
        .input-group-text
          i.fas.fa-list
      select.form-control.form-control-sm(
        v-model="$parent.year_selected"
        :disabled="$parent.car_selected == ''"
        @change="addYearsToFilter")
        option(value="") Selecciona una opción
        option(v-for="(year, index) in years" :key="index" :value="year") {{ year }}
    .text-center(v-if="loading")
      .spinner-border.text-light

</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'years-filters',
  data() {
    return {
      models: [],
      loading: false
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
    async addYearsToFilter(){
      this.loading = true
      this.$parent.car_model_selected['year'] = this.$parent.year_selected
      await this.serachProductModel(this.$parent.car_model_selected)
      this.loading = false
    }
  }
}
</script>