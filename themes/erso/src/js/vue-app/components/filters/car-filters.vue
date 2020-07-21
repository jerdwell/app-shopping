<template lang="pug">
  div
    label.text-center Auto:
    .input-group.mb-3.rounded-pill(style="overflow:hidden;")
      input.form-control.forn-control-sm(type="search" placeholder="Buscar" @change="serach_cars")
      .input-group-prepend
        .input-group-text
          i.oi.oi-magnifying-glass
    
    .text-center(v-if="loading")
      .spinner-border
    
    ul.list-group.bg-transparent.small(v-if="results")
      li.list-group-item.bg-transparent.p-1.border-secondary(v-for="(car, index) in cars" :key="index")
        label.mb-0
          input.form-control-checkbox.mr-2(type="checkbox" :value="car" v-model="$parent.car_search")
          span {{ car }}


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
      ]
    }
  },
  methods: {
    serach_cars(){
      this.loading = true
      setTimeout(() => {
        this.loading = false
        this.results = true
      }, 1500);
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