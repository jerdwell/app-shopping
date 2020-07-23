<template lang="pug">
  div
    label.text-center Auto:
    .input-group.mb-3.rounded-pill(style="overflow:hidden;")
      input.form-control.forn-control-sm(type="search" placeholder="Buscar" @change="serach_cars" v-model="car_search")
      .input-group-prepend
        .input-group-text
          i.oi.oi-magnifying-glass
    
    .text-center(v-if="loading")
      .spinner-border
    
    ul.list-group.bg-transparent.small(v-if="results")
      li.list-group-item.bg-transparent.p-1.border-secondary(v-for="(car, index) in cars.data" :key="index" v-show="cars.data.length > 0")
        label.mb-0
          input.form-control-checkbox.mr-2(type="radio" :name="car.shipowner_slug" :value="car.shipowner_slug" v-model="$parent.car_selected")
          span {{ car.shipowner_name }}

      li.list-group-item.bg-transparent.p-1.border-danger.text-danger(v-show="cars.data.length <= 0") #[span.oi.oi-circle-x] No existen resultados


</template>

<script>
export default {
  name: 'car-filters',
  data(){
    return {
      loading: false,
      results: false,
      cars: [
        'Audi',
        'Cavalier',
        'Ford',
        'Volvo'
      ],
      cars: [],
      car_search: ''
    }
  },
  methods: {
    async serach_cars(){
      if(this.car_search.replace(/\s/g, '').length <= 0) return false
      this.loading = true
      try {
        let cars = await this.$http.get(`/search-car/${this.car_search}`)
        this.loading = false
        this.results = true
        this.cars = cars
      } catch (error) {
      }
    }
  },
}
</script>

<style lang="sass" scoped>
  .input-group-prepend
    cursor: pointer
  input
    &:focus
      border: none
      box-shadow: none
</style>